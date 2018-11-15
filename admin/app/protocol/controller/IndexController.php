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

use cmf\controller\HomeBaseController;
use app\protocol\model\ProtocolPostModel;
use app\protocol\service\PostService;
use app\protocol\model\ProtocolCategoryModel;
use think\Db;
use app\admin\model\ThemeModel;

use Dompdf\Dompdf;

// use tecnickcom\tcpdf;

use think\Loader;
use function Qiniu\json_decode;

class IndexController extends HomeBaseController
{
    /**
     * 导出pdf
     */
    public function export()
    {
        // echo 1;
        // exit();
        $content = hook_one('protocol_admin_article_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');

        $uid = $this->request->param('uid', 0, 'intval');

        $protocolPostModel = new ProtocolPostModel();
        $post = $protocolPostModel->where('id', $id)->find();

        $postCategories_seal = $post->categories_seal()->alias('a')->column('a.name, a.more', 'a.id');
        

        foreach ($postCategories_seal as &$value) {
            $seal_post = Db::name('protocol_category_seal_post')->where(['post_id'=>$id, 'category_id' => $value['id']])->find();
            // dump($seal_post);
            $value['more'] = json_decode($value['more'], true);
            
            $value['more']['thumbnail'] = cmf_get_image_preview_url($value['more']['thumbnail']);
            
            $replace = '<img src="'.$value['more']['thumbnail'].'" title="" alt="" width="106" height="165" style="width: 106px; height: 165px;">';
            $post['post_content'] = str_replace($seal_post['place'], $replace, $post['post_content']);
        }

        $postCategories_user = $post->categories_user()->alias('a')->column('a.user_login', 'a.id');
        $user_post = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'category_id' => $uid])->find();
        // dump($user_post);
        $user_post['sign_url'] = cmf_get_image_preview_url($user_post['sign_url']);
        $replace = '<img src="'.$user_post['sign_url'].'" title="" alt="" width="106" height="165" style="width: 106px; height: 165px;">';
        $post['post_content'] = str_replace($user_post['place'], $replace, $post['post_content']);
        // dump($user_post);

        // 其他用户签名
        $other_user = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'place' => ['<>', $user_post['place']]])->find();

        // dump(Db::name('protocol_category_user_post')->getLastSql());
        if($other_user){
            $other_user['sign_url'] = cmf_get_image_preview_url($other_user['sign_url']);
            $replace = '<img src="'.$other_user['sign_url'].'" title="" alt="" width="106" height="165" style="width: 106px; height: 165px;">';
            $post['post_content'] = str_replace($other_user['place'], $replace, $post['post_content']);
        }
        // $post['post_content'] = "abcjsdfsdfdf";
        $this->assign('post', $post);
        return $this->fetch();

        
    }
}
