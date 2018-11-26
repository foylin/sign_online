<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"themes/admin_simpleboot3/user/admin_index/edit.html";i:1540907286;s:77:"/var/www/sign_online/admin/public/themes/admin_simpleboot3/public/header.html";i:1540662485;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
<style type="text/css">
    .pic-list li {
        margin-bottom: 5px;
    }
</style>
<script type="text/html" id="photos-item-tpl">
    <li id="saved-image{id}">
        <input id="photo-{id}" type="hidden" name="photo_urls[]" value="{filepath}">
        <input class="form-control" id="photo-{id}-name" type="text" name="photo_names[]" value="{name}"
               style="width: 200px;" title="图片名称">
        <img id="photo-{id}-preview" src="{url}" style="height:36px;width: 36px;"
             onclick="imagePreviewDialog(this.src);">
        <a href="javascript:uploadOneImage('图片上传','#photo-{id}');">替换</a>
        <a href="javascript:(function(){$('#saved-image{id}').remove();})();">移除</a>
    </li>
</script>
<script type="text/html" id="files-item-tpl">
    <li id="saved-file{id}">
        <input id="file-{id}" type="hidden" name="file_urls[]" value="{filepath}">
        <input class="form-control" id="file-{id}-name" type="text" name="file_names[]" value="{name}"
               style="width: 200px;" title="文件名称">
        <a id="file-{id}-preview" href="{preview_url}" target="_blank">下载</a>
        <a href="javascript:uploadOne('文件上传','#file-{id}','file');">替换</a>
        <a href="javascript:(function(){$('#saved-file{id}').remove();})();">移除</a>
    </li>
</script>
</head>

