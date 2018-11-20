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

class ListsController extends RestUserBaseController
{

    protected $postModel;

    public function __construct(ProtocolPostModel $postModel)
    {
        parent::__construct();
        $this->postModel = $postModel;
    }


    /**
     * 协议书任务
     */
    public function index(){
        $params                       = $this->request->get();
        // $params['where']['post_type'] = 1;
        $userId = $this->getUserId();
        
        if($params['status'] == 1){
            $where['tp.sign_status'] = 1;
        }elseif($params['status'] == 2){
            $where['tp.sign_status'] = 2;
        }
        $where['a.post_status'] = 1;
        $where['tp.category_id'] = $userId;
        $data = $this->postModel->setCondition($params)->alias('a')
        ->join('__PROTOCOL_CATEGORY_USER_POST__ tp', 'a.id = tp.post_id', 'LEFT')
        ->field('a.id, a.post_title, tp.sign_status, tp.notes')
        ->where($where)->select();

        // $articles = $postModel->setCondition($params)->alias('a')->join('__PORTAL_TAG_POST__ tp', 'a.id = tp.post_id')
        //         ->where(['post_status' => 1])->select();

        // dump($userId);
        if (isset($this->apiVersion)) {
            $response = ['list' => $data,];
        } else {
            $response = $data;
        }

        // dump($response);
        $this->success('请求成功!', $response);
    }

    /**
     * [推荐文章列表]
     * @Author:   wuwu<15093565100@163.com>
     * @DateTime: 2017-07-17T11:36:51+0800
     * @since:    1.0
     */
    public function recommended()
    {
        $param           = $this->request->param();
        $protocolPostModel = new ProtocolPostModel();

        $param['where'] = ['recommended' => 1];

        $articles = $protocolPostModel->getDatas($param);

        $this->success('ok', ['list' => $articles]);
    }

    /**
     * [getCategoryPostLists 分类文章列表]
     * @Author:    wuwu<15093565100@163.com>
     * @DateTime: 2017-07-17T15:22:41+0800
     * @since:    1.0
     */
    public function getCategoryPostLists()
    {
        $categoryId = $this->request->param('category_id', 0, 'intval');


        $protocolCategoryModel = new  protocolCategoryModel();

        $findCategory = $protocolCategoryModel->where('id', $categoryId)->find();

        //分类是否存在
        if (empty($findCategory)) {
            $this->error('分类不存在！');
        }

        $param = $this->request->param();

        $articles = $protocolCategoryModel->paramsFilter($param, $findCategory->articles()->alias('post'))->select();

        if (!empty($param['relation'])) {
            if (count($articles) > 0) {
                $articles->load('user');
                $articles->append(['user']);
            }
        }

        $this->success('ok', ['list' => $articles]);
    }

}
