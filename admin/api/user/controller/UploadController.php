<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\user\controller;

use cmf\controller\RestUserBaseController;
use think\Db;
use think\Validate;
use think\Image;
use api\protocol\model\ProtocolPostModel;
use api\protocol\model\FrameCategoryModel;

class UploadController extends RestUserBaseController
{
    // 签名图片上传
    public function one()
    {
        $validate = new Validate([
            'protocol_id'          => 'require'
        ]);

        $validate->message([
            'protocol_id.require'          => '协议不存在！'
        ]);

        $param = $this->request->param();
        if (!$validate->check($param)) {
            $this->error($validate->getError());
        }

        $file = $this->request->file('file');

        $image = Image::open($file);
        $image->rotate(-90);

        

        // 移动到框架应用根目录/public/upload/ 目录下
        $info     = $file->validate([
            /*'size' => 15678,*/
            'ext' => 'jpg,png,gif'
        ]);
        $fileMd5  = $info->md5();
        $fileSha1 = $info->sha1();

        // $findFile = Db::name("asset")->where('file_md5', $fileMd5)->where('file_sha1', $fileSha1)->find();
        $where['post_id'] = $param['protocol_id'];
        $where['category_id'] = $this->userId;
        $findFile = Db::name('protocol_category_user_post')->where($where)->find();

        if (!empty($findFile) && $findFile['sign_status'] == 1 && !empty($findFile['sign_url'])) {
            $this->success("请勿重复上传!", ['url' => $findFile['sign_url']]);
        }
        // $info = $info->move(ROOT_PATH . 'public' . DS . 'upload');

        $saveName = time().'.png';
        $image->save(ROOT_PATH.'public/upload/'.$saveName);

        if ($info) {
            // $saveName     = $info->getSaveName();
            // $originalName = $info->getInfo('name');//name,type,size
            // $fileSize     = $info->getInfo('size');
            // $suffix       = $info->getExtension();

            // $fileKey = $fileMd5 . md5($fileSha1);

            // $userId = $this->getUserId();
            // Db::name('asset')->insert([
            //     'user_id'     => $userId,
            //     'file_key'    => $fileKey,
            //     'filename'    => $originalName,
            //     'file_size'   => $fileSize,
            //     'file_path'   => $saveName,
            //     'file_md5'    => $fileMd5,
            //     'file_sha1'   => $fileSha1,
            //     'create_time' => time(),
            //     'suffix'      => $suffix
            // ]);

            $pic_url = ROOT_PATH . '/public/upload/' . $saveName;
            $res = seal($findFile['post_id'], $findFile['category_id'], 0, $pic_url, '', $findFile['place']);
            if(!$res) $this->error('网络出错,请重试');

            //检查是否为涉密文件 涉密文件自动添加保密委章
            $protocol2 = ProtocolPostModel::get($findFile['post_id']);
            if($protocol2->categories->mode_type == 3) {
                $frame = FrameCategoryModel::get(999);
                if(!$frame || empty($frame['more']['thumbnail'])) {
                    $this->error('保密委公章未设置');
                }
                $seal_url = ROOT_PATH . '/public/upload/' . $frame['more']['thumbnail'];
                if(!file_exists($seal_url)) $this->error('保密委公章未设置');

                //生成
                $origin_pdf_url2 = ROOT_PATH .'/public/upload/' . $res;
                $res2 = seal($findFile['post_id'], $findFile['category_id'], 1, $seal_url, $origin_pdf_url2);
                if(!$res2) $this->error('网络出错，请重试');
            }


            $signdata = array(
                'sign_status' => 1,
                'sign_url'    => $saveName,
                'update_time' => time()
            );
            if($protocol2->categories->mode_type == 3) {
                $signdata['view_file'] = $res2;
            }else {
                $signdata['view_file'] = $res;
            }
            $where['post_id'] = $param['protocol_id'];
            $where['category_id'] = $this->userId;
            Db::name('protocol_category_user_post')->where($where)->update($signdata);



            // 生成预览PDF文件
            // createpdf($param['protocol_id'], $this->userId);
            // dump(Db::name('protocol_category_user_post')->getLastSql());

            $this->success("上传成功!", ['url' => $saveName]);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }

    }


    public function more() {

        $validate = new Validate([
            'protocol_id'          => 'require'
        ]);

        $validate->message([
            'protocol_id.require'          => '协议不存在！'
        ]);

        $param = $this->request->param();
        if (!$validate->check($param)) {
            $this->error($validate->getError());
        }

        $file = $this->request->file('file');

        $image = Image::open($file);
        $image->rotate(-90);

        

        // 移动到框架应用根目录/public/upload/ 目录下
        $info     = $file->validate([
            /*'size' => 15678,*/
            'ext' => 'jpg,png,gif'
        ]);
        $fileMd5  = $info->md5();
        $fileSha1 = $info->sha1();

        // $findFile = Db::name("asset")->where('file_md5', $fileMd5)->where('file_sha1', $fileSha1)->find();
        $where['post_id'] = $param['protocol_id'];
        $where['category_id'] = $this->userId;
        $findFile = Db::name('protocol_category_user_post')->where($where)->find();

        if (!empty($findFile) && $findFile['sign_status'] == 1 && !empty($findFile['sign_url'])) {
            $this->success("请勿重复上传!", ['url' => $findFile['sign_url']]);
        }
        // $info = $info->move(ROOT_PATH . 'public' . DS . 'upload');

        $saveName = time().'.png';
        $image->save(ROOT_PATH.'public/upload/'.$saveName);

        if ($info) {
            

            $pic_url = ROOT_PATH . '/public/upload/' . $saveName;  //负责人签名图片
            //循环签名
            $category_id = Db::name('frame_category_post')->where('post_id',$this->userId)->value('category_id');

            $user_ids = Db::name('frame_category_post')
                    ->where('category_id',$category_id)
                    ->where('status',1)
                    ->where('post_id','<>',$this->userId)
                    ->column('post_id');
            $data = Db::name('protocol_category_user_post')->alias('pu')
                ->field('pu.id,pu.category_id,pu.view_file,pu.place')
                ->join('__PROTOCOL_POST__ p','pu.post_id = p.id','left')
                ->where('pu.category_id','in',$user_ids)
                ->where('pu.place',0)
                ->where('pu.sign_status', 1)
                ->where('pu.post_id', $findFile['post_id'])
                ->select();
            
            foreach($data as $k=>$v) {
                $origin_pdf_url = ROOT_PATH .'/public/upload/' . $v['view_file'];
                $result = seal($findFile['post_id'], $v['category_id'], 0, $pic_url, $origin_pdf_url, 1);
                if($result) {
                    Db::name('protocol_category_user_post')->update(['id'=>$v['id'],'sign_status'=>2,'view_file'=>$result]);
                }
            }



            // 生成预览PDF文件
            // createpdf($param['protocol_id'], $this->userId);
            // dump(Db::name('protocol_category_user_post')->getLastSql());

            $this->success("上传成功!", ['url' => $saveName]);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }

}
