<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------
namespace api\protocol\model;

use think\Db;
use api\common\model\CommonModel;

class ProtocolCategoryModel extends CommonModel
{
    //可查询字段
    // protected $visible = [
    //     'id', 'articles.id', 'user_id', 'post_id', 'post_type', 'comment_status',
    //     'is_top', 'recommended', 'post_hits', 'post_like', 'comment_count',
    //     'create_time', 'update_time', 'published_time', 'post_title', 'post_keywords',
    //     'post_excerpt', 'post_source', 'post_content', 'more', 'user_nickname',
    //     'user', 'category_id, sign_status, notes'
    // ];

    //类型转换
    protected $type = [
        'more' => 'array',
    ];
    
}