<body>
    <div class="wrap js-check-wrap">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo url('admin_index/index'); ?>">员工列表</a></li>
            <li class=""><a href="<?php echo url('admin_index/add'); ?>">添加员工</a></li>
            <li class="active"><a href="<?php echo url('admin_index/add'); ?>">编辑员工</a></li>
        </ul>
        <form action="<?php echo url('admin_index/editPost'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
            <div class="row">
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th>姓名<span class="form-required">*</span></th>
                            <td>
                                <input class="form-control" type="text" name="post[user_login]" id="title" required
                                    value="<?php echo $post['user_login']; ?>" placeholder="请输入姓名" />
                            </td>
                        </tr>

                        <tr>
                            <th>手机号码<span class="form-required">*</span></th>
                            <td>
                                <input class="form-control" type="text" name="post[mobile]" id="title" required value="<?php echo $post['mobile']; ?>"
                                    placeholder="请输入手机号码" />
                            </td>
                        </tr>

                        <tr>
                            <th>密码</th>
                            <td>
                                <input class="form-control" type="text" name="post[user_pass]" id="title" 
                                    value="" placeholder="请输入密码（留空则不修改密码）" />
                            </td>
                        </tr>

                        <tr>
                            <th width="100">部门/单位</th>
                            <td>
                                <input class="form-control" type="text" style="width:400px;" value="<?php echo implode(' ',$post_categories); ?>"
                                    placeholder="请选择部门/单位" onclick="doSelectCategory();" id="js-categories-name-input"
                                    readonly />
                                <input class="form-control" type="hidden" value="<?php echo $post_category_ids; ?>" name="post[categories]" id="js-categories-id-input" />
                            </td>
                        </tr>

                        <tr>
                            <th width="100">模糊岗位</th>
                            <td>
                                <input class="form-control" type="text" style="width:400px;"  value="<?php echo implode(' ',$post_categories_vague); ?>"
                                    placeholder="模糊岗位" onclick="doSelectCategory_vague();" id="js-categories-name-input-vague"
                                    readonly />
                                <input class="form-control" type="hidden" value="<?php echo $post_category_ids_vague; ?>" name="post[categories_vague]" id="js-categories-id-input-vague" />
                            </td>
                        </tr>

                        <tr>
                            <th width="100">员工身份</th>
                            <td>
                                <input class="form-control" type="text" style="width:400px;"  value="<?php echo implode(' ',$post_categories_identity); ?>"
                                    placeholder="员工身份" onclick="doSelectCategory_identity();" id="js-categories-name-input-identity"
                                    readonly />
                                <input class="form-control" type="hidden" value="<?php echo $post_category_ids_identity; ?>" name="post[categories_identity]" id="js-categories-id-input-identity" />
                            </td>
                        </tr>

                        <tr>
                            <th width="100">员工角色</th>
                            <td>
                                <input class="form-control" type="text" style="width:400px;"  value="<?php echo implode(' ',$post_categories_role); ?>"
                                    placeholder="员工角色" onclick="doSelectCategory_role();" id="js-categories-name-input-role"
                                    readonly />
                                <input class="form-control" type="hidden" value="<?php echo $post_category_ids_role; ?>" name="post[categories_role]" id="js-categories-id-input-role" />
                            </td>
                        </tr>
                        <tr>
                            <th>岗位调动详情</th>
                            <td>
                                <script type="text/plain" id="content" name="post[user_content]"><?php echo $post['user_content']; ?></script>
                            </td>
                        </tr>

                    </table>
                    <?php 
    \think\Hook::listen('portal_admin_article_edit_view_main',$temp5bfc2c2577286,null,false);
 ?>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
                            <a class="btn btn-default" href="<?php echo url('AdminIndex/index'); ?>"><?php echo lang('BACK'); ?></a>
                            <input type="hidden" name="post[id]" value="<?php echo $post['id']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <table class="table table-bordered">
                        <tr>
                            <th><b>员工头像</b></th>
                        </tr>
                        <tr>
                            <td>
                                <div style="text-align: center;">
                                    <input type="hidden" name="post[avatar]" id="thumbnail" value="<?php echo $post['avatar']; ?>">
                                    <a href="javascript:uploadOneImage('图片上传','#thumbnail');">
                                    
                                    
                                        <?php if(empty($post['avatar'])): ?>
                                            <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png" id="thumbnail-preview" width="135" style="cursor: pointer" />
                                            <?php else: ?>
                                            <img src="<?php echo cmf_get_image_preview_url($post['avatar']); ?>" id="thumbnail-preview" width="135" style="cursor: pointer" />
                                        <?php endif; ?>
                                    </a>
                                    <input type="button" class="btn btn-sm btn-cancel-thumbnail" value="取消图片">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><b>注册时间</b></th>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control js-bootstrap-datetime" type="text" name="post[published_time]"
                                    value="<?php echo date('Y-m-d H:i:s',$post['create_time']); ?>">
                            </td>
                        </tr>

                        <tr>
                            <th>状态</th>
    
                        </tr>
                        <tr>
                            <td>
                                <div class="">
                                    <select class="form-control valid" name="post[user_status]" id="user-status-sel" aria-invalid="false">
                                        <option value="0" selected="">禁用</option>
                                        <option value="1" selected="">正常</option>
                                        <option value="2" selected="">未验证</option>
                                    </select>
                                </div>
                            </td>
                        </tr>


                    </table>

                    <?php 
    \think\Hook::listen('portal_admin_article_edit_view_right_sidebar',$temp5bfc2c2577295,null,false);
 ?>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="/static/js/admin.js"></script>
    <script type="text/javascript">
        //编辑器路径定义
        var editorURL = GV.WEB_ROOT;
    </script>
    <script type="text/javascript" src="/static/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/static/js/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript">
        $(function () {
            

            editorcontent = new baidu.editor.ui.Editor();
            editorcontent.render('content');
            try {
                editorcontent.sync();
            } catch (err) {

            }

            $('.btn-cancel-thumbnail').click(function () {
                $('#thumbnail-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
                $('#thumbnail').val('');
            });
            
            $('#user-status-sel').val("<?php echo $post['user_status']; ?>");
        });

        function doSelectCategory() {
            var selectedCategoriesId = $('#js-categories-id-input').val();
            openIframeLayer("<?php echo url('AdminIndex/select'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
                area: ['700px', '400px'],
                btn: ['确定', '取消'],
                yes: function (index, layero) {
                    //do something

                    var iframeWin = window[layero.find('iframe')[0]['name']];
                    var selectedCategories = iframeWin.confirm();
                    if (selectedCategories.selectedCategoriesId.length == 0) {
                        layer.msg('请选择分类');
                        return;
                    }
                    $('#js-categories-id-input').val(selectedCategories.selectedCategoriesId.join(','));
                    $('#js-categories-name-input').val(selectedCategories.selectedCategoriesName.join(' '));
                    //console.log(layer.getFrameIndex(index));
                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                }
            });
        }

        // 模糊岗位选择
        function doSelectCategory_vague() {
            var selectedCategoriesId = $('#js-categories-id-input-vague').val();
            openIframeLayer("<?php echo url('AdminIndex/select_vague'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
                area: ['700px', '400px'],
                btn: ['确定', '取消'],
                yes: function (index, layero) {
                    //do something

                    var iframeWin = window[layero.find('iframe')[0]['name']];
                    var selectedCategories = iframeWin.confirm();
                    if (selectedCategories.selectedCategoriesId.length == 0) {
                        layer.msg('请选择分类');
                        return;
                    }
                    $('#js-categories-id-input-vague').val(selectedCategories.selectedCategoriesId.join(','));
                    $('#js-categories-name-input-vague').val(selectedCategories.selectedCategoriesName.join(' '));
                    //console.log(layer.getFrameIndex(index));
                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                }
            });
        }

        // 员工身份选择
        function doSelectCategory_identity() {
            var selectedCategoriesId = $('#js-categories-id-input-identity').val();
            openIframeLayer("<?php echo url('AdminIndex/select_identity'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
                area: ['700px', '400px'],
                btn: ['确定', '取消'],
                yes: function (index, layero) {
                    //do something

                    var iframeWin = window[layero.find('iframe')[0]['name']];
                    var selectedCategories = iframeWin.confirm();
                    if (selectedCategories.selectedCategoriesId.length == 0) {
                        layer.msg('请选择分类');
                        return;
                    }
                    $('#js-categories-id-input-identity').val(selectedCategories.selectedCategoriesId.join(','));
                    $('#js-categories-name-input-identity').val(selectedCategories.selectedCategoriesName.join(' '));
                    //console.log(layer.getFrameIndex(index));
                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                }
            });
        }

        // 员工角色选择
        function doSelectCategory_role() {
            var selectedCategoriesId = $('#js-categories-id-input-role').val();
            openIframeLayer("<?php echo url('AdminIndex/select_role'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
                area: ['700px', '400px'],
                btn: ['确定', '取消'],
                yes: function (index, layero) {
                    //do something

                    var iframeWin = window[layero.find('iframe')[0]['name']];
                    var selectedCategories = iframeWin.confirm();
                    if (selectedCategories.selectedCategoriesId.length == 0) {
                        layer.msg('请选择分类');
                        return;
                    }
                    $('#js-categories-id-input-role').val(selectedCategories.selectedCategoriesId.join(','));
                    $('#js-categories-name-input-role').val(selectedCategories.selectedCategoriesName.join(' '));
                    //console.log(layer.getFrameIndex(index));
                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                }
            });
        }
    </script>
</body>

</html>