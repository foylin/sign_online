<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------

namespace api\protocol\model;
use api\common\model\CommonModel;
use api\protocol\model\FrameCategoryPostModel;

class UserModel extends CommonModel
{
    //可查询字段
//    protected $visible = [
//        'articles.id', 'user_nickname', 'avatar', 'signature','user'
//    ];
    //模型关联方法
    protected $relationFilter = ['user'];

    public function FrameCategoryPost()
    {
        return $this->hasOne('FrameCategoryPostModel', 'post_id', 'id');
    }

    /**
     * 基础查询
     */
    protected function base($query)
    {
        $query->alias('user')->where('user.user_status', 1);
    }

    /**
     * more 自动转化
     * @param $value
     * @return array
     */
    public function getAvatarAttr($value)
    {
        $value = !empty($value) ? cmf_get_image_url($value) : $value;
        return $value;
    }

    /**
     * 关联 user表
     * @return $this
     */
    public function user()
    {
        return $this->belongsTo('UserModel', 'user_id')->setEagerlyType(1);
    }
}
