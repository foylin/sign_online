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
namespace app\protocol\controller;

use app\admin\model\RouteModel;
use cmf\controller\AdminBaseController;
use app\seal\model\SealCategoryModel;
use think\Db;
use app\admin\model\ThemeModel;


class AdminCoorController extends AdminBaseController
{
    /**
     * 获取PDF 坐标
     */
    public function index()
    {
        return $this->fetch();
    }
}
