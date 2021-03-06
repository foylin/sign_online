<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\user\controller;

use think\Db;
use think\Validate;
use cmf\controller\RestBaseController;

class PublicController extends RestBaseController
{
    // 用户注册
    public function register()
    {
        $validate = new Validate([
            'username'          => 'require',
            'password'          => 'require',
            'verification_code' => 'require'
        ]);

        $validate->message([
            'username.require'          => '请输入手机号',
            'password.require'          => '请输入您的密码!',
            'verification_code.require' => '请输入数字验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $user = [];

        $userQuery = Db::name("user");

        // if (Validate::is($data['username'], 'email')) {
        //     $user['user_email'] = $data['username'];
        //     $userQuery          = $userQuery->where('user_email', $data['username']);
        // } else 
        if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
            $user['mobile'] = $data['username'];
            $userQuery      = $userQuery->where('mobile', $data['username']);
        } else {
            $this->error("请输入正确的手机");
        }

        $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        if (!empty($errMsg)) {
            $this->error($errMsg);
        }

        $findUserCount = $userQuery->count();

        if ($findUserCount > 0) {
            $this->error("此账号已存在!");
        }

        $user['create_time'] = time();
        $user['user_status'] = 1;
        $user['user_type']   = 2;
        $user['user_pass']   = cmf_password($data['password']);

        $result = $userQuery->insert($user);


        if (empty($result)) {
            $this->error("注册失败,请重试!");
        }

        $this->success("注册并激活成功,请登录!");

    }

    // 用户登录 TODO 增加最后登录信息记录,如 ip
    public function login()
    {
        $validate = new Validate([
            'username' => 'require',
            'password' => 'require'
        ]);
        $validate->message([
            'username.require' => '请输入手机号或者工号',
            'password.require' => '请输入您的密码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $userQuery = Db::name("user");
        // if (Validate::is($data['username'], 'email')) {
        //     $userQuery = $userQuery->where('user_email', $data['username']);
        // } else 
        if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
            $userQuery = $userQuery->where('mobile', $data['username']);
        } else {
            // $userQuery = $userQuery->where('user_login', $data['username']);
            $userQuery = $userQuery->where('user_sn', $data['username']);
        }

        $findUser = $userQuery->find();

        if (empty($findUser)) {
            $this->error("用户不存在!");
        } else {

            switch ($findUser['user_status']) {
                case 0:
                    $this->error('您已被拉黑!');
                // case 2:
                //     $this->error('账户还没有验证成功!');
            }

            if (!cmf_compare_password($data['password'], $findUser['user_pass'])) {
                $this->error("密码不正确!");
            }
        }

        $allowedDeviceTypes = ['mobile', 'android', 'iphone', 'ipad', 'web', 'pc', 'mac', 'wxapp'];

        if (empty($data['device_type']) || !in_array($data['device_type'], $allowedDeviceTypes)) {
            $this->error("请求错误,未知设备!");
        }

        unset($findUser['user_pass']);
        if($findUser['user_type'] == 2) {
            $fData = Db::name('frame_category_post')->field('type,is_sec')->where('post_id',$findUser['id'])->find();
            $findUser['staff_type'] = $fData['type'];
            $findUser['is_sec'] = $fData['is_sec'];
        } else {
            $findUser['staff_type'] = -1;
            $findUser['is_sec'] = -1;
        }

        $userTokenQuery = Db::name("user_token")
            ->where('user_id', $findUser['id'])
            ->where('device_type', $data['device_type']);
        $findUserToken  = $userTokenQuery->find();
        $currentTime    = time();
        $expireTime     = $currentTime + 24 * 3600 * 180;
        $token          = md5(uniqid()) . md5(uniqid());
        if (empty($findUserToken)) {
            $result = $userTokenQuery->insert([
                'token'       => $token,
                'user_id'     => $findUser['id'],
                'expire_time' => $expireTime,
                'create_time' => $currentTime,
                'device_type' => $data['device_type']
            ]);
        } else {
            $result = $userTokenQuery
                ->where('user_id', $findUser['id'])
                ->where('device_type', $data['device_type'])
                ->update([
                    'token'       => $token,
                    'expire_time' => $expireTime,
                    'create_time' => $currentTime
                ]);
        }

        $frame_data = Db::name('frame_category')->alias('fc')->join('__FRAME_CATEGORY_POST__ fcp', 'fc.id = fcp.category_id')
        ->where(['fcp.post_id'=>$findUser['id']])->find();
        $findUser['frame'] = $frame_data['name'];

        if (empty($result)) {
            $this->error("登录失败!");
        }

        $this->success("登录成功!", ['token' => $token, 'user' => $findUser]);
    }

    // 用户退出
    public function logout()
    {
        $userId = $this->getUserId();
        Db::name('user_token')->where([
            'token'       => $this->token,
            'user_id'     => $userId,
            'device_type' => $this->deviceType
        ])->update(['token' => '']);

        $this->success("退出成功!");
    }

    // 用户密码重置
    public function passwordReset()
    {
        $validate = new Validate([
            'username'          => 'require',
            'password'          => 'require',
            'verification_code' => 'require'
        ]);

        $validate->message([
            'username.require'          => '请输入手机号,邮箱!',
            'password.require'          => '请输入您的密码!',
            'verification_code.require' => '请输入数字验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $userWhere = [];
        if (Validate::is($data['username'], 'email')) {
            $userWhere['user_email'] = $data['username'];
        } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
            $userWhere['mobile'] = $data['username'];
        } else {
            $this->error("请输入正确的手机或者邮箱格式!");
        }

        $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        if (!empty($errMsg)) {
            $this->error($errMsg);
        }

        $userPass = cmf_password($data['password']);
        Db::name("user")->where($userWhere)->update(['user_pass' => $userPass]);

        $this->success("密码重置成功,请使用新密码登录!");

    }

    // 用户密码重置
    public function newPasswordReset()
    {
        $validate = new Validate([
            'new_password'          => 'require',
            'again_password'          => 'require'
        ]);

        $validate->message([
            'new_password.require'          => '请输入新密码!',
            'again_password.require'          => '请输入重复新密码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $userId = $this->getUserId();

        if(!$userId) $this->error('操作失败');
        $userWhere['id'] = $userId;
        $userPass = cmf_password($data['new_password']);
        Db::name("user")->where($userWhere)->update(['user_pass' => $userPass]);

        $this->success("密码重置成功,请使用新密码登录!");

    }

    public function toVerify() {

        $validate = new Validate([
            'mobile'          => 'require',
            'code'          => 'require'
        ]);

        $validate->message([
            'mobile.require'          => '请输入手机号',
            'code.require' => '请输入数字验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $user = Db::name('user')->where('mobile',$data['mobile'])->find();
        if(!$user) $this->error('用户不存在，请联系管理员');

        //新增短信验证
        $sms = DB::name('sms')->where('mobile',$data['mobile'])->order('id desc')->find();
        if(!$sms || $sms['code']!=$data['code']) {
            $this->error('验证码错误');
        } 

        // if($data['code'] != '1234') $this->error('验证码错误');

        $update = ['user_status'=>1];
        if(empty($user['mobile'])) {
            $update['mobile'] = $data['mobile'];
        }
        $map['mobile'] = $data['mobile'];
        Db::name('user')->where($map)->update($update);
        $this->success('ok');
    }


    public function get_protocol_title(){
        $data = $this->request->param();
        $protocol_id = isset($data['protocol_id']) ? $data['protocol_id'] : 0;
        $post_title = Db::name('protocol_post')->alias('pp')->join('__PROTOCOL_CATEGORY__ pc', 'pp.protocol_category_id = pc.id')
        ->where('pp.id='.$protocol_id)->value('pc.name');
        if($post_title){
            $this->success('success', ['post_title'=>$post_title]);
        }else{
            $this->error('协议书不存在');
        }
    }
}
