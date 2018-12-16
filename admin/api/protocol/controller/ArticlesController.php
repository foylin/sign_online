<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------

namespace api\protocol\controller;

use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;
use api\protocol\model\ProtocolPostModel;



class ArticlesController extends RestUserBaseController
{
    protected $postModel;

    public function __construct(ProtocolPostModel $postModel)
    {
        parent::__construct();
        $this->postModel = $postModel;
    }

    /**
     * 文章列表
     */
    public function index()
    {

        $params                       = $this->request->get();
        
        $params['where']['post_type'] = 1;
        $data                         = $this->postModel->getDatas($params);
        // $this->success('请求成功!', $data);
        if (isset($this->apiVersion)) {
            $response = ['list' => $data];
        } else {
            $response = $data;
        }
        $this->success('请求成功!', $response);
    }

    /**
     * 获取指定的协议书
     * @param int $id
     */
    public function read($id)
    {
        if (intval($id) === 0) {
            $this->error('无效id！');
        } else {
            $params                       = $this->request->get();
            // $params['where']['post_type'] = 1;
            // $params['id']                 = $id;

            $userId = $this->getUserId();

            // $data                         = $this->postModel->getDatas($params);
            // $data                         = $this->postModel->where($params['where'])->select();
            $data = $this->postModel->setCondition($params)->alias('a')
            ->join('__PROTOCOL_CATEGORY_USER_POST__ tp', 'a.id = tp.post_id')->field('a.id, a.post_title, a.post_content, tp.sign_status, tp.notes')
            ->where(['a.post_status' => 1, 'tp.post_id' => $id, 'tp.category_id' => $userId])->find();
            if (empty($data)) {
                $this->error('协议书不存在！');
            } else {
                $this->postModel->where('id', $id)->setInc('post_hits');
                $this->success('请求成功!', $data);
            }

        }
    }

    /**
     * 我的文章列表
     */
    public function my()
    {
        $params = $this->request->get();
        $userId = $this->getUserId();
        $data   = $this->postModel->getUserArticles($userId, $params);
        $this->success('请求成功!', $data);
    }

    /**
     * 添加文章
     */
    public function save()
    {
        $data            = $this->request->post();
        $data['user_id'] = $this->getUserId();
        $result          = $this->validate($data, 'Articles.article');
        if ($result !== true) {
            $this->error($result);
        }

        if (empty($data['published_time'])) {
            $data['published_time'] = time();
        }

        $this->postModel->addArticle($data);
        $this->success('添加成功！');
    }

    /**
     * 更新文章
     * @param  int $id
     */
    public function update($id)
    {
        $data   = $this->request->put();
        $result = $this->validate($data, 'Articles.article');
        if ($result !== true) {
            $this->error($result);
        }
        if (empty($id)) {
            $this->error('无效的文章id');
        }
        $result = $this->postModel->editArticle($data, $id, $this->getUserId());
        if ($result === false) {
            $this->error('编辑失败！');
        } else {
            $this->success('编辑成功！');
        }
    }

    /**
     * 删除文章
     * @param  int $id
     */
    public function delete($id)
    {
        if (empty($id)) {
            $this->error('无效的文章id');
        }
        $result = $this->postModel->deleteArticle($id, $this->getUserId());
        if ($result == -1) {
            $this->error('文章已删除');
        }
        if ($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 批量删除文章
     */
    public function deletes()
    {
        $ids = $this->request->post('ids/a');
        if (empty($ids)) {
            $this->error('文章id不能为空');
        }
        $result = $this->postModel->deleteArticle($ids, $this->getUserId());
        if ($result == -1) {
            $this->error('文章已删除');
        }
        if ($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }

    public function search()
    {
        $params = $this->request->get();
        if (!empty($params['keyword'])) {
            $params['where'] = [
                'post_type'                             => 1,
                'post_title|post_keywords|post_excerpt' => ['like', '%' . $params['keyword'] . '%']
            ];
            $data            = $this->postModel->getDatas($params);
            $this->success('请求成功!', $data);
        } else {
            $this->error('搜索关键词不能为空！');
        }

    }
}