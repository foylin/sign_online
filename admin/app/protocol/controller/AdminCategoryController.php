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
use app\protocol\model\ProtocolCategoryModel;
use think\Db;
use app\admin\model\ThemeModel;

use app\protocol\model\SealCategoryModel;
// use app\protocol\model\UserCategoryModel;
use app\protocol\model\UserModel;

class AdminCategoryController extends AdminBaseController
{


    protected $mode_type = [
        1 => [
            [
                'page' => 5,
                'sign' => '140,46',
                'time' => '140,80'
            ]
        ],
        2 => [
            [
                'page' => 4,
                'sign' => '65,185',
                'time' => '65,215'
            ],[
                'page' => 4,
                'sign' => '160,180',
                'time' => '160,205'
            ]
        ],
        3 =>[
            [
                'page' => 6,
                'sign' => '160,25',
                'time' => '160,55'
            ]
        ],
        4 =>[
            [
                'page' => 3,
                'sign' => '72,205',
                'time' => '72,235'
            ],[
                'page' => 3,
                'sign' => '165,206',
                'time' => '160,235'
            ]
        ]

    ];

    // 公章
    protected $mode_type_seal = [
        1 => [
                'page' => 5,
                'sign' => '140,56'
        ],
        2 => [
                'page' => 4,
                'sign' => '65,195'
        ],
        3 =>[
                'page' => 6,
                'sign' => '160,35'
        ],
        4 =>[
                'page' => 3,
                'sign' => '72,215'
        ]
    ];

    // 部门公章
    protected $mode_type_frame = [
        1 => [
                'page' => 1,
                'sign' => '90,196'
        ],
        2 => [
                'page' => 1,
                'sign' => '90,196'
        ],
        3 =>[
                'page' => 1,
                'sign' => '90,196'
        ],
        4 =>[
                'page' => 1,
                'sign' => '90,196'
        ]
    ];

    /**
     * 文章分类列表
     * @adminMenu(
     *     'name'   => '分类管理',
     *     'parent' => 'protocol/AdminIndex/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章分类列表',
     *     'param'  => ''
     * )
     */

    
    public function index()
    {
        
        $content = hook_one('protocol_admin_category_index_view');

        if (!empty($content)) {
            return $content;
        }

        $protocolCategoryModel = new ProtocolCategoryModel();
        $keyword             = $this->request->param('keyword');

        if (empty($keyword)) {
            $categoryTree = $protocolCategoryModel->adminCategoryTableTree();
            $this->assign('category_tree', $categoryTree);
        } else {
            $categories = $protocolCategoryModel->where('name', 'like', "%{$keyword}%")
                ->where('delete_time', 0)->select();
            $this->assign('categories', $categories);
        }

        $this->assign('keyword', $keyword);

        return $this->fetch();
    }

    /**
     * 添加文章分类
     * @adminMenu(
     *     'name'   => '添加文章分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加文章分类',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $content = hook_one('protocol_admin_category_add_view');

        if (!empty($content)) {
            return $content;
        }

        $parentId            = $this->request->param('parent', 0, 'intval');
        $protocolCategoryModel = new ProtocolCategoryModel();
        $categoriesTree      = $protocolCategoryModel->adminCategoryTree($parentId);

        $themeModel        = new ThemeModel();
        $listThemeFiles    = $themeModel->getActionThemeFiles('protocol/List/index');
        $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');

        $this->assign('list_theme_files', $listThemeFiles);
        $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('categories_tree', $categoriesTree);
        return $this->fetch();
    }

    /**
     * 添加文章分类提交
     * @adminMenu(
     *     'name'   => '添加文章分类提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加文章分类提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $protocolCategoryModel = new ProtocolCategoryModel();

        $data = $this->request->param();

        $result = $this->validate($data, 'protocolCategory');

        if ($result !== true) {
            $this->error($result);
        }

        if (!empty($data['file_names']) && !empty($data['file_urls'])) {
            $data['more']['files'] = [];
            foreach ($data['file_urls'] as $key => $url) {
                $fileUrl = cmf_asset_relative_url($url);
                array_push($data['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
            
                
            }
        }

        if($data['mode_type']){
            $data['more']['axes'] = $this->mode_type[$data['mode_type']];
            $data['more']['seal'] = $this->mode_type_seal[$data['mode_type']];
            $data['more']['frame']= $this->mode_type_frame[$data['mode_type']];

        }
        // dump($data);
        $result = $protocolCategoryModel->addCategory($data);

        if ($result === false) {
            $this->error('添加失败!');
        }
        // dump($result);
        $this->success('添加成功!', url('AdminCategory/index'));

    }

    /**
     * 编辑文章分类
     * @adminMenu(
     *     'name'   => '编辑文章分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑文章分类',
     *     'param'  => ''
     * )
     */
    public function edit()
    {

        $content = hook_one('protocol_admin_category_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        if ($id > 0) {
            // $category = protocolCategoryModel::get($id)->toArray();

            

            $protocolCategoryModel = new ProtocolCategoryModel();

            $category = $protocolCategoryModel->where('id', $id)->find();
            // dump($category);
            $categoriesTree      = $protocolCategoryModel->adminCategoryTree($category['parent_id'], $id);

            $themeModel        = new ThemeModel();
            $listThemeFiles    = $themeModel->getActionThemeFiles('protocol/List/index');
            $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');

            $routeModel = new RouteModel();
            $alias      = $routeModel->getUrl('protocol/List/index', ['id' => $id]);

            $category['alias'] = $alias;
            

            $this->assign('category', $category);

            $this->assign('list_theme_files', $listThemeFiles);
            $this->assign('article_theme_files', $articleThemeFiles);
            $this->assign('categories_tree', $categoriesTree);
            return $this->fetch();
        } else {
            $this->error('操作错误!');
        }

    }

