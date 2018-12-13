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

// use tecnickcom\tcpdf;

use think\Loader;

use mikehaertl\wkhtmlto\Pdf;
use function Qiniu\json_decode;
// use FPDI\fpdf;
// use FPDI\fpdi;

class AdminIndexController extends AdminBaseController
{
    /**
     * 协议任务列表
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
        $data = $postService->adminArticleList($param);

        $data->appends($param);

        $protocolCategoryModel = new ProtocolCategoryModel();
        $categoryTree = $protocolCategoryModel->adminCategoryTree($categoryId);
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
     * 添加协议书
     * 
     */
    public function add()
    {
        $content = hook_one('protocol_admin_article_add_view');

        if (!empty($content)) {
            return $content;
        }

        $protocolCategoryModel = new ProtocolCategoryModel();
        $where = ['delete_time' => 0];
        $categories_model = $protocolCategoryModel->field('id, name, mode_type')->where($where)->select();
        $this->assign('categories_model', $categories_model);

        $themeModel = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');
        $this->assign('article_theme_files', $articleThemeFiles);
        return $this->fetch();
    }

    /**
     * 添加协议书提交
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();

            //状态只能设置默认值。未发布、未置顶、未推荐
            $data['post']['post_status'] = 1;
            $data['post']['is_top'] = 0;
            $data['post']['recommended'] = 0;
            $data['post']['published_time'] = date('Y-m-d H:i:s',time());

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

            $mode_type = Db::name('protocol_category')->where(['id'=>$post['protocol_category_id']])->value('mode_type');

            $protocolPostModel->adminAddArticle($data['post'], $mode_type);
            // dump($data['post']['categories_user']);
            // Db::name('protocol_category_user_post')->where('place = 0 and post_id = '.$protocolPostModel->id)
            // ->update(['frame' => $data['post']['categories_user']]);
            // dump(Db::name('protocol_category_user_post')->getLastSql());
            $data['post']['id'] = $protocolPostModel->id;
            $hookParam = [
                'is_add' => true,
                'article' => $data['post']
            ];
            hook('protocol_admin_after_save_article', $hookParam);

            // $filename = $protocolPostModel->id . '.pdf';
            // $url = cmf_get_domain().cmf_get_root()."/protocol/index/export/id/".$protocolPostModel->id.".html ";
            // shell_exec("xvfb-run wkhtmltopdf ". $url .$filename);

            // 生成 pdf
            $mode_id = $post['protocol_category_id'];
            
            $model_data = Db::name('protocol_category')->where('id='.$mode_id)->find();
            // dump($model_data);
            $model_data['more'] = json_decode($model_data['more'], true);
            $url = $model_data['more']['files'][0]['url'];
            
            // word_to_pdf($url, $protocolPostModel->id);
            
            $cd = "cd /www/wwwroot/wwfnba01/sign_online/admin/public/jodconverter-2.2.2/lib && ";
            $dir = " /www/wwwroot/wwfnba01/sign_online/admin/public/upload/protocol/pdf/".$protocolPostModel->id.".pdf";

            $docdir = "/www/wwwroot/wwfnba01/sign_online/admin/public/upload/".$url;
            $sh = $cd . " java -jar jodconverter-cli-2.2.2.jar ".$docdir.$dir;
            $result = shell_exec($sh);

            // file_put_contents('sh.txt', $sh);

            $this->success('添加成功!', url('AdminIndex/edit', ['id' => $protocolPostModel->id]));
        }

    }

    /**
     * 编辑协议
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
        $post = $protocolPostModel->where('id', $id)->find();
        $postCategories = $post->categories()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds = implode(',', array_keys($postCategories));
        $this->assign('post_categories', $postCategories);
        $this->assign('post_category_ids', $postCategoryIds);
        // dump($postCategories);

        // 协议模板数据
        $protocolCategoryModel = new ProtocolCategoryModel();
        $where = ['delete_time' => 0];
        $categories_model = $protocolCategoryModel->field('id, name, mode_type')->where($where)->select();
        $this->assign('categories_model', $categories_model);
        // dump($categories_model);

        $postCategories_seal = $post->categories_seal()->alias('a')->column('a.name', 'a.id');
        $postCategoryIds_seal = implode(',', array_keys($postCategories_seal));
        $this->assign('post_categories_seal', $postCategories_seal);
        $this->assign('post_category_ids_seal', $postCategoryIds_seal);

        $postCategories_seal_place = $post->categories_seal()->alias('a')->column('pivot.place', 'a.id');
        $postCategoryIds_seal_place = implode(',', $postCategories_seal_place);
        $this->assign('post_category_places_seal', $postCategoryIds_seal_place);

        // 承诺人
        $postCategories_user = $post->categories_user()->alias('a')->where('pivot.place = 0')->column('a.user_login', 'a.id');
        $postCategoryIds_user = implode(',', array_keys($postCategories_user));  
        $this->assign('post_categories_user', $postCategories_user);
        $this->assign('post_category_ids_user', $postCategoryIds_user);
        // $postCategories_user = Db::name('protocol_category_user_post')->alias('pcup')->join('__FRAME_CATEGORY__ fc', 'pcup.frame = fc.id')
        // ->where('pcup.post_id = '.$id)->field('fc.id, fc.name')->select()->toArray();
        // $postCategories_user_arr = array();
        // $postCategories_user_id_arr = array();
        // foreach ($postCategories_user as $key => $value) {
        //     $postCategories_user_arr[] = $value['name'];
        //     $postCategories_user_id_arr[] = $value['id'];
        // }
        // $postCategories_user_frame = Db::name('protocol_category_user_post')->alias('pcup')
        // ->where('pcup.post_id = '.$id)->find();
        // $frame_ids = explode(',', $postCategories_user_frame['frame']);
        // // dump($frame_ids);
        // foreach ($frame_ids as $key => $value) {
        //     # code...
        //     $frame_data = Db::name('frame_category')->where('id = '. $value)->find();
        //     $postCategoryIds_user[] = $frame_data['name'];
        // }
        // $frame_ids = implode(',', $frame_ids);        
        // $this->assign('post_categories_user', $postCategories_user_arr);
        // $this->assign('post_category_ids_user', $frame_ids);

        // 负责人
        $postCategories_user_one = $post->categories_user()->alias('a')->where('pivot.place = 1')->column('a.user_login', 'a.id');
        $postCategoryIds_user_one = implode(',', array_keys($postCategories_user_one));        
        $this->assign('post_categories_user_one', $postCategories_user_one);
        $this->assign('post_category_ids_user_one', $postCategoryIds_user_one);

        // $postCategories_user_place = $post->categories_user()->alias('a')->column('pivot.place', 'a.id');
        // $postCategoryIds_user_place = implode(',', $postCategories_user_place);
        // $this->assign('post_category_places_user', $postCategoryIds_user_place);

        // $themeModel = new ThemeModel();
        // $articleThemeFiles = $themeModel->getActionThemeFiles('protocol/Article/index');
        // $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('post', $post);
        

        // $filename = '/home/lin/下载/四书模板/四书模板/xxxx保密工作责任书（通用部门）.doc';

        // $content = shell_exec('/usr/local/bin/antiword -m UTF-8.txt '.$filename);  
        // dump($content);
        // $this->assign('content', $content);
        
        // 不同协议模板类型,加载不同页面
        // $mode_type = $post->categories()->alias('a')->value('a.mode_type');
        // if($mode_type == 1){                    // 保密工作责任书
        //     return $this->fetch('edit_1');
        // }elseif($mode_type == 2){               // 员工保密承诺书
        //     return $this->fetch('edit_2');
        // }elseif($mode_type == 3){               // 涉密人员保证书
        //     return $this->fetch('edit_3');
        // }elseif($mode_type == 4){               // 涉密人员离岗保密承诺书
        //     return $this->fetch('edit_4');
        // }else{
        //     return $this->fetch();
        // }

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
            unset($data['post']['post_status']);
            unset($data['post']['is_top']);
            unset($data['post']['recommended']);

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
            
            $mode_type = Db::name('protocol_category')->where(['id'=>$post['protocol_category_id']])->value('mode_type');
            // dump($mode_type);exit();

            // $protocolPostModel->adminEditArticle($data['post'], $data['post']['categories_seal'], $data['post']['categories_user'], $data['post']['categories_user_one']);
            $protocolPostModel->adminEditArticle($data['post'], $mode_type);
            $hookParam = [
                'is_add' => false,
                'article' => $data['post']
            ];
            hook('protocol_admin_after_save_article', $hookParam);

            // $filename = $protocolPostModel->id . '.pdf';
            // $url = cmf_get_domain().cmf_get_root()."/protocol/index/export/id/".$protocolPostModel->id.".html ";
            // $cd_url = '/www/wwwroot/wwfnba01/sign_online/admin/public/protocol';
            // // $cd_url = '/var/www/sign_online/admin/public/protocol';
            // shell_exec("cd ".$cd_url." && xvfb-run wkhtmltopdf ". $url .$filename);
            
            // 生成 pdf
            // $mode_id = $post['protocol_category_id'];
            // // dump($mode_id);
            // $model_data = Db::name('protocol_category')->where('id='.$mode_id)->find();
            // $model_data['more'] = json_decode($model_data['more'], true);
            // $url = $model_data['more']['files'][0]['url'];
            
            // $cd = "cd /www/wwwroot/wwfnba01/sign_online/admin/public/jodconverter-2.2.2/lib && ";
            // $dir = " /www/wwwroot/wwfnba01/sign_online/admin/public/protocol/".$protocolPostModel->id.".pdf";

            // $docdir = "/www/wwwroot/wwfnba01/sign_online/admin/public/upload/".$url;
            // $sh = $cd . " java -jar jodconverter-cli-2.2.2.jar ".$docdir.$dir;
            // $result = shell_exec($sh);
            $this->success('保存成功!');
        }
    }

    /**
     * 协议任务删除
     * 
     */
    public function delete()
    {
        $param = $this->request->param();
        $protocolPostModel = new ProtocolPostModel();

        if (isset($param['id'])) {
            $id = $this->request->param('id', 0, 'intval');
            $result = $protocolPostModel->where(['id' => $id])->find();
            $data = [
                'object_id' => $result['id'],
                'create_time' => time(),
                'table_name' => 'protocol_post',
                'name' => $result['post_title'],
                'user_id' => cmf_get_current_admin_id()
            ];
            // $resultprotocol = $protocolPostModel
            //     ->where(['id' => $id])
            //     ->update(['delete_time' => time()]);
            $resultprotocol = $protocolPostModel->where(['id' => $id])->delete();
            Db::name('protocol_category_post')->where(['post_id' => $id])->delete();
            Db::name('protocol_category_seal_post')->where(['post_id' => $id])->delete();
            Db::name('protocol_category_user_post')->where(['post_id' => $id])->delete();
            // if ($resultprotocol) {
            //     Db::name('protocol_category_post')->where(['post_id' => $id])->update(['status' => 0]);
            //     Db::name('protocol_tag_post')->where(['post_id' => $id])->update(['status' => 0]);

            //     Db::name('recycleBin')->insert($data);
            // }
            $this->success("删除成功！", '');

        }

        if (isset($param['ids'])) {
            $ids = $this->request->param('ids/a');

            $protocolPostModel->where(['id' => ['in', $ids]])->delete();
            Db::name('protocol_category_post')->where(['post_id' => ['in', $ids]])->delete();
            Db::name('protocol_category_seal_post')->where(['post_id' => ['in', $ids]])->delete();
            Db::name('protocol_category_user_post')->where(['post_id' => ['in', $ids]])->delete();
            // $recycle = $protocolPostModel->where(['id' => ['in', $ids]])->select();
            // $result = $protocolPostModel->where(['id' => ['in', $ids]])->update(['delete_time' => time()]);
            // if ($result) {
                // Db::name('protocol_category_post')->where(['post_id' => ['in', $ids]])->update(['status' => 0]);
                // Db::name('protocol_tag_post')->where(['post_id' => ['in', $ids]])->update(['status' => 0]);
                // foreach ($recycle as $value) {
                //     $data = [
                //         'object_id' => $value['id'],
                //         'create_time' => time(),
                //         'table_name' => 'protocol_post',
                //         'name' => $value['post_title'],
                //         'user_id' => cmf_get_current_admin_id()
                //     ];
                //     Db::name('recycleBin')->insert($data);
                // }
                // $this->success("删除成功！", '');
            // }

            $this->success("删除成功！", '');
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
        $param = $this->request->param();
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
        $param = $this->request->param();
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
        $param = $this->request->param();
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

    public function verify()
    {
        $content = hook_one('protocol_admin_article_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');

        $protocolPostModel = new ProtocolPostModel();
        $post = $protocolPostModel->where('id', $id)->find();
        

        $list = $post->categories_user()->paginate(3);
        // dump($post->getLastSql());
        // dump($list);
        foreach ($list as &$value) {
            // dump($value);
            $value['sign_status'] = $value['pivot']['sign_status'];
            $value['notes'] = $value['pivot']['notes'];
            $value['protocol_user_post_id'] = $value['pivot']['id'];
            $value['user_id'] = $value['id'];
            $value['protocol_id'] = $value['pivot']['post_id'];
            if(empty($value['sign_url'])){
                $value['update_time'] = '';
            }else{
                $value['update_time'] = date('Y-m-d H:i', $value['update_time']);
            }

            $mode_type = Db::name('protocol_category')->alias('pc')
            ->join('__PROTOCOL_POST__ pp', 'pp.protocol_category_id = pc.id')
            ->where('pp.id = '.$value['protocol_id'])
            ->value('pc.mode_type');
            // $val['mode_type'] = $mode_type;
            if($mode_type == 1){
                $sign_status_option[-1] = '审核失败';
                $sign_status_option[0] = '待签约';
                $sign_status_option[1] = '已签约';
                $sign_status_option[2] = '已审核';
                $sign_status_option[9] = '签约成功';
            }elseif($mode_type == 2){
                $sign_status_option[-1] = '审核失败';
                $sign_status_option[0] = '待签约';
                $sign_status_option[1] = '员工已签约';
                $sign_status_option[2] = '负责已人签约';
                $sign_status_option[9] = '签约成功';
            }elseif($mode_type == 3){
                $sign_status_option[-1] = '审核失败';
                $sign_status_option[0] = '待签约';
                $sign_status_option[1] = '已签约';
                $sign_status_option[9] = '签约成功';
            }

        }

        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);


        $this->assign('post', $post);
        $this->assign('sign_status_option', $sign_status_option);
        return $this->fetch();
    }

    public function verifyPost()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();

            //需要抹除发布、置顶、推荐的修改。
            unset($data['post']['post_status']);
            unset($data['post']['is_top']);
            unset($data['post']['recommended']);

            $post = $data['post'];
            
            
            $update_id = $post['id'];
            // dump($post);
            foreach ($update_id as $key => $value) {
                # code...
                $save['id'] = $value;
                $save['post_id'] = $post['post_id'];
                $save['sign_status'] = $post['sign_status'][$key];
                $save['notes'] = $post['notes'][$key];

                if($post['sign_status'][$key] == -1){
                    $save['sign_url'] = '';
                    $save['update_time'] = null;
                }

                // if($post['sign_status'][$key] == 9){
                //     $sign_url = Db::name('protocol_category_user_post')->where('id='.$value)->value('sign_url');
                //     if(!$sign_url){
                //         $this->error('未签约用户无法通过审核');
                //     }
                // }

                Db::name('protocol_category_user_post')->update($save);
            }

            // dump(Db::name('protocol_category_user_post')->getLastSql());
            $this->success('保存成功!');

        }
    }

    /**
     * 批量审核
     *
     * @return void
     */
    public function checkall(){
        if ($this->request->isPost()) {
            $data = $this->request->param();

            $protocol_id = $data['protocol_id'];
            // $user_count = $data['user_count'];
            if(empty($protocol_id)){
                $this->error('协议不存在');
            }

            $protocolCategoryModel = new ProtocolCategoryModel();
            $protocolPostModel = new ProtocolPostModel();
            $mode_type = $protocolCategoryModel->get_protocol_mode($protocol_id);
            if($mode_type == 1){
                // 保密工作责任书  添加保密委印章
                $map_userpost['post_id'] = $protocol_id;
                $map_userpost['sign_status'] = 1;
                $sign_users = Db::name('protocol_category_user_post')->where($map_userpost)->select();
                foreach ($sign_users as $value) {
                    $protocolPostModel->add_bmw($protocol_id, $value['category_id']);
                    $map['post_id'] = $protocol_id;
                    $map['category_id'] = $value['category_id'];
                    Db::name('protocol_category_user_post')->where($map)->update(['sign_status'=>9]);
                }
            }elseif($mode_type == 2){
                $map_userpost['post_id'] = $protocol_id;
                $map_userpost['sign_status'] = 2;
                $sign_users = Db::name('protocol_category_user_post')->where($map_userpost)->select();
                foreach ($sign_users as $value) {
                    $map['post_id'] = $protocol_id;
                    $map['category_id'] = $value['category_id'];
                    Db::name('protocol_category_user_post')->where($map)->update(['sign_status'=>9]);
                }

            }elseif($mode_type == 3){
                $map_userpost['post_id'] = $protocol_id;
                $map_userpost['sign_status'] = 1;
                $sign_users = Db::name('protocol_category_user_post')->where($map_userpost)->select();
                foreach ($sign_users as $value) {
                    $map['post_id'] = $protocol_id;
                    $map['category_id'] = $value['category_id'];
                    Db::name('protocol_category_user_post')->where($map)->update(['sign_status'=>9]);

                }
            }

            // if($is_all_check){
            //     $this->error('存在未签约用户,审核失败');
            // }else{
            //     $map['post_id'] = $protocol_id;
            //     Db::name('protocol_category_user_post')->where($map)->update(['sign_status'=>9]);
            //     $this->success('保存成功!');
            // }

            $this->success('保存成功!');
            

        }
    }

    /**
     * PDF 导出
     *
     * @return void
     */
    public function export()
    {

        $protocol_id = $this->request->param('id', 0, 'intval');
        $uid = $this->request->param('uid', 0, 'intval');

        $user = Db::name('user')->where('id = '. $uid)->find();
        $model_data = Db::name('protocol_category')->alias('pc')->field('pc.*')
        ->join('__PROTOCOL_POST__ pp', 'pc.id = pp.protocol_category_id')
        ->where('pp.id = '.$protocol_id)->find();
        // dump($model_data);exit();
        $protocol_data = Db::name('protocol_category_user_post')->where(['post_id' => $protocol_id, 'category_id' => $uid])->find();
        if($protocol_data['view_file']){
            $rename = 'upload/'.$protocol_data['view_file'];
        }else{
            $rename = 'upload/protocol/pdf/'.$protocol_id.'.pdf';

        }

        $output_name = $user['user_login'].'_'.$model_data['name'].'.pdf';
        // rename($filename, $rename);
        // echo exec('whoami');
        // dump($url);
        // $rename = 'upload/protocol/pdf/'.$protocol_id.'.pdf';
        if(file_exists($rename)){
            header("Content-type:application/pdf");
            header("Content-Disposition:attachment;filename=".$output_name);
            echo file_get_contents($rename);
            //echo "{$rename}.pdf";
            // unlink($rename);
        }else{
            exit;
        }

        exit();

        
        // require_once(ROOT_PATH . 'public/FPDI/fpdf.php');
        // require_once(ROOT_PATH . 'public/FPDI/fpdi.php');

        Loader::import('FPDI.fpdf', EXTEND_PATH);
        Loader::import('FPDI.fpdi', EXTEND_PATH);
        $pdf = new \FPDI();

        $id = $this->request->param('id', 0, 'intval');

        $uid = $this->request->param('uid', 0, 'intval');
        
        $user = Db::name('user')->where('id = '. $uid)->find();

        $model_data = Db::name('protocol_category')->alias('pc')->field('pc.*')->join('__PROTOCOL_CATEGORY_POST__ pcp', 'pc.id = pcp.category_id')->where('pcp.post_id = '.$id)->find();
        $model_data['more'] = json_decode($model_data['more'], true);
        // print_r(shell_exec("ls"));
        // shell_exec("sudo php -v");
        
        $filename = time() . '.pdf';
        // $url = cmf_get_domain().cmf_get_root()."/protocol/index/export/id/".$id."/uid/".$uid.".html ";
        // shell_exec("xvfb-run wkhtmltopdf ". $url .$filename);
        // shell_exec("sudo /usr/local/bin/wkhtmltopdf --print-media-type http://www.baidu.com termo590.pdf 2>&1");
        
        $user_post = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'category_id' => $uid])->find();
        if($user_post){
            $sign_url = cmf_get_image_preview_url($user_post['sign_url']);
            
            $sign_time_year = date('Y', $user_post['update_time']);
            $sign_time_month = date('m', $user_post['update_time']);
            $sign_time_day = date('d', $user_post['update_time']);
            $sign_time = iconv("utf-8","gbk", $sign_time_year . '年' . $sign_time_month . '月' . $sign_time_day . '日');
            
            // 需要插入签名的位置信息
            $place_data = $model_data['more']['axes'][$user_post['place']];
            if($place_data){
                $page = $place_data['page'];
                $sign = explode(',', $place_data['sign']);
                $time = explode(',', $place_data['time']);
            }

            // 如果有公章坐标
            $seal_data = $model_data['more']['seal'];
            if($seal_data){
                $seal_page = $seal_data['page'];
                $seal_sign = explode(',', $seal_data['sign']);
            }

            // 承诺人签字,查找是否有负责人
            $user_post2 = null;
            $place_data2 = null;
            if($user_post['place'] == 0){
                $user_post2 = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'place' => 1])->find();
                if($user_post2){
                    $sign_url2 = cmf_get_image_preview_url($user_post2['sign_url']);
            
                    $sign_time_year2 = date('Y', $user_post2['update_time']);
                    $sign_time_month2 = date('m', $user_post2['update_time']);
                    $sign_time_day2 = date('d', $user_post2['update_time']);
                    $sign_time2 = iconv("utf-8","gbk", $sign_time_year2 . '年' . $sign_time_month2 . '月' . $sign_time_day2 . '日');
                    
                    if(isset($model_data['more']['axes'][$user_post2['place']])){
                        $place_data2 = $model_data['more']['axes'][$user_post2['place']];
                        if($place_data2){
                            $page2 = $place_data2['page'];
                            $sign2 = explode(',', $place_data2['sign']);
                            $time2 = explode(',', $place_data2['time']);
                        }
                    }
                    
                }
            }

            // 插入图片

            $pdf->AddGBFont('sinfang','仿宋_GB2312'); 
            $pdf->SetFont('sinfang','',16); 

            $pageCount = $pdf->setSourceFile('./protocol/'.$id.'.pdf');
            // dump($sign[0]); exit();
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++){
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
                if ($size['w'] > $size['h']) 
                $pdf->AddPage('L', array($size['w'], $size['h']));
                else 
                $pdf->AddPage('P', array($size['w'], $size['h']));

                $pdf->useTemplate($templateId);
                // dump($templateId);
                // 插入承诺人签名
                if($user_post['sign_url'] && $pageNo == $page){
                    $pdf->image($sign_url, $sign[0], $sign[1], 50);//加上图片水印，后为坐标
                    // $pdf->Text($time[0], $time[1], $sign_time);
                    $date_path = time() . 'date1.png';
                    gettimeimg($sign_time, $date_path);
                    $pdf->image(cmf_get_image_preview_url('dateimg/'.$date_path), $time[0], $time[1]-10, 50);

                    // 如果有公章数据,则插入
                    if($seal_data){

                        // 获取公章图片插入
                        $seal_category_data = Db::name('seal_category')->alias('sc')->field('sc.*')->join('__PROTOCOL_CATEGORY_SEAL_POST__ pcsp', 'sc.id = pcsp.category_id')->where('pcsp.post_id = '.$id)->find();
                        $seal_img = json_decode($seal_category_data['more'], true);
                        $seal_img = cmf_get_image_preview_url($seal_img['thumbnail']);
                        $pdf->image($seal_img, $seal_sign[0], $seal_sign[1], 30);

                    }

                }

                // 如果存在,插入负责人签名
                if($user_post2 && $place_data2){
                    if($user_post2['sign_url'] && $pageNo == $page2){
                        $pdf->image($sign_url2, $sign2[0], $sign2[1], 50);//加上图片水印，后为坐标
                        // $pdf->Text($time2[0], $time2[1], $sign_time2);
                        $date_path2 = time() . 'date2.png';
                        gettimeimg($sign_time2, $date_path2);
                        $pdf->image(cmf_get_image_preview_url('dateimg/'.$date_path2), $time2[0], $time2[1]-10, 50);
                    }
                }
                
            }
            $pdf->Output('F', $filename);
        }

        

        // 无法直接生成中文文件,采用重命名方式
        $rename = $user['user_login'].'_'.$model_data['name'].'.pdf';
        rename($filename, $rename);
        // echo exec('whoami');
        // dump($url);
        if(file_exists($rename)){
            header("Content-type:application/pdf");
            header("Content-Disposition:attachment;filename=".$rename);
            echo file_get_contents($rename);
            //echo "{$rename}.pdf";
            unlink($rename);
        }else{
            exit;
        }
    }

    /**
     * 预览
     *
     * @return void
     */
    public function view()
    {
        // $post_id = 98;
        // $seal_url = ROOT_PATH . '/public/upload/frame/20181207/4db3e7801d7c286a61b63b78cbc90a89.gif';
        // $origin_pdf_url = ROOT_PATH .'/public/upload/protocol/pdf/' . $post_id . '.pdf';
        
        //     $_w = [
        //         [
        //             'pic'       => $seal_url,
        //             'page'      => 1,
        //             'position'  => explode(',', '100,100'),
        //             'size'      => 30
        //         ]
        //     ];
        //     $file = 'sign_'.$post_id.'_1234.pdf';
        //     $res = edit_pdf($origin_pdf_url, $_w, $file);
        //     exit();

        $protocol_id = $this->request->param('id', 0, 'intval');
        $uid = $this->request->param('uid', 0, 'intval');

        $protocol_data = Db::name('protocol_category_user_post')->where(['post_id' => $protocol_id, 'category_id' => $uid])->find();
        if($protocol_data['view_file']){
            $this->redirect(cmf_get_domain().'/upload/'.$protocol_data['view_file']);
        }else{
            $this->redirect(cmf_get_domain().'/upload/protocol/pdf/'.$protocol_id.'.pdf');
        }
        exit();

        // $user = Db::name('user')->where('id = '. $uid)->find();

        // 协议书数据
        $protocol_data = Db::name('protocol_post')->alias('pp')->join('__PROTOCOL_CATEGORY__ pc', 'pp.protocol_category_id = pc.id')
        ->join('__PROTOCOL_CATEGORY_USER_POST__ pcup', 'pcup.post_id = pp.id')->where(['pp.id'=>$protocol_id, 'pcup.category_id' => $uid])
        ->field('pp.id, pc.more, pc.mode_type, pcup.sign_status, pcup.place, pcup.sign_url')->find();
        $protocol_data['more'] = json_decode($protocol_data['more'], true);

        // 用户数据
        $userframe_data = Db::name('frame_category')->alias('fc')->join('__FRAME_CATEGORY_POST__ fcp', 'fc.id = fcp.category_id')
        ->where(['fcp.post_id' => $uid])->find();
        $userframe_data['more'] = json_decode($userframe_data['more'], true);
        
        // dump($protocol_data);
        // dump($userframe_data);exit();

        // 保密工作责任书
        if($protocol_data['mode_type'] == 1){
            //待签约 添加部门印章
            if($protocol_data['sign_status'] == 0){  
                if(empty($userframe_data['more'])){
                    $this->error('缺少所在部门印章图片');
                }
                $pdfdata['pic'] = cmf_get_image_preview_url($userframe_data['more']['thumbnail']);
                $pdfdata['page'] = $protocol_data['more']['frame']['page'];
                $position = explode(',', $protocol_data['more']['frame']['sign']);
                $pdfdata['position'] = $position;

                $filename = time() . '.pdf';

                $original_file = ROOT_PATH . '/public/protocol/' . $protocol_id . '.pdf';
                $result = edit_pdf($original_file, $pdfdata, $filename, 30);
                dump($result);
            }
        }
        exit();
        $model_data = Db::name('protocol_category')->alias('pc')->field('pc.*')->join('__PROTOCOL_CATEGORY_POST__ pcp', 'pc.id = pcp.category_id')->where('pcp.post_id = '.$id)->find();





        // gettimeimg();exit();
        define('FPDF_FONTPATH',ROOT_PATH. 'public/FPDI/font/');


        Loader::import('FPDI.fpdf', EXTEND_PATH);
        Loader::import('FPDI.fpdi', EXTEND_PATH);
        $pdf = new \FPDI();

        
        
        $model_data['more'] = json_decode($model_data['more'], true);
        // dump($model_data);
        $filename = 'view.pdf';
        // $url = cmf_get_domain().cmf_get_root()."/protocol/index/export/id/".$id."/uid/".$uid.".html ";
        // shell_exec("xvfb-run wkhtmltopdf ". $url .$filename);
        // shell_exec("sudo /usr/local/bin/wkhtmltopdf --print-media-type http://www.baidu.com termo590.pdf 2>&1");
        
        $user_post = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'category_id' => $uid])->find();
        // dump($user_post); exit();
        if($user_post){

            // 需要插入签名的位置信息
            // dump(ROOT_PATH . 'public/protocol/'.$id.'.pdf');exit();
            $sign_url = cmf_get_image_preview_url($user_post['sign_url']);
            
            $sign_time_year = date('Y', $user_post['update_time']);
            $sign_time_month = date('m', $user_post['update_time']);
            $sign_time_day = date('d', $user_post['update_time']);
            $sign_time = iconv("utf-8","gbk", $sign_time_year . '年' . $sign_time_month . '月' . $sign_time_day . '日');
            $place_data = $model_data['more']['axes'][$user_post['place']];
            if($place_data){
                $page = $place_data['page'];
                $sign = explode(',', $place_data['sign']);
                $time = explode(',', $place_data['time']);
            }

            
            // 如果有公章坐标
            $seal_data = $model_data['more']['seal'];
            if($seal_data){
                $seal_page = $seal_data['page'];
                $seal_sign = explode(',', $seal_data['sign']);
            }

            // 部门公章坐标数据
            $frame_page = 0;
            $frame_sign = [0 => 0, 1 => 1];
            $frame_img = '';
            $frame_user_post = Db::name('frame_category')->alias('fc')->join('__FRAME_CATEGORY_POST__ fcp', 'fcp.category_id = fc.id')
            ->where(['fcp.post_id' => $uid])->field('fc.*')->find();
            if($frame_user_post){
                $frame_data = $model_data['more']['frame'];
                // if($frame_data){
                    $frame_page = $frame_data['page'];
                    $frame_sign = explode(',', $frame_data['sign']);
                // }
                
                $frame_img_arr = json_decode($frame_user_post['more'], true);
                $frame_img = !empty($frame_img_arr['thumbnail']) ? cmf_get_image_preview_url($frame_img_arr['thumbnail']) : '';

            }

            

            // dump($frame_user_post);exit();

            // 如果是承诺人签字,查找是否有负责人
            $user_post2 = null;
            $place_data2 = null;
            if($user_post['place'] == 0){
                $user_post2 = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'place' => 1])->find();
                if($user_post2){
                    $sign_url2 = cmf_get_image_preview_url($user_post2['sign_url']);
            
                    $sign_time_year2 = date('Y', $user_post2['update_time']);
                    $sign_time_month2 = date('m', $user_post2['update_time']);
                    $sign_time_day2 = date('d', $user_post2['update_time']);
                    $sign_time2 = iconv("utf-8","gbk", $sign_time_year2 . '年' . $sign_time_month2 . '月' . $sign_time_day2 . '日');
                    if(isset($model_data['more']['axes'][$user_post2['place']])){
                        $place_data2 = $model_data['more']['axes'][$user_post2['place']];
                        if($place_data2){
                            $page2 = $place_data2['page'];
                            $sign2 = explode(',', $place_data2['sign']);
                            $time2 = explode(',', $place_data2['time']);
                        }
                    }
                    
                }
            }

            $pdf->AddGBFont('sinfang','仿宋_GB2312'); 
            $pdf->SetFont('sinfang','',16); 

            $pageCount = $pdf->setSourceFile('./protocol/'.$id.'.pdf');
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++){
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
                if ($size['w'] > $size['h']) 
                $pdf->AddPage('L', array($size['w'], $size['h']));
                else 
                $pdf->AddPage('P', array($size['w'], $size['h']));

                $pdf->useTemplate($templateId);
                // dump($templateId);

                // $pdf->image(cmf_get_image_preview_url('08a7bd611707f2a894b0839c88469a9d.jpg'), 10, 10, 40);
                // dump($page);exit();
                // 插入承诺人签名
                if($user_post['sign_url'] && $pageNo == $page){
                    $pdf->image($sign_url, $sign[0], $sign[1], 50);//加上图片水印，后为坐标
                    // $pdf->Text($time[0], $time[1], $sign_time);
                    $date_path = time() . 'date1.png';
                    gettimeimg($sign_time, $date_path);
                    $pdf->image(cmf_get_image_preview_url('dateimg/'.$date_path), $time[0], $time[1]-10, 50);

                    // 如果有公章数据,则插入
                    if($seal_data){

                        // 获取公章图片插入
                        $seal_category_data = Db::name('seal_category')->alias('sc')->field('sc.*')->join('__PROTOCOL_CATEGORY_SEAL_POST__ pcsp', 'sc.id = pcsp.category_id')->where('pcsp.post_id = '.$id)->find();
                        $seal_img = json_decode($seal_category_data['more'], true);
                        $seal_img = cmf_get_image_preview_url($seal_img['thumbnail']);
                        $pdf->image($seal_img, $seal_sign[0], $seal_sign[1], 30);

                    }

                }

                // 如果存在,插入负责人签名
                if($user_post2 && $place_data2){
                    if($user_post2['sign_url'] && $pageNo == $page2){
                        $pdf->image($sign_url2, $sign2[0], $sign2[1], 50);//加上图片水印，后为坐标
                        // $pdf->Text($time2[0], $time2[1], $sign_time2);
                        $date_path2 = time() . 'date2.png';
                        gettimeimg($sign_time2, $date_path2);
                        $pdf->image(cmf_get_image_preview_url('dateimg/'.$date_path2), $time2[0], $time2[1]-10, 50);
                    }
                }

                // 插入部门公章
                if($frame_page && $frame_img){
                    if($pageNo == $frame_page){
                        $pdf->image($frame_img, $frame_sign[0], $frame_sign[1], 30);
                    }
                }   
                
            }
            $pdf->Output('F', $filename);

        }
        // unlink('date1.png');
        // unlink('date')
        $this->redirect(cmf_get_domain().'/view.pdf');

        // // 无法直接生成中文文件,采用重命名方式
        // $rename = $user['user_login'].'_'.$model_data['name'].'.pdf';
        // rename($filename, $rename);
        // // echo exec('whoami');
        // // dump($url);
        // if(file_exists($rename)){
        //     header("Content-type:application/pdf");
        //     header("Content-Disposition:attachment;filename=".$rename);
        //     echo file_get_contents($rename);
        //     //echo "{$rename}.pdf";
        //     unlink($rename);
        // }else{
        //     exit;
        // }
    }
}
