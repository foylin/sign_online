<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\protocol\validate;

use think\Validate;

class AdminIndexValidate extends Validate
{
    protected $rule = [
        'protocol_category_id' => 'require',
        'post_title' => 'require',
    ];
    protected $message = [
        'protocol_category_id.require' => '请选择协议模板！',
        'categories_seal.require' => '请指定行政公章！',
        'categories_user.require' => '请指定签约用户！',
        'post_title.require' => '协议标题不能为空！',
    ];

    protected $scene = [
//        'add'  => ['user_login,user_pass,user_email'],
//        'edit' => ['user_login,user_email'],
    ];
}