<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"themes/admin_simpleboot3/protocol/admin_index/verify.html";i:1542550412;s:77:"/var/www/sign_online/admin/public/themes/admin_simpleboot3/public/header.html";i:1540662485;}*/ ?>
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
    .sign-user .name{
        line-height: 34px;
        text-align: left;
    }

    .export{
        line-height: 34px;
    }

    .sign-user .name-icon{
        margin-left: 4px;
        /* background: #18BC9C; */
        color: #18BC9C;
    }

    .sign-user .name-icon-error{
        margin-left: 4px;
        /* background: #18BC9C; */
        color: red;
    }

    .sign-user .sign-pic{
        line-height: 34px;
        text-align: center;
        background: #18BC9C;
        color: white;
        cursor: pointer;
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
        <li><a href="<?php echo url('AdminIndex/index'); ?>">协议管理</a></li>
        <li>
            <a href="<?php echo url('AdminIndex/add'); ?>">添加协议</a>
        </li>
        <!-- <li class="active"><a href="#">编辑协议</a></li> -->

        <li class="active"><a href="#">签约用户审核</a></li>
    </ul>
    <form action="<?php echo url('AdminIndex/verifyPost'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    
                    <tr>
                        <th width="100">标题<span class="form-required">*</span></th>
                        <td>
                            <input id="post-id" type="hidden" name="post[post_id]" value="<?php echo $post['id']; ?>">
                            <input class="form-control" type="text" name="post[post_title]"
                                   required value="<?php echo $post['post_title']; ?>" placeholder="请输入标题"/>
                        </td>
                    </tr>

                    <tr>
                        <th width="100" rowspan="<?php echo $sign_user_count; ?>">签约用户</th>
                        
                    </tr>

                    

                    <?php if(is_array($post_categories_user) || $post_categories_user instanceof \think\Collection || $post_categories_user instanceof \think\Paginator): if( count($post_categories_user)==0 ) : echo "" ;else: foreach($post_categories_user as $key=>$vo): ?>
                    <tr class="sign-user">
                        <td>
                            <div class="col-md-2 name">
                                    <?php echo $vo['user_login']; if($vo['sign_status'] == 2): ?><i class="fa fa-check name-icon"></i><?php endif; if($vo['sign_status'] == -1): ?><i class="fa fa-close name-icon-error"></i><?php endif; ?>
                                </div>
                            <?php if($vo['sign_url']): ?>
                            <!-- <div class="col-md-2 sign-pic" onclick="parent.imagePreviewDialog('<?php echo cmf_get_image_preview_url($vo['sign_url']); ?>');">查看签约图片</div> -->
                            <div class="col-md-2 sign-pic"><?php echo date('Y-m-d H:i', $vo['update_time']) ?></div>
                            <?php else: ?>
                            <div class="col-md-2 sign-pic">未签约</div>
                            <?php endif; ?>
                            
                            <div class="col-md-2">
                                    <select class="form-control valid" name="post[sign_status][]" id="categories-model-sel" aria-invalid="false">
                                    <option value="0" <?php if($vo['sign_status'] == 0): ?>selected=""<?php endif; ?> >待签约</option>
                                    <option value="1" <?php if($vo['sign_status'] == 1): ?>selected=""<?php endif; ?> >待审核</option>
                                    <option value="2" <?php if($vo['sign_status'] == 2): ?>selected=""<?php endif; ?> >签约成功</option>
                                    <option value="-1" <?php if($vo['sign_status'] == -1): ?>selected=""<?php endif; ?> >审核失败</option>
                                    </select>

                                    
                                </div>

                                

                                <div class="col-md-4">
                                        <input class="form-control" type="text" name="post[notes][]"
                                         value="<?php echo $vo['notes']; ?>" placeholder="请输入备注"/>

                                        <input type="hidden" name="post[id][]" value="<?php echo $vo['protocol_id']; ?>">
                                </div>

                                <div class="col-md-2">
                                        <a href="<?php echo url('AdminIndex/view', array('id' => $post['id'], 'uid' => $vo['user_id'])); ?>" class="export" target="_blank">预览</a>
                                        <a href="<?php echo url('AdminIndex/export', array('id' => $post['id'], 'uid' => $vo['user_id'])); ?>" class="export">导出pdf</a>
                                    </div>
                        </td>
                        
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    
                    
                    <!-- <tr>
                        <th>协议书</th>
                        <td>
                            <ul id="files" class="pic-list list-unstyled form-inline">
                                <?php if(!(empty($post['more']['files']) || (($post['more']['files'] instanceof \think\Collection || $post['more']['files'] instanceof \think\Paginator ) && $post['more']['files']->isEmpty()))): if(is_array($post['more']['files']) || $post['more']['files'] instanceof \think\Collection || $post['more']['files'] instanceof \think\Paginator): if( count($post['more']['files'])==0 ) : echo "" ;else: foreach($post['more']['files'] as $key=>$vo): $file_url=cmf_get_file_download_url($vo['url']); ?>
                                        <li id="saved-file<?php echo $key; ?>">
                                            <input id="file-<?php echo $key; ?>" type="hidden" name="file_urls[]"
                                                   value="<?php echo $vo['url']; ?>">
                                            <input class="form-control" id="file-<?php echo $key; ?>-name" type="text"
                                                   name="file_names[]"
                                                   value="<?php echo $vo['name']; ?>" style="width: 200px;" title="图片名称">
                                            <a id="file-<?php echo $key; ?>-preview" href="<?php echo $file_url; ?>" target="_blank">下载</a>
                                            <a href="javascript:uploadOne('文件上传','#file-<?php echo $key; ?>','file');">替换</a>
                                            <a href="javascript:(function(){$('#saved-file<?php echo $key; ?>').remove();})();">移除</a>
                                        </li>
                                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </ul>
                            <a href="javascript:uploadMultiFile('附件上传','#files','files-item-tpl','file');"
                               class="btn btn-sm btn-default">选择文件</a>
                        </td>
                    </tr> -->

                    <!-- <tr>
                        <th>协议内容</th>
                        <td>
                            <script type="text/plain" id="content" name="post[post_content]"><?php echo $post['post_content']; ?></script>
                        </td>
                    </tr> -->
                    <!-- <tr>
                        <th>音频</th>
                        <td class="form-inline">
                            <input id="file-audio" class="form-control" type="text" name="post[more][audio]"
                                   value="<?php echo (isset($post['more']['audio']) && ($post['more']['audio'] !== '')?$post['more']['audio']:''); ?>" placeholder="请上传音频文件" style="width: 200px;">
                            <?php if(!(empty($post['more']['audio']) || (($post['more']['audio'] instanceof \think\Collection || $post['more']['audio'] instanceof \think\Paginator ) && $post['more']['audio']->isEmpty()))): ?>
                                <a id="file-audio-preview" href="<?php echo cmf_get_file_download_url($post['more']['audio']); ?>"
                                   target="_blank">下载</a>
                            <?php endif; ?>

                            <a href="javascript:uploadOne('文件上传','#file-audio','audio');">上传</a>
                        </td>
                    </tr>
                    <tr>
                        <th>视频</th>
                        <td class="form-inline">
                            <input id="file-video" class="form-control" type="text" name="post[more][video]"
                                   value="<?php echo (isset($post['more']['video']) && ($post['more']['video'] !== '')?$post['more']['video']:''); ?>" placeholder="请上传视频文件" style="width: 200px;">
                            <?php if(!(empty($post['more']['video']) || (($post['more']['video'] instanceof \think\Collection || $post['more']['video'] instanceof \think\Paginator ) && $post['more']['video']->isEmpty()))): ?>
                                <a id="file-video-preview" href="<?php echo cmf_get_file_download_url($post['more']['video']); ?>"
                                   target="_blank">下载</a>
                            <?php endif; ?>
                            <a href="javascript:uploadOne('文件上传','#file-video','video');">上传</a>
                        </td>
                    </tr> -->
                </table>

                <?php 
    \think\Hook::listen('portal_admin_article_edit_view_main',$temp5bf41e34a38d5,null,false);
 ?>
            </div>
            
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
                <a class="btn btn-default" href="javascript:history.back(-1);"><?php echo lang('BACK'); ?></a>
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

        // editorcontent = new baidu.editor.ui.Editor();
        // editorcontent.render('content');
        // try {
        //     editorcontent.sync();
        // } catch (err) {
        // }

        $('.btn-cancel-thumbnail').click(function () {
            $('#thumbnail-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail').val('');
        });

        $('#more-template-select').val("<?php echo (isset($post['more']['template']) && ($post['more']['template'] !== '')?$post['more']['template']:''); ?>");

        $('#categories-model-sel').change(function(){
            var model_seled = $(this).val();
            // console.log(model_seled);
            editorcontent.execCommand('cleardoc');
            $.ajax({
                method: 'POST',
                url: "<?php echo url('AdminCategory/getmodel'); ?>",
                data: {
                    id: model_seled
                },
                success: function(data, status){
                    console.log(data);
                    if(data.code == 200){
                        editorcontent.execCommand('inserthtml', data.data.description);
                    }else{
                        alert(data.msg);
                    }
                }
            })
            
        })
    });

    function doSelectCategory() {
        var selectedCategoriesId = $('#js-categories-id-input').val();
        openIframeLayer("<?php echo url('AdminCategory/select'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
            area: ['700px', '400px'],
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                //do something

                var iframeWin          = window[layero.find('iframe')[0]['name']];
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

    function doSelectCategory_seal() {
        var selectedCategoriesId = $('#js-categories-id-input-seal').val();
        openIframeLayer("<?php echo url('AdminCategory/select_seal'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
            area: ['700px', '400px'],
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                //do something

                var iframeWin          = window[layero.find('iframe')[0]['name']];
                var selectedCategories = iframeWin.confirm();
                if (selectedCategories.selectedCategoriesId.length == 0) {
                    layer.msg('请选择分类');
                    return;
                }
                $('#js-categories-id-input-seal').val(selectedCategories.selectedCategoriesId.join(','));
                $('#js-categories-name-input-seal').val(selectedCategories.selectedCategoriesName.join(' '));
                //console.log(layer.getFrameIndex(index));
                layer.close(index); //如果设定了yes回调，需进行手工关闭
            }
        });
    }

    function doSelectCategory_user() {
        var selectedCategoriesId = $('#js-categories-id-input-user').val();
        openIframeLayer("<?php echo url('AdminCategory/select_user'); ?>?ids=" + selectedCategoriesId, '请选择分类', {
            area: ['700px', '400px'],
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                //do something

                var iframeWin          = window[layero.find('iframe')[0]['name']];
                var selectedCategories = iframeWin.confirm();
                if (selectedCategories.selectedCategoriesId.length == 0) {
                    layer.msg('请选择分类');
                    return;
                }
                $('#js-categories-id-input-user').val(selectedCategories.selectedCategoriesId.join(','));
                $('#js-categories-name-input-user').val(selectedCategories.selectedCategoriesName.join(' '));
                //console.log(layer.getFrameIndex(index));
                layer.close(index); //如果设定了yes回调，需进行手工关闭
            }
        });
    }
