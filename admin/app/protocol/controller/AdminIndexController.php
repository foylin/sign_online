<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\protocol\controller;

use cmf\controller\AdminBaseController;
use app\protocol\model\ProtocolPostModel;
use app\protocol\service\PostService;
use app\protocol\model\ProtocolCategoryModel;
use think\Db;
use app\admin\model\ThemeModel;

use Dompdf\Dompdf;

class AdminIndexController extends AdminBaseController
{
    /**
     * 文章列表
     * @adminMenu(
     *     'name'   => '文章管理',
     *     'parent' => 'protocol/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $content = hook_one('protocol_admin_article_index_view');

        if (!empty($content)) {
            return $content;
        }

        $param = $this->request->param();

        $categoryId = $this->request->param('category', 0, 'intval');

        $postService = new PostService();
        $data        = $postService->adminArticleList($param);

        $data->appends($param);

        $protocolCategoryModel = new ProtocolCategoryModel();
        $categoryTree        = $protocolCategoryModel->adminCategoryTree($categoryId);
        // dump($data->items());

        $protocol_data = $data->items();
        foreach ($protocol_data as $key => $value) {
            $protocol_data[$key]['un_sign'] = Db::name('protocol_category_user_post')->where(['post_id' => $value['id'], 'sign_status' => ['neq', 2]])->count();
        }

        // dump(Db::name('protocol_category_user_post')->getLastSql());

        // $postCategories_user  = $post->categories_user()->alias('a')->column('a.user_login, sign_status, sign_url, notes, a.id AS user_id, pivot.id AS protocol_id', 'a.id');
        $this->assign('start_time', isset($param['start_time']) ? $param['start_time'] : '');
        $this->assign('end_time', isset($param['end_time']) ? $param['end_time'] : '');
        $this->assign('keyword', isset($param['keyword']) ? $param['keyword'] : '');
        $this->assign('articles', $data->items());
        $this->assign('category_tree', $categoryTree);
        $this->assign('category', $categoryId);
        $this->assign('page', $data->render());


        return $this->fetch();
    }

    /**
     * 添加文章
     * @adminMenu(
     *     'name'   => '添加文章',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加文章',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $content = hook_one('protocol_admin_article_add_view');

        if (!empty($content)) {
            return $content;
        }

        $protocolCategoryModel = new ProtocolCategoryModel();
        $where      = ['delete_time' => 0];
        $categories_model = $protocolCategoryModel->field('id, name')->where($where)->select();
        $this->assign('categories_model', $categories_model);

        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');
        $this->assign('article_theme_files', $articleThemeFiles);
        return $this->fetch();
    }

    /**
     * 添加文章提交
     * @adminMenu(
     *     'name'   => '添加文章提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加文章提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();

            //状态只能设置默认值。未发布、未置顶、未推荐
            $data['post']['post_status'] = 1;
            $data['post']['is_top']      = 0;
            $data['post']['recommended'] = 0;
            $data['post']['published_time'] = time();

            $post = $data['post'];

            $result = $this->validate($post, 'AdminIndex');
            if ($result !== true) {
                $this->error($result);
            }

            $protocolPostModel = new ProtocolPostModel();

            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }

            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $data['post']['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }


            $protocolPostModel->adminAddArticle($data['post'], $data['post']['categories'], $data['post']['categories_seal'], $data['post']['categories_user']);

            $data['post']['id'] = $protocolPostModel->id;
            $hookParam          = [
                'is_add'  => true,
                'article' => $data['post']
            ];
            hook('protocol_admin_after_save_article', $hookParam);


            $this->success('添加成功!', url('AdminIndex/edit', ['id' => $protocolPostModel->id]));
        }

    }

    /**
     * 编辑文章
     * @adminMenu(
     *     'name'   => '编辑文章',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑文章',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $content = hook_one('protocol_admin_article_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');

        $protocolPostModel = new ProtocolPostModel();
        $post            = $protocolPostModel->where('id', $id)->find();
        $postCategories  = $post->categories()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds = implode(',', array_keys($postCategories));
        $this->assign('post_categories', $postCategories);
        $this->assign('post_category_ids', $postCategoryIds);
        // dump($postCategoryIds);
        $protocolCategoryModel = new ProtocolCategoryModel();
        $where      = ['delete_time' => 0];
        $categories_model = $protocolCategoryModel->field('id, name')->where($where)->select();
        $this->assign('categories_model', $categories_model);
        // dump($categories);

        $postCategories_seal  = $post->categories_seal()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds_seal = implode(',', array_keys($postCategories_seal));
        $this->assign('post_categories_seal', $postCategories_seal);
        $this->assign('post_category_ids_seal', $postCategoryIds_seal);

        $postCategories_user  = $post->categories_user()->alias('a')->column('a.user_login', 'a.id');
        $postCategoryIds_user = implode(',', array_keys($postCategories_user));
        $this->assign('post_categories_user', $postCategories_user);
        $this->assign('post_category_ids_user', $postCategoryIds_user);

        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');
        $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('post', $post);
        

        // $filename = '/home/lin/下载/四书模板/四书模板/xxxx保密工作责任书（通用部门）.doc';

        // $content = shell_exec('/usr/local/bin/antiword -m UTF-8.txt '.$filename);  
        // dump($content);
        // $this->assign('content', $content);
        return $this->fetch();

        // reference the Dompdf namespace
            

            // instantiate and use the dompdf class
            // $dompdf = new Dompdf();

            // $header = "<style>* {font-family: simsun!important}</style>";

            // $html = $header.$post['post_content'];

            // $dompdf->loadHtml($html);

            // // Render the HTML as PDF
            // $dompdf->render();
            // // Output the generated PDF to Browser
            // $dompdf->stream();
    }

    /**
     * 编辑文章提交
     * @adminMenu(
     *     'name'   => '编辑文章提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑文章提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {

        if ($this->request->isPost()) {
            $data = $this->request->param();

            //需要抹除发布、置顶、推荐的修改。
            unset($data['post']['post_status']);
            unset($data['post']['is_top']);
            unset($data['post']['recommended']);

            $post   = $data['post'];
            $result = $this->validate($post, 'AdminIndex');
            if ($result !== true) {
                $this->error($result);
            }

            $protocolPostModel = new ProtocolPostModel();

            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }

            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $data['post']['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }

            $protocolPostModel->adminEditArticle($data['post'], $data['post']['categories'], $data['post']['categories_seal'], $data['post']['categories_user']);

            $hookParam = [
                'is_add'  => false,
                'article' => $data['post']
            ];
            hook('protocol_admin_after_save_article', $hookParam);

            $this->success('保存成功!');

            

        }
    }

    /**
     * 文章删除
     * @adminMenu(
     *     'name'   => '文章删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $param           = $this->request->param();
        $protocolPostModel = new ProtocolPostModel();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            $result       = $protocolPostModel->where(['id' => $id])->find();
            $data         = [
                'object_id'   => $result['id'],
                'create_time' => time(),
                'table_name'  => 'protocol_post',
                'name'        => $result['post_title'],
                'user_id'     => cmf_get_current_admin_id()
            ];
            $resultprotocol = $protocolPostModel
                ->where(['id' => $id])
                ->update(['delete_time' => time()]);
            if ($resultprotocol) {
                Db::name('protocol_category_post')->where(['post_id' => $id])->update(['status' => 0]);
                Db::name('protocol_tag_post')->where(['post_id' => $id])->update(['status' => 0]);

                Db::name('recycleBin')->insert($data);
            }
            $this->success("删除成功！", '');

        }

        if (isset($param['ids'])) {
            $ids     = $this->request->param('ids/a');
            $recycle = $protocolPostModel->where(['id' => ['in', $ids]])->select();
            $result  = $protocolPostModel->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            if ($result) {
                Db::name('protocol_category_post')->where(['post_id' => ['in', $ids]])->update(['status' => 0]);
                Db::name('protocol_tag_post')->where(['post_id' => ['in', $ids]])->update(['status' => 0]);
                foreach ($recycle as $value) {
                    $data = [
                        'object_id'   => $value['id'],
                        'create_time' => time(),
                        'table_name'  => 'protocol_post',
                        'name'        => $value['post_title'],
                        'user_id'     => cmf_get_current_admin_id()
                    ];
                    Db::name('recycleBin')->insert($data);
                }
                $this->success("删除成功！", '');
            }
        }
    }

    /**
     * 文章发布
     * @adminMenu(
     *     'name'   => '文章发布',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章发布',
     *     'param'  => ''
     * )
     */
    public function publish()
    {
        $param           = $this->request->param();
        $protocolPostModel = new ProtocolPostModel();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->update(['post_status' => 1, 'published_time' => time()]);

            $this->success("发布成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->update(['post_status' => 0]);

            $this->success("取消发布成功！", '');
        }

    }

