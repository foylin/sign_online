<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuwu <15093565100@163.com>
// +----------------------------------------------------------------------
namespace api\protocol\controller;

use api\protocol\model\ProtocolCategoryModel;
use api\protocol\model\ProtocolPostModel;
use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;

use think\Db;

class DownloadController extends RestUserBaseController
{

    protected $postModel;

    public function __construct(ProtocolPostModel $postModel)
    {
        parent::__construct();
        $this->postModel = $postModel;
    }


    /**
     * 协议书下载
     */
    public function index(){
        $params                       = $this->request->get();
        // $params['where']['post_type'] = 1;
        $userId = $this->getUserId();
        
        
        $where['a.post_status'] = 1;
        $where['tp.category_id'] = $userId;
        $data = $this->postModel->setCondition($params)->alias('a')
        ->join('__PROTOCOL_CATEGORY_USER_POST__ tp', 'a.id = tp.post_id', 'LEFT')
        ->field('a.id, a.post_title, tp.sign_status, tp.notes')
        ->where($where)->select();

        // $articles = $postModel->setCondition($params)->alias('a')->join('__PORTAL_TAG_POST__ tp', 'a.id = tp.post_id')
        //         ->where(['post_status' => 1])->select();

        // dump($this->postModel->getLastSql());
        foreach ($data as &$val) {
            # code...
            $category_where['pcp.post_id'] = $val['id'];
            $category_where['pc.delete_time'] = 0;
            $category = Db::name('protocol_category')->alias('pc')
            ->join('__PROTOCOL_CATEGORY_POST__ pcp', 'pc.id = pcp.category_id')
            ->where($category_where)->find();
            $download = json_decode($category['more'], true);
            $files = $download['files'][0];
            $files['url'] = cmf_get_image_preview_url($files['url']);

            $name_arr = explode('.', $files['name']);
            $files['ext'] = $name_arr[1];
            $val['download'] = $files;
        }
        if (isset($this->apiVersion)) {
            $response = ['list' => $data,];
        } else {
            $response = $data;
        }

        // dump($response);
        $this->success('请求成功!', $response);
    }

}
