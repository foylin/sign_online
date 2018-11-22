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

            

            $signdata = array(
                'sign_status' => 1,
                'sign_url'    => $saveName,
                'update_time' => time()
            );
            $where['post_id'] = $param['protocol_id'];
            $where['category_id'] = $this->userId;
            Db::name('protocol_category_user_post')->where($where)->update($signdata);

            // 生成预览PDF文件
            createpdf($param['protocol_id'], $this->userId);
            // dump(Db::name('protocol_category_user_post')->getLastSql());
            $this->success("上传成功!", ['url' => $saveName]);
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }

    }


}
