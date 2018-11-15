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
        
        // 公章替换
        foreach ($postCategories_seal as &$value) {
            $seal_post = Db::name('protocol_category_seal_post')->where(['post_id'=>$id, 'category_id' => $value['id']])->find();
            // dump($seal_post);
            $value['more'] = json_decode($value['more'], true);
            
            $value['more']['thumbnail'] = cmf_get_image_preview_url($value['more']['thumbnail']);
            
            $replace = '<img src="'.$value['more']['thumbnail'].'" title="" alt="" style="width: 120px;">';
            $post['post_content'] = str_replace($seal_post['place'], $replace, $post['post_content']);
        }

        // 用户签名替换   日期替换
        $postCategories_user = $post->categories_user()->alias('a')->column('a.user_login', 'a.id');
        $user_post = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'category_id' => $uid])->find();
        if($user_post){
            // dump($user_post);
            $user_post['sign_url'] = cmf_get_image_preview_url($user_post['sign_url']);
            $replace = '<img src="'.$user_post['sign_url'].'" title="" alt="" style="width: 100px; height: auto; transform:rotate(-90deg); -moz-transform:rotate(-90deg);-webkit-transform:rotate(-90deg);">';
            $post['post_content'] = str_replace($user_post['place'], $replace, $post['post_content']);
            
            if($user_post['update_time']){
                $year = date('Y', $user_post['update_time']);
                $month = date('m', $user_post['update_time']);
                $day = date('d', $user_post['update_time']);
                // dump($year. $month . $day);
                $replace_year = str_replace( '}', '年}', $user_post['place']);
                $replace_month = str_replace( '}', '月}', $user_post['place']);
                $replace_day = str_replace( '}', '日}', $user_post['place']);
                $post['post_content'] = str_replace($replace_year, $year, $post['post_content']);
                $post['post_content'] = str_replace($replace_month, $month, $post['post_content']);
                $post['post_content'] = str_replace($replace_day, $year, $post['post_content']);
            }
            
        }
        


        // 其他用户签名
        $other_user = Db::name('protocol_category_user_post')->where(['post_id'=>$id, 'place' => ['<>', $user_post['place']]])->find();

        // dump(Db::name('protocol_category_user_post')->getLastSql());
        if($other_user){
            $other_user['sign_url'] = cmf_get_image_preview_url($other_user['sign_url']);
            $replace = '<img src="'.$other_user['sign_url'].'" title="" alt="" style="width: 100px; height: auto; transform:rotate(-90deg); -moz-transform:rotate(-90deg);-webkit-transform:rotate(-90deg);">';
            $post['post_content'] = str_replace($other_user['place'], $replace, $post['post_content']);
        }

        

        $this->assign('post', $post);
        
        return $this->fetch();

        
    }
}
