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
namespace app\user\model;

use think\Db;
use think\Model;

class UserModel extends Model
{
    protected $type = [
        'more' => 'array',
    ];

    /**
     * 关联部门分类表
     */
    public function frame()
    {
        return $this->belongsToMany('FrameCategoryModel', 'frame_category_post', 'category_id', 'post_id');
    }

    /**
     * 关联部门负责人表
     */
    public function frame_resp()
    {
        return $this->belongsToMany('FrameCategoryModel', 'frame_category_resp_post', 'category_id', 'post_id');
    }

    /**
     * 关联部门涉密人员表
     */
    public function frame_secr()
    {
        return $this->belongsToMany('FrameCategoryModel', 'frame_category_secr_post', 'category_id', 'post_id');
    }

    /**
     * 关联模糊岗位分类表
     */
    public function vague()
    {
        return $this->belongsToMany('VagueCategoryModel', 'vague_category_post', 'category_id', 'post_id');
    }

    /**
     * 关联身份分类表
     */
    public function identity()
    {
        return $this->belongsToMany('IdentityCategoryModel', 'identity_category_post', 'category_id', 'post_id');
    }

    /**
     * 关联角色分类表
     */
    public function role()
    {
        return $this->belongsToMany('RoleCategoryModel', 'role_category_post', 'category_id', 'post_id');
    }