    /**
     * 编辑文章分类提交
     * @adminMenu(
     *     'name'   => '编辑文章分类提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑文章分类提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, 'protocolCategory');

        if ($result !== true) {
            $this->error($result);
        }

        $protocolCategoryModel = new ProtocolCategoryModel();

        if (!empty($data['file_names']) && !empty($data['file_urls'])) {
            $data['more']['files'] = [];
            foreach ($data['file_urls'] as $key => $url) {
                $fileUrl = cmf_asset_relative_url($url);
                array_push($data['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
            
                // 生成 pdf
                // $cd = "cd /www/wwwroot/wwfnba01/sign_online/admin/public/jodconverter-2.2.2/lib && ";
                // $dir = " /www/wwwroot/wwfnba01/sign_online/admin/public/protocol/".$data['id'].".pdf";

                // $docdir = "/www/wwwroot/wwfnba01/sign_online/admin/public/upload/".$url;
                // $sh = $cd . " java -jar jodconverter-cli-2.2.2.jar ".$docdir.$dir;
                // $result = shell_exec($sh);
                // var_dump($result);
            
            }
        }

        // $data['id'];
        // dump($data['more']['axes']);
        if(!empty($data['more']['axes']['page'])){
            foreach ($data['more']['axes']['page'] as $key => $value) {
                $axes[$key]['page'] = $data['more']['axes']['page'][$key];
                $axes[$key]['sign'] = $data['more']['axes']['sign'][$key];
                $axes[$key]['time'] = $data['more']['axes']['time'][$key];
            }
        }
        $data['more']['axes'] = $axes;
        // dump($data); exit();

        
        // if($data['mode_type']){
        //     $data['more']['axes'] = $this->mode_type[$data['mode_type']];
        // }
        
        $result = $protocolCategoryModel->editCategory($data);

        // dump($result);

        if ($result === false) {
            $this->error('保存失败!');
        }

        $this->success('保存成功!');
    }

    /**
     * 文章分类选择对话框
     * @adminMenu(
     *     'name'   => '文章分类选择对话框',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章分类选择对话框',
     *     'param'  => ''
     * )
     */
    public function select()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        $protocolCategoryModel = new ProtocolCategoryModel();

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

        $categoryTree = $protocolCategoryModel->adminCategoryTableTree($selectedIds, $tpl);

        $where      = ['delete_time' => 0];
        $categories = $protocolCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function select_seal()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);

        // $places                 = $this->request->param('places');
        // $selectedPlaces         = explode(',', $places);

        // foreach ($selectedIds as $key => $value) {
        //     # code...
        //     $places_arr[$value] = $selectedPlaces[$key];
        // }
        // dump($places_arr);
        $sealCategoryModel = new SealCategoryModel();

//         $tpl = <<<tpl
// <tr class='data-item-tr'>
//     <td>
//         <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
//                value='\$id' data-name='\$name' \$checked>
//     </td>
//     <td>\$id</td>
//     <td>\$spacer <a href='\$url' target='_blank'>\$name</a> <input value='\$place' name='seal_place_\$id' class='form-control' placeholder='公章位置' style='
//     width: 200px;
//     display: inherit;
//     margin-left: 10px;
// ' /></td>
// </tr>
// tpl;
$tpl = <<<tpl
<tr class='data-item-tr'>
    <td>
        <input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]'
               value='\$id' data-name='\$name' \$checked>
    </td>
    <td>\$id</td>
    <td>\$spacer \$name</td>