    /**
     * 文章置顶
     * @adminMenu(
     *     'name'   => '文章置顶',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章置顶',
     *     'param'  => ''
     * )
     */
    public function top()
    {
        $param           = $this->request->param();
        $protocolPostModel = new ProtocolPostModel();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->update(['is_top' => 1]);

            $this->success("置顶成功！", '');

        }

        if (isset($_POST['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->update(['is_top' => 0]);

            $this->success("取消置顶成功！", '');
        }
    }

    /**
     * 文章推荐
     * @adminMenu(
     *     'name'   => '文章推荐',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章推荐',
     *     'param'  => ''
     * )
     */
    public function recommend()
    {
        $param           = $this->request->param();
        $protocolPostModel = new ProtocolPostModel();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->update(['recommended' => 1]);

            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->update(['recommended' => 0]);

            $this->success("取消推荐成功！", '');

        }
    }

    /**
     * 文章排序
     * @adminMenu(
     *     'name'   => '文章排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('protocol_category_post'));
        $this->success("排序更新成功！", '');
    }

    public function move()
    {

    }

    public function copy()
    {

    }

    public function verify(){
        $content = hook_one('protocol_admin_article_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');

        $protocolPostModel = new ProtocolPostModel();
        $post            = $protocolPostModel->where('id', $id)->find();
        $postCategories  = $post->categories()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds = implode(',', array_keys($postCategories));
        $this->assign('post_categories', $postCategories);
        $this->assign('post_category_ids', $postCategoryIds);
        // dump($postCategoryIds);
        $protocolCategoryModel = new ProtocolCategoryModel();
        $where      = ['delete_time' => 0];
        $categories_model = $protocolCategoryModel->field('id, name')->where($where)->select();
        $this->assign('categories_model', $categories_model);
        // dump($categories);

        $postCategories_seal  = $post->categories_seal()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds_seal = implode(',', array_keys($postCategories_seal));
        $this->assign('post_categories_seal', $postCategories_seal);
        $this->assign('post_category_ids_seal', $postCategoryIds_seal);

        $postCategories_user  = $post->categories_user()->alias('a')->column('a.user_login, sign_status, sign_url, notes, a.id AS user_id, pivot.id AS protocol_id', 'a.id');
        // dump($post->getLastSql());
        $postCategoryIds_user = implode(',', array_keys($postCategories_user));
        $this->assign('post_categories_user', $postCategories_user);
        $this->assign('post_category_ids_user', $postCategoryIds_user);
        $this->assign('sign_user_count', count($postCategories_user) + 1);
        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');
        $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('post', $post);
        

        // $filename = '/home/lin/下载/四书模板/四书模板/xxxx保密工作责任书（通用部门）.doc';

        // $content = shell_exec('/usr/local/bin/antiword -m UTF-8.txt '.$filename);  
        // dump($postCategories_user);
        // $this->assign('content', $content);
        return $this->fetch();
    }

    public function verifyPost(){
        if ($this->request->isPost()) {
            $data = $this->request->param();

            //需要抹除发布、置顶、推荐的修改。
            unset($data['post']['post_status']);
            unset($data['post']['is_top']);
            unset($data['post']['recommended']);

            $post   = $data['post'];
            // $result = $this->validate($post, 'AdminIndex');
            // if ($result !== true) {
            //     $this->error($result);
            // }

            // $protocolPostModel = new ProtocolPostModel();

            // if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
            //     $data['post']['more']['photos'] = [];
            //     foreach ($data['photo_urls'] as $key => $url) {
            //         $photoUrl = cmf_asset_relative_url($url);
            //         array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
            //     }
            // }

            // if (!empty($data['file_names']) && !empty($data['file_urls'])) {
            //     $data['post']['more']['files'] = [];
            //     foreach ($data['file_urls'] as $key => $url) {
            //         $fileUrl = cmf_asset_relative_url($url);
            //         array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
            //     }
            // }

            // $protocolPostModel->adminEditArticle($data['post'], $data['post']['categories'], $data['post']['categories_seal'], $data['post']['categories_user']);

            // $hookParam = [
            //     'is_add'  => false,
            //     'article' => $data['post']
            // ];
            // hook('protocol_admin_after_save_article', $hookParam);

            $update_id = $post['id'];
            
            foreach ($update_id as $key => $value) {
                # code...
                $save['id'] = $value;
                $save['post_id'] = $post['post_id'];
                $save['sign_status'] = $post['sign_status'][$key];
                $save['notes'] = $post['notes'][$key];

                Db::name('protocol_category_user_post')->update($save);
            }

            // dump(Db::name('protocol_category_user_post')->getLastSql());
            $this->success('保存成功!');

        }
    }

}
