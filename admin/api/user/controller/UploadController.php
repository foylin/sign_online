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
            // $res = seal($findFile['post_id'], $findFile['category_id'], 0, $pic_url, '', $findFile['place']);
            // if(!$res) $this->error('网络出错,请重试');

            $protocol = ProtocolPostModel::get($findFile['post_id']);
            $more = $protocol->categories->more;
            $_w = [];
            //签名
            if($findFile['place'] == 0) {
                $res = $more['axes'][0];
            }else if($findFile['place'] == 1) {
                $res = $more['axes'][1];
            }
            $write_data1 = [
                'pic'       => $pic_url,
                'page'      => $res['page'],
                'position'  => explode(',',$res['sign']),
                'size'      => 50
            ];
            array_push($_w,$write_data1);

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
                // $origin_pdf_url2 = ROOT_PATH .'/public/upload/' . $res;
                // $res2 = seal($findFile['post_id'], $findFile['category_id'], 1, $seal_url, $origin_pdf_url2);
                // if(!$res2) $this->error('网络出错，请重试');
                $write_data2 = [
                    'pic'       => $seal_url,
                    'page'      => $more['seal']['page'],
                    'position'  => explode(',', $more['seal']['sign']),
                    'size'      => 30
                ];
                array_push($_w, $write_data2);
            }

            $file = 'sign_'.$findFile['post_id'].'_'.$findFile['category_id'].'.pdf';
            if(!empty($findFile['view_file'])) {
                $origin_pdf_url = ROOT_PATH .'/public/upload/' . $findFile['view_file'];
            }else {
                $origin_pdf_url = ROOT_PATH .'/public/upload/protocol/pdf/' . $findFile['post_id'] . '.pdf';
            }
            
            $result = edit_pdf($origin_pdf_url, $_w, $file);

            if($result) {
                $signdata = array(
                    'sign_status' => 1,
                    'sign_url'    => $saveName,
                    'update_time' => time(),
                    'view_file'   => $result
                );
                
                $where['post_id'] = $param['protocol_id'];
                $where['category_id'] = $this->userId;
                Db::name('protocol_category_user_post')->where($where)->update($signdata);
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

            $frame = FrameCategoryModel::get(999);
            if(!$frame || empty($frame['more']['thumbnail'])) {
                $this->error('保密委公章未设置');
            }
            $seal_url = ROOT_PATH . '/public/upload/' . $frame['more']['thumbnail'];
            if(!file_exists($seal_url)) $this->error('保密委公章未设置');
            
            foreach($data as $k=>$v) {
                $origin_pdf_url = ROOT_PATH .'/public/upload/' . $v['view_file'];
                //签名
                // $result = seal($findFile['post_id'], $v['category_id'], 0, $pic_url, $origin_pdf_url, 1);
                //盖章
                // $result2 = seal($findFile['post_id'], $v['category_id'], 1, $seal_url, $origin_pdf_url, 1);
                //负责人签名参数
                $protocol = ProtocolPostModel::get($findFile['post_id']);
                $more = $protocol->categories->more;
                
                $_w = [
                    [
                        'pic'       => $pic_url,
                        'page'      => $more['axes'][1]['page'],
                        'position'  => explode(',',$more['axes'][1]['sign']),
                        'size'      => 50
                    ]
                    // ,
                    // [
                    //     'pic'       => $seal_url,
                    //     'page'      => $more['seal']['page'],
                    //     'position'  => explode(',',$more['seal']['sign']),
                    //     'size'      => 30
                    // ]
                    
                ];
                $file = 'sign_'.$findFile['post_id'].'_'.$v['category_id'].'.pdf';
                $result = edit_pdf($origin_pdf_url, $_w, $file);
                if($result) {
                    Db::name('protocol_category_user_post')->update(['id'=>$v['id'],'sign_status'=>2,'view_file'=>$result]);
                }
            }



            // 生成预览PDF文件
            // createpdf($param['protocol_id'], $this->userId);
            // dump(Db::name('protocol_category_user_post')->getLastSql());

            $this->success("上传成功!", ['url' => $saveName,'data'=>$data]);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }

    public function test() {

        $where['post_id'] = 47;
        $where['category_id'] = $this->userId;
        $findFile = Db::name('protocol_category_user_post')->where($where)->find();
        $frame = FrameCategoryModel::get(999);
            if(!$frame || empty($frame['more']['thumbnail'])) {
                $this->error('保密委公章未设置');
            }
            $seal_url = ROOT_PATH . '/public/upload/' . $frame['more']['thumbnail'];
        $origin_pdf_url = ROOT_PATH .'/public/upload/view/sign_47_16.pdf';
        $pic_url = ROOT_PATH . '/public/upload/1544033074.png';
        // $result2 = seal($findFile['post_id'], 16, 1, $seal_url, $origin_pdf_url);
        $protocol = ProtocolPostModel::get($findFile['post_id']);
                $more = $protocol->categories->more;
                
                $_w = [
                    [
                        'pic'       => $pic_url,
                        'page'      => $more['axes'][1]['page'],
                        'position'  => explode(',',$more['axes'][1]['sign']),
                        'size'      => 50
                    ],
                    [
                        'pic'       => $seal_url,
                        'page'      => $more['seal']['page'],
                        'position'  => explode(',',$more['seal']['sign']),
                        'size'      => 30
                    ]
                ];
                $file = 'sign_'.$findFile['post_id'].'_16.pdf';
                $result = edit_pdf($origin_pdf_url, $_w, $file);
        $this->success('ok', $result);
    }

}