</script>

<script>

    var publishYesUrl   = "<?php echo url('AdminIndex/publish',array('yes'=>1)); ?>";
    var publishNoUrl    = "<?php echo url('AdminIndex/publish',array('no'=>1)); ?>";
    var topYesUrl       = "<?php echo url('AdminIndex/top',array('yes'=>1)); ?>";
    var topNoUrl        = "<?php echo url('AdminIndex/top',array('no'=>1)); ?>";
    var recommendYesUrl = "<?php echo url('AdminIndex/recommend',array('yes'=>1)); ?>";
    var recommendNoUrl  = "<?php echo url('AdminIndex/recommend',array('no'=>1)); ?>";

    var postId = $('#post-id').val();

    //发布操作
    $("#post-status-checkbox").change(function () {
        if ($('#post-status-checkbox').is(':checked')) {
            //发布
            $.ajax({
                url: publishYesUrl, type: "post", dataType: "json", data: {ids: postId}, success: function (data) {
                    if (data.code != 1) {
                        $('#post-status-checkbox').removeAttr("checked");
                        $('#post-status-error').html(data.msg).show();

                    } else {
                        $('#post-status-error').hide();
                    }
                }
            });
        } else {
            //取消发布
            $.ajax({
                url: publishNoUrl, type: "post", dataType: "json", data: {ids: postId}, success: function (data) {
                    if (data.code != 1) {
                        $('#post-status-checkbox').prop("checked", 'true');
                        $('#post-status-error').html(data.msg).show();
                    } else {
                        $('#post-status-error').hide();
                    }
                }
            });
        }
    });

    //置顶操作
    $("#is-top-checkbox").change(function () {
        if ($('#is-top-checkbox').is(':checked')) {
            //置顶
            $.ajax({
                url: topYesUrl, type: "post", dataType: "json", data: {ids: postId}, success: function (data) {
                    if (data.code != 1) {
                        $('#is-top-checkbox').removeAttr("checked");
                        $('#is-top-error').html(data.msg).show();

                    } else {
                        $('#is-top-error').hide();
                    }
                }
            });
        } else {
            //取消置顶
            $.ajax({
                url: topNoUrl, type: "post", dataType: "json", data: {ids: postId}, success: function (data) {
                    if (data.code != 1) {
                        $('#is-top-checkbox').prop("checked", 'true');
                        $('#is-top-error').html(data.msg).show();
                    } else {
                        $('#is-top-error').hide();
                    }
                }
            });
        }
    });
    //推荐操作
    $("#recommended-checkbox").change(function () {
        if ($('#recommended-checkbox').is(':checked')) {
            //推荐
            $.ajax({
                url: recommendYesUrl, type: "post", dataType: "json", data: {ids: postId}, success: function (data) {
                    if (data.code != 1) {
                        $('#recommended-checkbox').removeAttr("checked");
                        $('#recommended-error').html(data.msg).show();

                    } else {
                        $('#recommended-error').hide();
                    }
                }
            });
        } else {
            //取消推荐
            $.ajax({
                url: recommendNoUrl, type: "post", dataType: "json", data: {ids: postId}, success: function (data) {
                    if (data.code != 1) {
                        $('#recommended-checkbox').prop("checked", 'true');
                        $('#recommended-error').html(data.msg).show();
                    } else {
                        $('#recommended-error').hide();
                    }
                }
            });
        }
    });


</script>


</body>
</html>
