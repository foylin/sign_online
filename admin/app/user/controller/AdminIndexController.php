<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------

namespace app\user\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\frame\model\FrameCategoryModel;
use app\vague\model\VagueCategoryModel;
use app\identity\model\IdentityCategoryModel;
use app\role\model\RoleCategoryModel;
use app\user\model\UserModel;

class AdminIndexController extends AdminBaseController
{

    /**
     * 后台本站用户列表
     * @adminMenu(
     *     'name'   => '本站用户',
     *     'parent' => 'default1',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '本站用户',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $content = hook_one('user_admin_index_view');

        if (!empty($content)) {
            return $content;
        }

        $where   = [];
        $request = input('request.');

        if (!empty($request['uid'])) {
            $where['u.user_sn'] = intval($request['uid']);
        }
        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['u.user_login|u.user_nickname|u.user_email|u.mobile']    = ['like', "%$keyword%"];
        }

        $whereor_frame_name = [];
        $frame_id = 0;
        if(!empty($request['frame_name'])){
            $frame_id = $request['frame_name'];
            $whereor_frame_name['fc.id'] = $frame_id;
        }

        $whereor_frame_type = [];
        $frame_type_id = 0;
        if(!empty($request['frame_type'])){
            $frame_type_id = $request['frame_type'];
            $whereor_frame_type['fcp.type'] = $request['frame_type'];
        }

        $whereor_is_sec = [];
        $request['is_sec'] = isset($request['is_sec']) ? $request['is_sec'] : -1;
        if($request['is_sec'] != -1){
            $whereor_is_sec['fcp.is_sec'] = $request['is_sec'];
        }
        // dump($whereor_is_sec);
        $usersQuery = Db::name('user');

        $list = $usersQuery->alias('u')->join('__FRAME_CATEGORY_POST__ fcp', 'u.id = fcp.post_id')
        ->join('__FRAME_CATEGORY__ fc', 'fc.id = fcp.category_id')->field('u.*, fcp.type AS frame_type, fcp.is_sec, fc.name AS frame_name')
        ->whereOr($keywordComplex)->whereOr($whereor_frame_name)->whereOr($whereor_frame_type)
        ->whereOr($whereor_is_sec)->where($where)
        ->order("create_time DESC")->paginate(10)->each(function($item, $key){
            if($item['frame_type'] == 1){
                $item['frame_type'] = '员工';
            }elseif($item['frame_type'] == 2){
                $item['frame_type'] = '部门副职';
            }elseif($item['frame_type'] == 3){
                $item['frame_type'] = '部门正职';
            }else{
                $item['frame_type'] = '未设置岗位';
            }

            if($item['is_sec'] == 0){
                $item['is_sec'] = '非涉密';
            }elseif($item['is_sec'] == 1){
                $item['is_sec'] = '涉密';
            }else{
                $item['is_sec'] = '未设置角色';
            }
            return $item;
        });

        // dump($usersQuery->getLastSql());

        $frameCategoryModel = new FrameCategoryModel();
        $framecategory = $frameCategoryModel->adminCategoryTree($frame_id);
        $this->assign('framecategory', $framecategory);

        $vagueCategoryModel = new VagueCategoryModel();
        $vaguecategory = $vagueCategoryModel->adminCategoryTree($frame_type_id);
        $this->assign('vaguecategory', $vaguecategory);

        // $roleCategoryModel = new RoleCategoryModel();
        // $rolecategory = $roleCategoryModel->adminCategoryTree();
        // $this->assign('rolecategory', $rolecategory);

        // dump($framecategory);
        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);

        
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 本站用户拉黑
     * @adminMenu(
     *     'name'   => '本站用户拉黑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '本站用户拉黑',
     *     'param'  => ''
     * )
     */
    public function ban()
    {
        $id = input('param.id', 0, 'intval');
        if ($id) {
            $result = Db::name("user")->where(["id" => $id, "user_type" => 2])->setField('user_status', 0);
            if ($result) {
                $this->success("会员拉黑成功！", "adminIndex/index");
            } else {
                $this->error('会员拉黑失败,会员不存在,或者是管理员！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    /**
     * 本站用户启用
     * @adminMenu(
     *     'name'   => '本站用户启用',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '本站用户启用',
     *     'param'  => ''
     * )
     */
    public function cancelBan()
    {
        $id = input('param.id', 0, 'intval');
        if ($id) {
            Db::name("user")->where(["id" => $id, "user_type" => 2])->setField('user_status', 1);
            $this->success("会员启用成功！", '');
        } else {
            $this->error('数据传入失败！');
        }
    }


    public function add(){
        // $content = hook_one('portal_admin_article_add_view');

        // if (!empty($content)) {
        //     return $content;
        // }

        // $themeModel        = new ThemeModel();
        // $articleThemeFiles = $themeModel->getActionThemeFiles('portal/Article/index');
        // $this->assign('article_theme_files', $articleThemeFiles);
        return $this->fetch();
    }

    public function addPost(){
        if ($this->request->isPost()) {
            

            $data = $this->request->post();
            
            $user = $data['post'];
            
            $register          = new UserModel();
            if(empty($user['user_pass'])){
                $user['user_pass'] = '123456';
            }
            
            $log            = $register->register($user, 2);
            // $sessionLoginHttpReferer = session('login_http_referer');
            // $redirect                = empty($sessionLoginHttpReferer) ? cmf_get_root() . '/' : $sessionLoginHttpReferer;
            $redirect = url('AdminIndex/index');
            switch ($log) {
                case 0:
                    $this->success('注册成功', $redirect);
                    break;
                case 1:
                    $this->error("您的账户已注册过");
                    break;
                case 2:
                    $this->error("员工工号已注册过");
                    break;
                default :
                    $this->error('未受理的请求');
            }
        }
    }

    public function edit()
    {
        // $content = hook_one('portal_admin_article_edit_view');

        // if (!empty($content)) {
        //     return $content;
        // }

        $id = $this->request->param('id', 0, 'intval');
        $userModel = new UserModel();
        
        // $portalPostModel = new PortalPostModel();
        $post            = $userModel->where('id', $id)->find();
        
        // 所属部门/单位
        $postCategories  = $post->frame()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds = implode(',', array_keys($postCategories));
        $this->assign('post_categories', $postCategories);
        $this->assign('post_category_ids', $postCategoryIds);

        // 是否涉密人员
        $is_sec = $post->frame()->alias('a')->value('pivot.is_sec');
        $this->assign('is_sec', $is_sec);

        // 部门职位
        $frame_type = $post->frame()->alias('a')->value('pivot.type');
        $this->assign('frame_type', $frame_type);

        // dump($is_sec);
        // 部门/单位负责人
        $postCategories_resp  = $post->frame_resp()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds_resp = implode(',', array_keys($postCategories_resp));
        $this->assign('post_categories_resp', $postCategories_resp);
        $this->assign('post_category_ids_resp', $postCategoryIds_resp);

        // 用户角色(是否涉密人员)
        // $postCategories_secr  = $post->frame_secr()->alias('a')->column('a.name', 'a.id');
        // $postCategoryIds_secr = implode(',', array_keys($postCategories_secr));
        // $this->assign('post_categories_secr', $postCategories_secr);
        // $this->assign('post_category_ids_secr', $postCategoryIds_secr);
        $roleCategoryModel = new RoleCategoryModel();
        $where      = ['delete_time' => 0];
        $categories_role = $roleCategoryModel->where($where)->select();
        // dump($categories_role);

        // $postCategories_vague  = $post->vague()->alias('a')->column('a.name', 'a.id');
        // $postCategoryIds_vague = implode(',', array_keys($postCategories_vague));
        // $this->assign('post_categories_vague', $postCategories_vague);
        // $this->assign('post_category_ids_vague', $postCategoryIds_vague);

        $postCategories_identity  = $post->identity()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds_identity = implode(',', array_keys($postCategories_identity));
        $this->assign('post_categories_identity', $postCategories_identity);
        $this->assign('post_category_ids_identity', $postCategoryIds_identity);

        $postCategories_role  = $post->role()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds_role = implode(',', array_keys($postCategories_role));
        $this->assign('post_categories_role', $postCategories_role);
        $this->assign('post_category_ids_role', $postCategoryIds_role);
        
        $this->assign('post', $post);
        return $this->fetch();
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
            // unset($data['post']['post_status']);
            // unset($data['post']['is_top']);
            // unset($data['post']['recommended']);

            $post   = $data['post'];
            // $result = $this->validate($post, 'AdminArticle');
            // if ($result !== true) {
            //     $this->error($result);
            // }

            // $portalPostModel = new PortalPostModel();
            $userModel = new UserModel();

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
            if(empty($post['user_pass'])){
                unset($post['user_pass']);
            }else{
                $post['user_pass'] = cmf_password($post['user_pass']);
            }
            // dump($post);
            $result = $userModel->adminEditUser($post, $post['categories'], $post['categories_identity']);

            if($result == 1){
                $this->error('修改的手机号已存在');
            }elseif($result == 2){
                $this->error('工号已存在');
            }
            $hookParam = [
                'is_add'  => false,
                'article' => $data['post']
            ];
            hook('portal_admin_after_save_article', $hookParam);

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
        // $portalPostModel = new PortalPostModel();

        if (isset($param['id'])) {
            $id           = $this->request->param('id', 0, 'intval');
            // $result       = $portalPostModel->where(['id' => $id])->find();
            // $data         = [
            //     'object_id'   => $result['id'],
            //     'create_time' => time(),
            //     'table_name'  => 'portal_post',
            //     'name'        => $result['post_title'],
            //     'user_id'     => cmf_get_current_admin_id()
            // ];
            // $resultPortal = $portalPostModel
            //     ->where(['id' => $id])
            //     ->update(['delete_time' => time()]);
            // if ($resultPortal) {
            //     Db::name('portal_category_post')->where(['post_id' => $id])->update(['status' => 0]);
            //     Db::name('portal_tag_post')->where(['post_id' => $id])->update(['status' => 0]);

            //     Db::name('recycleBin')->insert($data);
            // }
            Db::name('user')->where('id = '.$id)->delete();
            Db::name('protocol_category_user_post')->where('category_id = '.$id)->delete();
            $this->success("删除成功！", '');

        }

        // if (isset($param['ids'])) {
        //     $ids     = $this->request->param('ids/a');
        //     $recycle = $portalPostModel->where(['id' => ['in', $ids]])->select();
        //     $result  = $portalPostModel->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
        //     if ($result) {
        //         Db::name('portal_category_post')->where(['post_id' => ['in', $ids]])->update(['status' => 0]);
        //         Db::name('portal_tag_post')->where(['post_id' => ['in', $ids]])->update(['status' => 0]);
        //         foreach ($recycle as $value) {
        //             $data = [
        //                 'object_id'   => $value['id'],
        //                 'create_time' => time(),
        //                 'table_name'  => 'portal_post',
        //                 'name'        => $value['post_title'],
        //                 'user_id'     => cmf_get_current_admin_id()
        //             ];
        //             Db::name('recycleBin')->insert($data);
        //         }
        //         $this->success("删除成功！", '');
        //     }
        // }
    }

    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $frameCategoryModel = new FrameCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;

        $categoryTree = $frameCategoryModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $frameCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function select_vague()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $vagueCategoryModel = new VagueCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;

        $categoryTree = $vagueCategoryModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $vagueCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function select_identity()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $identityCategoryModel = new IdentityCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;

        $categoryTree = $identityCategoryModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $identityCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function select_role()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $roleCategoryModel = new RoleCategoryModel();

        $tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
</tr>
tpl;

        $categoryTree = $roleCategoryModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $roleCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    
}
    
