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
use think\Db;
// use think\Model;

class FrameCategoryPostModel extends CommonModel
{

	//获取部门下其他员工
	public function getChildStaff($userId) {

		$category_id = Db::name('frame_category_post')->where('post_id',$userId)->value('category_id');

        $user_ids = Db::name('frame_category_post')
                ->where('category_id',$category_id)
                ->where('status',1)
                ->where('post_id','<>',$userId)
                ->column('post_id');
        return $user_ids;
	}
}
