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
namespace app\protocol\model;

use think\Model;
use tree\Tree;
use think\Db;
class UserModel extends Model
{

    protected $type = [
        'more' => 'array',
    ];

     /**
     * 分类树形结构
     * @param int $currentIds
     * @param string $tpl
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function adminCategoryTableTree($currentIds = 0, $tpl = '', $mode_type = 0)
    {
        $where = ['fc.status' => 1];
        $where = ['fc.delete_time' => 0];
        $categories = Db::name('frame_category')->alias('fc')->where($where)->limit(3)->select()->toArray();
            // dump($categories);exit();
        foreach ($categories as $key => $value) {
            $categories[$key]['is_user'] = false;
            $map['fcp.category_id'] = $value['id'];
            $map['u.user_status'] = 1;

                // 保密工作责任书 通用部门  查找各部门负责人
            if ($mode_type == 1) {
                $map['fcp.type'] = 3;
            }

                // 员工保密承诺书 查找各部门员工
            elseif ($mode_type == 2) {
                $map['fcp.type'] = ['<>', 3];
            }

                // 涉密人员保证书 查找各部门涉密人员
            elseif ($mode_type == 3) {
                $map['fcp.is_sec'] = 1;
            }

                // $map['u.user_type'] = 2;
            $next_parent = Db::name('frame_category_post')->alias('fcp')->join('__USER__ u', 'fcp.post_id = u.id')
                ->where($map)->field('u.*')->select()->toArray();
                // dump(Db::name('frame_category_post')->getLastSql());
            if ($next_parent) {
                foreach ($next_parent as $k_np => $val_np) {
                    $next_parent_data['id'] = $val_np['id'];
                    $next_parent_data['parent_id'] = $value['id'];
                    $next_parent_data['name'] = $val_np['user_login'];
                    $next_parent_data['path'] = '0';
                    $next_parent_data['is_user'] = true;
                    $categories[] = $next_parent_data;
                }
            }


        }
        // }
        
        // dump($categories);
        $tree = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        // if($one){
        if (!is_array($currentIds)) {
            $currentIds = [$currentIds];
        }
        // }else{
        //     foreach ($categories as $key => $value) {
        //         $currentIds[] = $value['id'];   
        //     }
        // }


        $newCategories = [];

        foreach ($categories as $item) {
            // if($one){
            //     $item['parent_id'] = 0;
            //     $item['name'] = $item['user_login'];
            // }

            $item['parent_id_node'] = ($item['parent_id']) ? ' class="child-of-node-' . $item['parent_id'] . '"' : '';
            $item['style'] = empty($item['parent_id']) ? '' : 'display:none;';
            $item['status_text'] = empty($item['status']) ? '隐藏' : '显示';
            $item['checked'] = in_array($item['id'], $currentIds) ? "checked" : "";
            $item['url'] = cmf_url('protocol/List/index', ['id' => $item['id']]);
            $item['str_action'] = '<a href="' . url("AdminCategory/add", ["parent" => $item['id']]) . '">添加子分类</a>  <a href="' . url("AdminCategory/edit", ["id" => $item['id']]) . '">' . lang('EDIT') . '</a>  <a class="js-ajax-delete" href="' . url("AdminCategory/delete", ["id" => $item['id']]) . '">' . lang('DELETE') . '</a> ';
            $item['is_user'] = $item['is_user'] ? 'user' : '';
            
            // if ($item['status']) {
            //     $item['str_action'] .= '<a class="js-ajax-dialog-btn" data-msg="您确定隐藏此分类吗" href="' . url('AdminCategory/toggle', ['ids' => $item['id'], 'hide' => 1]) . '">隐藏</a>';
            // } else {
            //     $item['str_action'] .= '<a class="js-ajax-dialog-btn" data-msg="您确定显示此分类吗" href="' . url('AdminCategory/toggle', ['ids' => $item['id'], 'display' => 1]) . '">显示</a>';
            // }
            array_push($newCategories, $item);
        }
        // dump($newCategories); exit();
        $tree->init($newCategories);

        if (empty($tpl)) {
            $tpl = " <tr id='node-\$id' \$parent_id_node style='\$style' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'><input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id'></td>
                        <td><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input-order'></td>
                        <td>\$id</td>
                        <td>\$spacer <a href='\$url' target='_blank'>\$user_login</a></td>
                        <td>\$description</td>
                        <td>\$status_text</td>
                        <td>\$str_action</td>
                    </tr>";
        }
        $treeStr = $tree->getTree(0, $tpl);

        return $treeStr;
    }


    /**
     * 单位负责人树形结构
     */
    public function adminCategoryTableTree_resp($currentIds = 0, $tpl = '', $no_resp = false)
    {

        $where = ['fc.status' => 1];
        $where = ['fc.delete_time' => 0];

        $categories = Db::name('frame_category')->alias('fc')->where($where)->select()->toArray();
        foreach ($categories as $key => $value) {
            $categories[$key]['is_user'] = false;
            $map['fcp.category_id'] = $value['id'];
            $map['u.user_status'] = 1;
            $map['u.user_type'] = 2;
            $next_parent = Db::name('frame_category_resp_post')->alias('fcp')->join('__USER__ u', 'fcp.post_id = u.id')
                ->where($map)->field('u.*')->select()->toArray();
            
            // 去除部门负责人
            if($no_resp){
                
            }

            if ($next_parent) {
                foreach ($next_parent as $k_np => $val_np) {
                    $next_parent_data['id'] = $val_np['id'];
                    $next_parent_data['parent_id'] = $value['id'];
                    $next_parent_data['name'] = $val_np['user_login'];
                    $next_parent_data['path'] = '0';
                    $next_parent_data['is_user'] = true;
                }
                $categories[] = $next_parent_data;
            }


        }
        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        if (!is_array($currentIds)) {
            $currentIds = [$currentIds];
        }


        $newCategories = [];
        
        foreach ($categories as $item) {
            
            $item['parent_id_node'] = ($item['parent_id']) ? ' class="child-of-node-' . $item['parent_id'] . '"' : '';
            $item['style']          = empty($item['parent_id']) ? '' : 'display:none;';
            $item['status_text']    = empty($item['status'])?'隐藏':'显示';
            $item['checked']        = in_array($item['id'], $currentIds) ? "checked" : "";
            $item['url']            = cmf_url('protocol/List/index', ['id' => $item['id']]);
            $item['str_action']     = '<a href="' . url("AdminCategory/add", ["parent" => $item['id']]) . '">添加子分类</a>  <a href="' . url("AdminCategory/edit", ["id" => $item['id']]) . '">' . lang('EDIT') . '</a>  <a class="js-ajax-delete" href="' . url("AdminCategory/delete", ["id" => $item['id']]) . '">' . lang('DELETE') . '</a> ';
            $item['is_user']        = $item['is_user'] ? 'user' : '';

            array_push($newCategories, $item);
        }
        $tree->init($newCategories);

        if (empty($tpl)) {
            $tpl = " <tr id='node-\$id' \$parent_id_node style='\$style' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'><input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id'></td>
                        <td><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input-order'></td>
                        <td>\$id</td>
                        <td>\$spacer <a href='\$url' target='_blank'>\$user_login</a></td>
                        <td>\$description</td>
                        <td>\$status_text</td>
                        <td>\$str_action</td>
                    </tr>";
        }
        $treeStr = $tree->getTree(0, $tpl);

        return $treeStr;
    }

