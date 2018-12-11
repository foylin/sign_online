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
use api\protocol\model\UserModel;
use api\protocol\model\FrameCategoryModel;
use think\Db;

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
        
        $userId = $this->getUserId();

        $user = UserModel::get($userId);

        $page = $params['page']?$params['page']:1;
        $limit = 10;
        $p = ($page-1) * $limit;
        $where = ['p.delete_time'=>0,'pu.status'=>1,'pu.place'=>0];
        
        $field = 'p.post_title,p.id,pu.sign_status,pu.id as pcup_id,pu.category_id as uid,pc.mode_type';
        //type 1:保密工作责任书（通用部门);2:员工保密承诺书;3:涉密人员保证书;4:涉密人员离岗保密承诺书
        
        if($user['user_type'] == 3) {
            //保密委 只查看负责人签约的保密工作责任书
            $where['fc.type'] = 3;
            $where['pu.sign_status'] = array('egt',1);
            $where['pc.mode_type'] = 1;
        } else if($user['user_type'] == 2) {
            $staff_type = $user->frame_category_post->type;  //1一般员工 2副职  3正职负责人
            $is_sec = $user->frame_category_post->is_sec;  //0涉密 1非涉密

            $where['pu.category_id'] = $userId;
            $where['pu.sign_status'] = array('egt',-1);

            if(isset($params['status']) && $params['status']=='0') {
                //待签约
                $where['pu.sign_status'] = 0;
            }
            if(isset($params['status']) && $params['status']=='1') {
                //待签约
                $where['pu.sign_status'] = array('gt',0);
            }


            if($staff_type == 3 && $is_sec == 1) {
                //正职负责人  涉密人员保证书&涉密人员离岗保密承诺书
                $where['pc.mode_type'] = [ [ 'eq', 1 ],[ 'eq', 3 ] , 'or' ];
            }else if($staff_type == 3 && $is_sec == 0) {
                $where['pc.mode_type'] = 1;
            }else if($staff_type != 3 && $is_sec == 1) {
                $where['pc.mode_type'] = [ [ 'eq', 2 ],[ 'eq', 3 ] , 'or' ];
            }else if($staff_type != 3 && $is_sec == 0) {
                $where['pc.mode_type'] = 2;
            }
        } else {
            $this->success('请求成功!', []);
        }
        
        $data = Db::name('protocol_category_user_post')->alias('pu')
                ->field($field)
                ->join('__PROTOCOL_POST__ p','pu.post_id = p.id')
                ->join('__PROTOCOL_CATEGORY__ pc','p.protocol_category_id = pc.id')
                ->join('__FRAME_CATEGORY_POST__ fc','pu.category_id = fc.post_id')
                ->where($where)
                ->order("pu.id DESC")
                ->limit($p,$limit)
                ->select()->toArray();
        // $data['sql'] = Db::name('')->getLastSql();

        if($data) {
            foreach($data as $k=>$v) {

                $status = $this->getStatus($v['mode_type']);
                $data[$k]['sign_status_desc'] = (!empty($status[$v['sign_status']]))?$status[$v['sign_status']]:'';
            }
        }

        if (isset($this->apiVersion)) {
            $response = ['list' => $data];
        } else {
            $response = $data;
        }
        $this->success('请求成功!', $response);
        
        // if($params['status'] == 1){
        //     $where['tp.sign_status'] = 1;
        // }elseif($params['status'] == 2){
        //     $where['tp.sign_status'] = 2;
        // }
        // $where['a.post_status'] = 1;
        // $where['tp.category_id'] = $userId;
        // $data = $this->postModel->setCondition($params)->alias('a')
        // ->join('__PROTOCOL_CATEGORY_USER_POST__ tp', 'a.id = tp.post_id', 'LEFT')
        // ->field('a.id, a.post_title, tp.category_id AS uid, tp.sign_status, tp.notes')
        // ->where($where)->select();

        // if (isset($this->apiVersion)) {
        //     $response = ['list' => $data];
        // } else {
        //     $response = $data;
        // }

        // $this->success('请求成功!', $response);
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

    //查看负责人管辖部门下员工签约列表
    public function fz_sign() {

        $userId = $this->getUserId();
    
        $where = ['p.delete_time'=>0,'pu.place'=>1,'pu.category_id'=>$userId];
        $data = Db::name('protocol_category_user_post')->alias('pu')
                    ->field('p.post_title,pu.post_id')
                    ->join('__PROTOCOL_POST__ p','pu.post_id = p.id','left')
                    ->where($where)
                    ->group('pu.post_id')
                    ->select()->toArray();
        
        if (isset($this->apiVersion)) {
            $response = ['list' => $data];
        } else {
            $response = $data;
        }
        $this->success('请求成功!', $response);
        // $this->success('ok', ['data'=>$data,'sql'=>Db::name('')->getLastSql()]);
    }

    //员工签约情况
    public function fz_sign_list() {


        $post_id = $this->request->param('post_id', 0, 'intval');
        if(!$post_id) $this->error('签约书不存在');
        
        $userId = $this->getUserId();
        $category_id = Db::name('frame_category_post')->where('post_id',$userId)->value('category_id');

        $user_ids = Db::name('frame_category_post')
                ->where('category_id',$category_id)
                ->where('status',1)
                ->where('post_id','<>',$userId)
                ->column('post_id');
        $data = Db::name('protocol_category_user_post')->alias('pu')
                ->field('p.post_title,pu.post_id,pu.sign_status,u.user_login,pu.category_id as uid,pu.id as pcup_id')
                ->join('__PROTOCOL_POST__ p','pu.post_id = p.id','left')
                // ->join('__PROTOCOL_CATEGORY__ pc','p.protocol_category_id = pc.id','left')
                // ->join('__FRAME_CATEGORY_POST__ fc','pu.category_id = fc.post_id','left')
                ->join('__USER__ u','pu.category_id = u.id','left')
                ->where('pu.category_id','in',$user_ids)
                ->where('pu.place',0)
                ->where('pu.post_id',$post_id)
                ->order('pu.sign_status asc')
                ->select();
        $this->success('ok', ['list'=>$data,'sql'=>Db::name('')->getLastSql()]);
        
    }

    function getStatus($type) {
        $sta = [
            '1' => ['-1'=>'审核失败，重新签约','0'=>'待签约','1'=>'已签约,待保密委审核','2'=>'保密委已审核,待后台管理员审核','9'=>'签约成功,无法修改'],
            '2' => ['-1'=>'审核失败，重新签约','0'=>'待签约','1'=>'员工已签约,待部门负责人签约','2'=>'部门负责人已签约,已添加保密委印章,待后台管理员审核','9'=>'签约成功,无法修改'],
            '3' => ['-1'=>'审核失败，重新签约','0'=>'待签约','1'=>'涉密人员已签约,已添加保密委印章,待后台管理员审核','9'=>'签约成功,无法修改']
        ];
        return (!empty($sta[$type]))?$sta[$type]:[];
    }

    //保密委审批盖章
    public function sec_through() {

        $post_id = $this->request->param('post_id', 0, 'intval');
        $pcup_id = $this->request->param('pcup_id', 0, 'intval');

        $pro_user = Db::name('protocol_category_user_post')->where('id',$pcup_id)->find();

        if(!$post_id) $this->error('签约书不存在');
        $frame = FrameCategoryModel::get(999);
        if(!$frame || empty($frame['more']['thumbnail'])) {
            $this->error('保密委公章未设置');
        }
        $seal_url = ROOT_PATH . '/public/upload/' . $frame['more']['thumbnail'];
        if(!file_exists($seal_url)) $this->error('保密委公章未设置');

        //生成
        $origin_pdf_url = ROOT_PATH .'/public/upload/' . $pro_user['view_file'];
        // $res = seal($post_id, $pro_user['category_id'], 1, $seal_url, $origin_pdf_url);
        $protocol = ProtocolPostModel::get($post_id);
        $more = $protocol->categories->more;
        
        $_w = [
            [
                'pic'       => $seal_url,
                'page'      => $more['seal']['page'],
                'position'  => explode(',', $more['seal']['sign']),
                'size'      => 40
            ]
        ];
        $file = 'sign_'.$pro_user['post_id'].'_'.$pro_user['category_id'].'.pdf';
        $res = edit_pdf($origin_pdf_url, $_w, $file);
        if(!$res) $this->error('网络出错,请重试');

        //更新状态
        Db::name('protocol_category_user_post')->update(['id'=>$pcup_id,'sign_status'=>2,'view_file'=>$res]);

        $this->success('ok');
    }

    public function checkSign() {

        $post_id = $this->request->param('post_id', 0, 'intval');
        $uid = $this->request->param('uid', 0, 'intval');

        $user_protocol = Db::name('protocol_category_user_post')->where(['post_id'=>$post_id,'category_id'=>$uid])->find();
        //如果审核失败，清除原有的状态和文件地址
        // if($user_protocol['sign_status'] == -1) {
        //     Db::name('protocol_category_user_post')->update([
        //         'id'            => $user_protocol['id'],
        //         'is_add_sign'   => 0,
        //         'sign_status'   => 
        //     ]);
        // }
        if($user_protocol['is_add_sign'] == 0 || $user_protocol['sign_status'] == -1) {
            //添加部门印章
            $category_id = Db::name('frame_category_post')->where('post_id',$this->userId)->value('category_id');
            $frame = FrameCategoryModel::get($category_id);
            if(!$frame || empty($frame['more']['thumbnail'])) {
                $this->error('部门印章未设置');
            }
            $seal_url = ROOT_PATH . '/public/upload/' . $frame['more']['thumbnail'];
            if(!file_exists($seal_url)) $this->error('部门印章未设置');

            $origin_pdf_url = ROOT_PATH .'/public/upload/protocol/pdf/' . $post_id . '.pdf';
            $protocol = ProtocolPostModel::get($post_id);
            $more = $protocol->categories->more;
            // $_w = [];
            $_w = [
                [
                    'pic'       => $seal_url,
                    'page'      => $more['frame']['page'],
                    'position'  => explode(',', $more['frame']['sign']),
                    'size'      => 40
                ]
            ];
            // $this->success('ok',$_w);
            $file = 'sign_'.$post_id.'_'.$uid.'.pdf';
            $res = edit_pdf($origin_pdf_url, $_w, $file);
            if(!$res) $this->error('网络出错');
            Db::name('protocol_category_user_post')->update(['is_add_sign'=>1,'view_file'=>$res,'id'=>$user_protocol['id']]);
        }
        $_w = [];
        $this->success('ok');
    }

}