</tr>
tpl;

        $categoryTree = $sealCategoryModel->adminCategoryTableTree($selectedIds, $tpl);
        // dump($categoryTree);
        $where      = ['delete_time' => 0];
        $categories = $sealCategoryModel->where($where)->select();

        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    public function select_user()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);
        // dump($selectedIds);
        // $places                 = $this->request->param('places');
        // $selectedPlaces         = explode(',', $places);

        $post_id             = $this->request->param('post_id');

        $mode_type           = $this->request->param('mode_type');

        // foreach ($selectedIds as $key => $value) {
        //     # code...
        //     $places_arr[$value] = $selectedPlaces[$key];
        // }

        $userModel = new UserModel();

//         $tpl = <<<tpl
// <tr id='node-\$id' \$parent_id_node data-parent_id='\$parent_id' data-id='\$id'>
// <td style='padding-left:20px;'><input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id'></td>

//     <td>\$id</td>
//     <td>\$spacer \$name</td>
// </tr>
// tpl;

$tpl = " <tr id='node-\$id' \$parent_id_node style='' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'>
                        <input type='checkbox' class='js-check \$is_user' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id' value='\$id' data-name='\$name' \$checked></td>
                        <td>\$id</td>
                        <td>\$spacer \$name</td>
                    </tr>";

        $categoryTree = $userModel->adminCategoryTableTree($selectedIds, $tpl, $mode_type);

        $where      = ['user_status' => 1];
        $categories = $userModel->where($where)->select();
        // foreach ($categories as $key => $val) {
            # code...
            // $val['place'] = $selectedPlaces[$key];
            // if(in_array($val['id'], $selectedIds)){
            //     $categories[$key]['place'] = $places_arr[$val['id']];
            // }else{
            //     $categories[$key]['place'] = 0;
            // }

            // $is_user = Db::name('protocol_category_user_post')->where(['post_id'=>$post_id, 'category_id'=>$val['id']])->find();
            // if($is_user){
            //     $categories[$key]['place'] = $is_user['place'];
            // }else{
            //     $categories[$key]['place'] = 0;
            // }  
        // }

        
        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    /**
     * 查找部门负责人
     */
    public function select_user_resp()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);

        $post_id                 = $this->request->param('post_id');

        $userModel = new UserModel();

        $tpl = " <tr id='node-\$id' \$parent_id_node style='' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'>
                        <input type='checkbox' class='js-check \$is_user' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id' value='\$id' data-name='\$name' \$checked></td>
                        <td>\$id</td>
                        <td>\$spacer \$name</td>
                    </tr>";

        $categoryTree = $userModel->adminCategoryTableTree_resp($selectedIds, $tpl);

        $where      = ['user_status' => 1];
        $categories = $userModel->where($where)->select();
        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    /**
     * 查找部门普通员工,除去部门负责人
     */
    public function select_user_no_resp()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);

        $post_id                 = $this->request->param('post_id');

        $userModel = new UserModel();

        $tpl = " <tr id='node-\$id' \$parent_id_node style='' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'>
                        <input type='checkbox' class='js-check \$is_user' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id' value='\$id' data-name='\$name' \$checked></td>
                        <td>\$id</td>
                        <td>\$spacer \$name</td>
                    </tr>";

        $categoryTree = $userModel->adminCategoryTableTree_no_resp($selectedIds, $tpl);

        $where      = ['user_status' => 1];
        $categories = $userModel->where($where)->select();
        $this->assign('categories', $categories);
        $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }


    /**
     * 查找负责人
     */
    public function select_user_one()
    {
        $ids                 = $this->request->param('ids');
        $selectedIds         = explode(',', $ids);

        $places                 = $this->request->param('places');
        $selectedPlaces         = explode(',', $places);

        $post_id                 = $this->request->param('post_id');

        // foreach ($selectedIds as $key => $value) {
        //     # code...
        //     $places_arr[$value] = $selectedPlaces[$key];
        // }

        $userModel = new UserModel();

        $tpl = " <tr id='node-\$id' \$parent_id_node style='' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'>
                        <input type='checkbox' class='js-check \$is_user' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id' value='\$id' data-name='\$name' \$checked></td>
                        <td>\$id</td>
                        <td>\$spacer \$name</td>
                    </tr>";

        $categoryTree = $userModel->adminCategoryTableTree($selectedIds, $tpl, $one = true);

        // $where      = ['user_status' => 1];
        // $categories = $userModel->where($where)->select();
        // foreach ($categories as $key => $val) {
            # code...
            // $val['place'] = $selectedPlaces[$key];
            // if(in_array($val['id'], $selectedIds)){
            //     $categories[$key]['place'] = $places_arr[$val['id']];
            // }else{
            //     $categories[$key]['place'] = 0;
            // }

            // $is_user = Db::name('protocol_category_user_post')->where(['post_id'=>$post_id, 'category_id'=>$val['id']])->find();
            // if($is_user){
            //     $categories[$key]['place'] = $is_user['place'];
            // }else{
            //     $categories[$key]['place'] = 0;
            // }  
        // }

        
        // $this->assign('categories', $categories);
        // $this->assign('selectedIds', $selectedIds);
        $this->assign('categories_tree', $categoryTree);
        return $this->fetch();
    }

    /**
     * 文章分类排序
     * @adminMenu(
     *     'name'   => '文章分类排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章分类排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('protocol_category'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 文章分类显示隐藏
     * @adminMenu(
     *     'name'   => '文章分类显示隐藏',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '文章分类显示隐藏',
     *     'param'  => ''
     * )
     */
    public function toggle()
    {
        $data                = $this->request->param();
        $protocolCategoryModel = new ProtocolCategoryModel();

        if (isset($data['ids']) && !empty($data["display"])) {
            $ids = $this->request->param('ids/a');
            $protocolCategoryModel->where(['id' => ['in', $ids]])->update(['status' => 1]);
            $this->success("更新成功！");
        }

        if (isset($data['ids']) && !empty($data["hide"])) {
            $ids = $this->request->param('ids/a');
            $protocolCategoryModel->where(['id' => ['in', $ids]])->update(['status' => 0]);
            $this->success("更新成功！");
        }

    }

    /**
     * 删除文章分类
     * @adminMenu(
     *     'name'   => '删除文章分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除文章分类',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $protocolCategoryModel = new ProtocolCategoryModel();
        $id                  = $this->request->param('id');
        //获取删除的内容
        $findCategory = $protocolCategoryModel->where('id', $id)->find();

        if (empty($findCategory)) {
            $this->error('分类不存在!');
        }

        //判断此分类有无子分类（不算被删除的子分类）
        $categoryChildrenCount = $protocolCategoryModel->where(['parent_id' => $id,'delete_time' => 0])->count();

        if ($categoryChildrenCount > 0) {
            $this->error('此分类有子类无法删除!');
        }

        $categoryPostCount = Db::name('protocol_category_post')->where('category_id', $id)->count();

        // if ($categoryPostCount > 0) {
        //     $this->error('此分类有文章无法删除!');
        // }

        $data   = [
            'object_id'   => $findCategory['id'],
            'create_time' => time(),
            'table_name'  => 'protocol_category',
            'name'        => $findCategory['name']
        ];
        $result = $protocolCategoryModel
            ->where('id', $id)
            ->update(['delete_time' => time()]);
        if ($result) {
            Db::name('recycleBin')->insert($data);
            $this->success('删除成功!');
        } else {
            $this->error('删除失败');
        }
    }


    public function getmodel()
    {
        // $ids                 = $this->request->param('ids');
        // $selectedIds         = explode(',', $ids);
        $protocolCategoryModel = new ProtocolCategoryModel();

        $id = $this->request->param('id', 0, 'intval');

        $where      = ['delete_time' => 0, 'id' => $id];
        $model = $protocolCategoryModel->where($where)->find();

        // $this->assign('categories', $categories);
        // $this->assign('selectedIds', $selectedIds);
        // $this->assign('categories_tree', $categoryTree);
        // return $this->fetch();
        if($model){
            $result['data'] = $model;
            $result['code'] = 200;
        }else{
            $result['code'] = -1;
            $result['msg'] = '模板数据错误';
        }

        return json($result);
        
    }

    public function update_user(){
        $param = $this->request->param();
        

        $post_id = $param['post_id'];
        $user_ids = explode(',', $param['user_ids']);
        $user_places = explode(',', $param['user_places']);

        $oldCategoryIds        = Db::name('protocol_category_user_post')->where(['post_id'=>$post_id])->column('category_id');
        
        $sameCategoryIds       = array_intersect($user_ids, $oldCategoryIds);

        $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);

        // dump($needDeleteCategoryIds);

        // $newCategoryIds        = array_diff($user_ids, $sameCategoryIds);

        // dump($newCategoryIds); exit();

        foreach ($needDeleteCategoryIds as $key => $value) {
            Db::name('protocol_category_user_post')->where(['post_id'=>$post_id, 'category_id' => $value])->delete();
        }
        
        foreach ($user_ids as $key_2 => $value_2) {
            # code...
            $is_user = Db::name('protocol_category_user_post')->where(['post_id'=>$post_id, 'category_id' => $user_ids[$key_2]])->find();
            // dump($is_user);
            $save['place'] = $user_places[$key_2];

            if($is_user){
                Db::name('protocol_category_user_post')->where(['post_id'=>$post_id, 'category_id' => $user_ids[$key_2]])->update($save);
            
            }else{
                $save['post_id'] = $post_id;
                $save['category_id'] = $user_ids[$key_2];
                Db::name('protocol_category_user_post')->insert($save);
            
            }

            unset($save);
        }
    }
}