    /**
     * 单位负责人树形结构   除去部门负责人
     */
    public function adminCategoryTableTree_no_resp($currentIds = 0, $tpl = '')
    {

        $where = ['fc.status' => 1];
        $where = ['fc.delete_time' => 0];

        $categories = Db::name('frame_category')->alias('fc')->where($where)->select()->toArray();
        foreach ($categories as $key => $value) {
            $categories[$key]['is_user'] = false;
            $map['fcp.category_id'] = $value['id'];
            $map['u.user_status'] = 1;
            $map['u.user_type'] = 2;
            $next_parent = Db::name('frame_category_resp_post')->alias('fcp')->join('__USER__ u', 'fcp.post_id = u.id')
                ->where($map)->field('u.*')->select()->toArray();
            if ($next_parent) {
                foreach ($next_parent as $k_np => $val_np) {
                    $next_parent_data['id'] = $val_np['id'];
                    $next_parent_data['parent_id'] = $value['id'];
                    $next_parent_data['name'] = $val_np['user_login'];
                    $next_parent_data['path'] = '0';
                    $next_parent_data['is_user'] = true;
                }
                $categories[] = $next_parent_data;
            }
        }
        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
        $tree->nbsp = '&nbsp;&nbsp;';

        if (!is_array($currentIds)) {
            $currentIds = [$currentIds];
        }


        $newCategories = [];
        
        foreach ($categories as $item) {
            
            $item['parent_id_node'] = ($item['parent_id']) ? ' class="child-of-node-' . $item['parent_id'] . '"' : '';
            $item['style']          = empty($item['parent_id']) ? '' : 'display:none;';
            $item['status_text']    = empty($item['status'])?'隐藏':'显示';
            $item['checked']        = in_array($item['id'], $currentIds) ? "checked" : "";
            $item['url']            = cmf_url('protocol/List/index', ['id' => $item['id']]);
            $item['str_action']     = '<a href="' . url("AdminCategory/add", ["parent" => $item['id']]) . '">添加子分类</a>  <a href="' . url("AdminCategory/edit", ["id" => $item['id']]) . '">' . lang('EDIT') . '</a>  <a class="js-ajax-delete" href="' . url("AdminCategory/delete", ["id" => $item['id']]) . '">' . lang('DELETE') . '</a> ';
            $item['is_user']        = $item['is_user'] ? 'user' : '';

            array_push($newCategories, $item);
        }
        $tree->init($newCategories);

        if (empty($tpl)) {
            $tpl = " <tr id='node-\$id' \$parent_id_node style='\$style' data-parent_id='\$parent_id' data-id='\$id'>
                        <td style='padding-left:20px;'><input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id' data-parent_id='\$parent_id' data-id='\$id'></td>
                        <td><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input-order'></td>
                        <td>\$id</td>
                        <td>\$spacer <a href='\$url' target='_blank'>\$user_login</a></td>
                        <td>\$description</td>
                        <td>\$status_text</td>
                        <td>\$str_action</td>
                    </tr>";
        }
        $treeStr = $tree->getTree(0, $tpl);

        return $treeStr;
    }
}