    /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function getUserContentAttr($value)
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($value));
    }

    /**
     * post_content 自动转化
     * @param $value
     * @return string
     */
    public function setUserContentAttr($value)
    {
        return htmlspecialchars(cmf_replace_content_file_url(htmlspecialchars_decode($value), true));
    }

    public function doMobile($user)
    {
        $result = $this->where('mobile', $user['mobile'])->find();


        if (!empty($result)) {
            $comparePasswordResult = cmf_compare_password($user['user_pass'], $result['user_pass']);
            $hookParam             = [
                'user'                    => $user,
                'compare_password_result' => $comparePasswordResult
            ];
            hook_one("user_login_start", $hookParam);
            if ($comparePasswordResult) {
                //拉黑判断。
                if ($result['user_status'] == 0) {
                    return 3;
                }
                session('user', $result->toArray());
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip'   => get_client_ip(0, true),
                ];
                $this->where('id', $result["id"])->update($data);
                $token = cmf_generate_user_token($result["id"], 'web');
                if (!empty($token)) {
                    session('token', $token);
                }
                return 0;
            }
            return 1;
        }
        $hookParam = [
            'user'                    => $user,
            'compare_password_result' => false
        ];
        hook_one("user_login_start", $hookParam);
        return 2;
    }

    public function doName($user)
    {
        $result = $this->where('user_login', $user['user_login'])->find();
        if (!empty($result)) {
            $comparePasswordResult = cmf_compare_password($user['user_pass'], $result['user_pass']);
            $hookParam             = [
                'user'                    => $user,
                'compare_password_result' => $comparePasswordResult
            ];
            hook_one("user_login_start", $hookParam);
            if ($comparePasswordResult) {
                //拉黑判断。
                if ($result['user_status'] == 0) {
                    return 3;
                }
                session('user', $result->toArray());
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip'   => get_client_ip(0, true),
                ];
                $result->where('id', $result["id"])->update($data);
                $token = cmf_generate_user_token($result["id"], 'web');
                if (!empty($token)) {
                    session('token', $token);
                }
                return 0;
            }
            return 1;
        }
        $hookParam = [
            'user'                    => $user,
            'compare_password_result' => false
        ];
        hook_one("user_login_start", $hookParam);
        return 2;
    }

    public function doEmail($user)
    {

        $result = $this->where('user_email', $user['user_email'])->find();

        if (!empty($result)) {
            $comparePasswordResult = cmf_compare_password($user['user_pass'], $result['user_pass']);
            $hookParam             = [
                'user'                    => $user,
                'compare_password_result' => $comparePasswordResult
            ];
            hook_one("user_login_start", $hookParam);
            if ($comparePasswordResult) {

                //拉黑判断。
                if ($result['user_status'] == 0) {
                    return 3;
                }
                session('user', $result->toArray());
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip'   => get_client_ip(0, true),
                ];
                $this->where('id', $result["id"])->update($data);
                $token = cmf_generate_user_token($result["id"], 'web');
                if (!empty($token)) {
                    session('token', $token);
                }
                return 0;
            }
            return 1;
        }
        $hookParam = [
            'user'                    => $user,
            'compare_password_result' => false
        ];
        hook_one("user_login_start", $hookParam);
        return 2;
    }

    public function register($user, $type)
    {
        switch ($type) {
            case 1:
                $result = Db::name("user")->where('user_login', $user['user_login'])->find();
                break;
            case 2:
                $result = Db::name("user")->where('mobile', $user['mobile'])->find();
                break;
            case 3:
                $result = Db::name("user")->where('user_email', $user['user_email'])->find();
                break;
            default:
                $result = 0;
        }

        $is_sn = Db::name("user")->where('user_sn', $user['user_sn'])->find();
        if($is_sn){
            return 2;
        }

        $userStatus = 1;

        // if (cmf_is_open_registration()) {
        //     $userStatus = 2;
        // }

        if (empty($result)) {
            $data   = [
                'user_login'      => empty($user['user_login']) ? '' : $user['user_login'],
                'user_email'      => empty($user['user_email']) ? '' : $user['user_email'],
                'mobile'          => empty($user['mobile']) ? '' : $user['mobile'],
                'user_nickname'   => '',
                'user_pass'       => cmf_password($user['user_pass']),
                'last_login_ip'   => get_client_ip(0, true),
                'create_time'     => time(),
                'last_login_time' => time(),
                'user_status'     => $userStatus,
                "user_type"       => 2,//会员
                'user_sn'         => empty($user['user_sn']) ? 0 : $user['user_sn'],
            ];

            if (!empty($user['avatar'])) {
                $data['avatar'] = cmf_asset_relative_url($user['avatar']);
            }
            // $userId = Db::name("user")->insertGetId($data);

            // 部门/单位数据
            if (is_string($user['categories'])) {
                $user['categories'] = explode(',', $user['categories']);
                // 是否属于保密委
                if(in_array('999', $user['categories'])){
                    $data['user_type'] = 3;
                }
            }

            $this->allowField(true)->data($data, true)->isUpdate(false)->save();

            $this->frame()->save($user['categories'], ['type' => $user['frame_type'], 'is_sec' => $user['is_sec']]);


            // 员工身份
            if (is_string($user['categories_identity'])) {
                $user['categories_identity'] = explode(',', $user['categories_identity']);
            }
            $this->identity()->save($user['categories_identity']);

            
            return 0;
        }
        return 1;
    }

    /**
     * 通过邮箱重置密码
     * @param $email
     * @param $password
     * @return int
     */
    public function emailPasswordReset($email, $password)
    {
        $result = $this->where('user_email', $email)->find();
        if (!empty($result)) {
            $data = [
                'user_pass' => cmf_password($password),
            ];
            $this->where('user_email', $email)->update($data);
            return 0;
        }
        return 1;
    }

    /**
     * 通过手机重置密码
     * @param $mobile
     * @param $password
     * @return int
     */
    public function mobilePasswordReset($mobile, $password)
    {
        $userQuery = Db::name("user");
        $result    = $userQuery->where('mobile', $mobile)->find();
        if (!empty($result)) {
            $data = [
                'user_pass' => cmf_password($password),
            ];
            $userQuery->where('mobile', $mobile)->update($data);
            return 0;
        }
        return 1;
    }

    public function editData($user)
    {
        $userId = cmf_get_current_user_id();

        if (isset($user['birthday'])) {
            $user['birthday'] = strtotime($user['birthday']);
        }

        $field = 'user_nickname,sex,birthday,user_url,signature,more';

        if ($this->allowField($field)->save($user, ['id' => $userId])) {
            $userInfo = $this->where('id', $userId)->find();
            cmf_update_current_user($userInfo->toArray());
            return 1;
        }
        return 0;
    }

    /**
     * 用户密码修改
     * @param $user
     * @return int
     */
    public function editPassword($user)
    {
        $userId    = cmf_get_current_user_id();
        $userQuery = Db::name("user");
        if ($user['password'] != $user['repassword']) {
            return 1;
        }
        $pass = $userQuery->where('id', $userId)->find();
        if (!cmf_compare_password($user['old_password'], $pass['user_pass'])) {
            return 2;
        }
        $data['user_pass'] = cmf_password($user['password']);
        $userQuery->where('id', $userId)->update($data);
        return 0;
    }

    public function comments()
    {
        $userId               = cmf_get_current_user_id();
        $userQuery            = Db::name("Comment");
        $where['user_id']     = $userId;
        $where['delete_time'] = 0;
        $favorites            = $userQuery->where($where)->order('id desc')->paginate(10);
        $data['page']         = $favorites->render();
        $data['lists']        = $favorites->items();
        return $data;
    }

    public function deleteComment($id)
    {
        $userId              = cmf_get_current_user_id();
        $userQuery           = Db::name("Comment");
        $where['id']         = $id;
        $where['user_id']    = $userId;
        $data['delete_time'] = time();
        $userQuery->where($where)->update($data);
        return $data;
    }

    /**
     * 绑定用户手机号
     */
    public function bindingMobile($user)
    {
        $userId          = cmf_get_current_user_id();
        $data ['mobile'] = $user['username'];
        Db::name("user")->where('id', $userId)->update($data);
        $userInfo = Db::name("user")->where('id', $userId)->find();
        cmf_update_current_user($userInfo);
        return 0;
    }

    /**
     * 绑定用户邮箱
     */
    public function bindingEmail($user)
    {
        $userId              = cmf_get_current_user_id();
        $data ['user_email'] = $user['username'];
        Db::name("user")->where('id', $userId)->update($data);
        $userInfo = Db::name("user")->where('id', $userId)->find();
        cmf_update_current_user($userInfo);
        return 0;
    }

    /**
     * 
     */
    public function adminEditUser($user, $frame = null, $identity = null){
        $nowuser = Db::name("user")->where('id', $user['id'])->find();
        
        $result = Db::name("user")->where('mobile', $user['mobile'])->find();
        // 修改的手机号码已存在
        if($result && $result['mobile'] != $nowuser['mobile']){
            return 1;
        }

        $result = Db::name("user")->where('user_sn', $user['user_sn'])->find();
        // 修改的员工姓名已存在
        if($result && $result['user_sn'] != $nowuser['user_sn']){
            return 2;
        }

        // $data   = [
        //     'user_login'      => $user['user_login'],
        //     'user_email'      => $user['user_email'],
        //     'mobile'          => $user['mobile'],
        //     'user_nickname'   => '',
        //     'user_pass'       => cmf_password($user['user_pass']),
        //     'last_login_ip'   => get_client_ip(0, true),
        //     'create_time'     => time(),
        //     'last_login_time' => time(),
        //     'user_status'     => $userStatus,
        //     "user_type"       => 2,//会员
        // ];
        if (!empty($user['avatar'])) {
            $user['avatar'] = cmf_asset_relative_url($user['avatar']);
        }

        if (is_string($frame)) {
            $frame = explode(',', $frame);
            // 是否属于保密委
            if(in_array('999', $frame)){
                $user['user_type'] = 3;
            }else{
                $user['user_type'] = 2;
            }
        }

        $this->allowField(true)->isUpdate(true)->save($user);
        // dump($this->getLastSql());
        
        //部门分类
        $oldCategoryIds        = $this->frame()->column('category_id');
        $sameCategoryIds       = array_intersect($frame, $oldCategoryIds);
        $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);
        $newCategoryIds        = array_diff($frame, $sameCategoryIds);
        if (!empty($needDeleteCategoryIds)) {
            $this->frame()->detach($needDeleteCategoryIds);
        }
        if (!empty($newCategoryIds)) {
            $this->frame()->attach(array_values($newCategoryIds));
        }
        // 更新 是否涉密人员, 部门职位
        Db::name('frame_category_post')->where(['post_id'=>$user['id']])
        ->update(['is_sec'=>$user['is_sec'], 'type' => $user['frame_type']]);


        // 身份分类
        if (is_string($identity)) {
            $identity = explode(',', $identity);
        }
        $oldCategoryIds        = $this->identity()->column('category_id');
        $sameCategoryIds       = array_intersect($identity, $oldCategoryIds);
        $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);
        $newCategoryIds        = array_diff($identity, $sameCategoryIds);

        if (!empty($needDeleteCategoryIds)) {
            $this->identity()->detach($needDeleteCategoryIds);
        }

        if (!empty($newCategoryIds)) {
            $this->identity()->attach(array_values($newCategoryIds));
        }

    }
}
