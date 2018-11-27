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

use app\admin\model\RouteModel;
use think\Model;
use think\Db;
// use App\Controller\Db;

class ProtocolPostModel extends Model
{

    protected $type = [
        'more' => 'array',
    ];

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    /**
     * 关联 user表
     * @return $this
     */
    public function user()
    {
        return $this->belongsTo('UserModel', 'user_id')->setEagerlyType(1);
    }

    /**
     * 关联分类表
     */
    public function categories()
    {
        return $this->belongsToMany('protocolCategoryModel', 'protocol_category_post', 'category_id', 'post_id');
    }

    public function categories_seal()
    {
        return $this->belongsToMany('SealCategoryModel', 'protocol_category_seal_post', 'category_id', 'post_id');
    }

    public function categories_user()
    {
        return $this->belongsToMany('UserModel', 'protocol_category_user_post', 'category_id', 'post_id');
    }

    public function categories_user_frame()
    {
        return $this->belongsToMany('UserModel', 'protocol_category_user_post', 'frame', 'post_id');
    }

    /**
     * 关联标签表
     */
    public function tags()
    {
        return $this->belongsToMany('protocolTagModel', 'protocol_tag_post', 'tag_id', 'post_id');
    }

    /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function getPostContentAttr($value)
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($value));
    }

    /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function setPostContentAttr($value)
    {
        return htmlspecialchars(cmf_replace_content_file_url(htmlspecialchars_decode($value), true));
    }

    /**
     * published_time 自动完成
     * @param $value
     * @return false|int
     */
    public function setPublishedTimeAttr($value)
    {
        return strtotime($value);
    }

    /**
     * 后台管理添加文章
     * @param array $data 文章数据
     * @param array|string $categories 文章分类 id
     * @return $this
     */
    public function adminAddArticle($data, $categories, $categories_seal, $categories_user, $categories_user_one)
    {
        $data['user_id'] = cmf_get_current_admin_id();
        // $data['published_time'] = time();
        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            $data['thumbnail']         = $data['more']['thumbnail'];
        }

        if (!empty($data['more']['audio'])) {
            $data['more']['audio'] = cmf_asset_relative_url($data['more']['audio']);
        }

        if (!empty($data['more']['video'])) {
            $data['more']['video'] = cmf_asset_relative_url($data['more']['video']);
        }

        $this->allowField(true)->data($data, true)->isUpdate(false)->save();

        // dump($save_id);

        if (is_string($categories)) {
            $categories = explode(',', $categories);
        }

        $this->categories()->save($categories);

        // 行政公章
        if (is_string($categories_seal)) {
            $categories_seal = explode(',', $categories_seal);
        }
        $this->categories_seal()->save($categories_seal);

        // 承诺人或保证人
        $frame_ids = $categories_user;
        if (is_string($categories_user)) {
            // $categories_user = explode(',', $categories_user);
            $categories_user = Db::name('frame_category_post')->where('category_id in ('.$categories_user.')')->group('post_id')->field('post_id, category_id')->select()->toArray();
            foreach ($categories_user as $key => $value) {
                $categories_user_arr[] = $value['post_id'];
            }
            $categories_user = $categories_user_arr;
            unset($key);
            unset($value);
        }
        if (is_string($categories_user)) {
            $categories_user = explode(',', $categories_user);
        }
        
        $this->categories_user()->save($categories_user);


        // 负责人
        if (is_string($categories_user_one) && $categories_user_one) {
            $categories_user_one = explode(',', $categories_user_one);
            $this->categories_user()->attach($categories_user_one, ['place' => 1]);
        }

        

        // $data['post_keywords'] = str_replace('，', ',', $data['post_keywords']);

        // $keywords = explode(',', $data['post_keywords']);

        // $this->addTags($keywords, $this->id);

        return $this;

    }

    /**
     * 后台管理编辑文章
     * @param array $data 文章数据
     * @param array|string $categories 文章分类 id
     * @return $this
     */
    public function adminEditArticle($data, $categories, $categories_seal, $categories_user, $categories_user_one)
    {

        unset($data['user_id']);

        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
            $data['thumbnail']         = $data['more']['thumbnail'];
        }

        if (!empty($data['more']['audio'])) {
            $data['more']['audio'] = cmf_asset_relative_url($data['more']['audio']);
        }

        if (!empty($data['more']['video'])) {
            $data['more']['video'] = cmf_asset_relative_url($data['more']['video']);
        }

        $this->allowField(true)->isUpdate(true)->data($data, true)->save();

        if (is_string($categories)) {
            $categories = explode(',', $categories);
        }

        $oldCategoryIds        = $this->categories()->column('category_id');
        $sameCategoryIds       = array_intersect($categories, $oldCategoryIds);
        $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);
        $newCategoryIds        = array_diff($categories, $sameCategoryIds);

        if (!empty($needDeleteCategoryIds)) {
            $this->categories()->detach($needDeleteCategoryIds);
        }

        if (!empty($newCategoryIds)) {
            $this->categories()->attach(array_values($newCategoryIds));
        }


        // 行政公章
        // dump($categories_seal);
        if (is_string($categories_seal)) {
            $categories_seal = explode(',', $categories_seal);
            // $categories_seal_place = explode(',', $categories_seal_place);
        }

        $oldCategoryIds_seal        = $this->categories_seal()->column('category_id');
        $sameCategoryIds_seal       = array_intersect($categories_seal, $oldCategoryIds_seal);
        $needDeleteCategoryIds_seal = array_diff($oldCategoryIds_seal, $sameCategoryIds_seal);
        $newCategoryIds_seal        = array_diff($categories_seal, $sameCategoryIds_seal);
        
        if (!empty($needDeleteCategoryIds_seal)) {
            $this->categories_seal()->detach($needDeleteCategoryIds_seal);
        }

        if (!empty($newCategoryIds_seal)) {
        //     foreach ($categories_seal as $nk_seal => $nv_seal) {
        //         $this->categories_seal()->attach($nv_seal, ['place'=> $categories_seal_place[$nk_seal]]);
        //     }
            $this->categories_seal()->attach(array_values($newCategoryIds_seal));
        }


        // 承诺人或保证人
        
        
        // $frame_ids = $categories_user;
        if (is_string($categories_user)) {
            $categories_user = explode(',', $categories_user);
            // $categories_user = Db::name('frame_category_post')->where('category_id in ('.$categories_user.')')->group('post_id')->field('post_id, category_id')->select()->toArray();
            // foreach ($categories_user as $key => $value) {
            //     $categories_user_arr[] = $value['post_id'];
                
            // }
            // $categories_user = $categories_user_arr;
            // unset($key);
            // unset($value);
        }
        // dump($categories_user);
        

        $oldCategoryIds_user        = $this->categories_user()->where('pivot.place = 0')->column('category_id');
        // dump($oldCategoryIds_user);
        $sameCategoryIds_user       = array_intersect($categories_user, $oldCategoryIds_user);
        $needDeleteCategoryIds_user = array_diff($oldCategoryIds_user, $sameCategoryIds_user);
        $newCategoryIds_user        = array_diff($categories_user, $sameCategoryIds_user);

        // dump($newCategoryIds_user);
        if (!empty($needDeleteCategoryIds_user)) {
            $this->categories_user()->detach($needDeleteCategoryIds_user);
        }

        if (!empty($newCategoryIds_user)) {
            // foreach ($newCategoryIds_user as $key => $value) {
                // $frame_id = Db::name('frame_category_post')->where('post_id = '.$value)->find();
                // dump(Db::name('frame_category_post')->getLastSql());
                // dump($frame_id);
                // $this->categories_user()->attach($value, ['frame'=>$frame_ids]); 
            // }
            $this->categories_user()->attach(array_values($newCategoryIds_user));
        }
        // Db::name('protocol_category_user_post')->where('place = 0 and post_id = '.$data['id'])
        // ->update(['frame'=>$frame_ids]);

        // 负责人
        
        if (is_string($categories_user_one) && $categories_user_one) {
            $categories_user_one = explode(',', $categories_user_one);
            // dump($categories_user_one);
            $oldCategoryIds_user_one        = $this->categories_user()->where('pivot.place = 1')->column('category_id');
            $sameCategoryIds_user_one       = array_intersect($categories_user_one, $oldCategoryIds_user_one);
            $needDeleteCategoryIds_user_one = array_diff($oldCategoryIds_user_one, $sameCategoryIds_user_one);
            $newCategoryIds_user_one        = array_diff($categories_user_one, $sameCategoryIds_user_one);
            if (!empty($needDeleteCategoryIds_user_one)) {
                $this->categories_user()->detach($needDeleteCategoryIds_user_one);
            }

            if (!empty($newCategoryIds_user_one)) {
                $this->categories_user()->attach(array_values($newCategoryIds_user_one), ['place'=>1]);
            }
        }
        // dump($data);
        if(empty($categories_user_one)){
            Db::name('protocol_category_user_post')->where('place = 1 and post_id = '.$data['id'])->delete();
        }

        



        return $this;

    }

    public function addTags($keywords, $articleId)
    {
        $protocolTagModel = new protocolTagModel();

        $tagIds = [];

        $data = [];

        if (!empty($keywords)) {

            $oldTagIds = Db::name('protocol_tag_post')->where('post_id', $articleId)->column('tag_id');

            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                if (!empty($keyword)) {
                    $findTag = $protocolTagModel->where('name', $keyword)->find();
                    if (empty($findTag)) {
                        $tagId = $protocolTagModel->insertGetId([
                            'name' => $keyword
                        ]);
                    } else {
                        $tagId = $findTag['id'];
                    }

                    if (!in_array($tagId, $oldTagIds)) {
                        array_push($data, ['tag_id' => $tagId, 'post_id' => $articleId]);
                    }

                    array_push($tagIds, $tagId);

                }
            }


            if (empty($tagIds) && !empty($oldTagIds)) {
                Db::name('protocol_tag_post')->where('post_id', $articleId)->delete();
            }

            $sameTagIds = array_intersect($oldTagIds, $tagIds);

            $shouldDeleteTagIds = array_diff($oldTagIds, $sameTagIds);

            if (!empty($shouldDeleteTagIds)) {
                Db::name('protocol_tag_post')->where(['post_id' => $articleId, 'tag_id' => ['in', $shouldDeleteTagIds]])->delete();
            }

            if (!empty($data)) {
                Db::name('protocol_tag_post')->insertAll($data);
            }


        } else {
            Db::name('protocol_tag_post')->where('post_id', $articleId)->delete();
        }
    }

    public function adminDeletePage($data)
    {

        if (isset($data['id'])) {
            $id = $data['id']; //获取删除id

            $res = $this->where(['id' => $id])->find();

            if ($res) {
                $res = json_decode(json_encode($res), true); //转换为数组

                $recycleData = [
                    'object_id'   => $res['id'],
                    'create_time' => time(),
                    'table_name'  => 'protocol_post#page',
                    'name'        => $res['post_title'],

                ];

                Db::startTrans(); //开启事务
                $transStatus = false;
                try {
                    Db::name('protocol_post')->where(['id' => $id])->update([
                        'delete_time' => time()
                    ]);
                    Db::name('recycle_bin')->insert($recycleData);

                    $transStatus = true;
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {

                    // 回滚事务
                    Db::rollback();
                }
                return $transStatus;


            } else {
                return false;
            }
        } elseif (isset($data['ids'])) {
            $ids = $data['ids'];

            $res = $this->where(['id' => ['in', $ids]])
                ->select();

            if ($res) {
                $res = json_decode(json_encode($res), true);
                foreach ($res as $key => $value) {
                    $recycleData[$key]['object_id']   = $value['id'];
                    $recycleData[$key]['create_time'] = time();
                    $recycleData[$key]['table_name']  = 'protocol_post';
                    $recycleData[$key]['name']        = $value['post_title'];

                }

                Db::startTrans(); //开启事务
                $transStatus = false;
                try {
                    Db::name('protocol_post')->where(['id' => ['in', $ids]])
                        ->update([
                            'delete_time' => time()
                        ]);


                    Db::name('recycle_bin')->insertAll($recycleData);

                    $transStatus = true;
                    // 提交事务
                    Db::commit();

                } catch (\Exception $e) {

                    // 回滚事务
                    Db::rollback();


                }
                return $transStatus;


            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * 后台管理添加页面
     * @param array $data 页面数据
     * @return $this
     */
    public function adminAddPage($data)
    {
        $data['user_id'] = cmf_get_current_admin_id();

        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $data['post_status'] = empty($data['post_status']) ? 0 : 1;
        $data['post_type']   = 2;
        $this->allowField(true)->data($data, true)->save();

        return $this;

    }

    /**
     * 后台管理编辑页面
     * @param array $data 页面数据
     * @return $this
     */
    public function adminEditPage($data)
    {
        $data['user_id'] = cmf_get_current_admin_id();

        if (!empty($data['more']['thumbnail'])) {
            $data['more']['thumbnail'] = cmf_asset_relative_url($data['more']['thumbnail']);
        }

        $data['post_status'] = empty($data['post_status']) ? 0 : 1;
        $data['post_type']   = 2;
        $this->allowField(true)->isUpdate(true)->data($data, true)->save();

        $routeModel = new RouteModel();
        $routeModel->setRoute($data['post_alias'], 'protocol/Page/index', ['id' => $data['id']], 2, 5000);

        $routeModel->getRoutes(true);
        return $this;
    }

}
