<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"themes/admin_simpleboot3/protocol/admin_category/add.html";i:1542548103;s:77:"/var/www/sign_online/admin/public/themes/admin_simpleboot3/public/header.html";i:1540662485;}*/ ?>
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
</head>

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

<style>
        #axes li{
            margin-bottom: 10px;
            float: left;
        }
        #axes li input{
            margin-right: 10px;
        }
    
    </style>

<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('AdminCategory/index'); ?>">协议分类管理</a></li>
        <li class="active"><a>添加协议分类</a></li>
        <!-- <li class="active"><a>编辑协议分类</a></li> -->
    </ul>
    <div class="row margin-top-20">
        
        <div class="col-md-12">
            <form class="js-ajax-form" action="<?php echo url('AdminCategory/addPost'); ?>" method="post">
                <div class="tab-content">
                    <div class="tab-pane active" id="A">
                        <div class="form-group" style="display:none;">
                            <label for="input-parent"><span class="form-required">*</span>上级</label>
                            <div>
                                <select class="form-control" name="parent_id" id="input-parent">
                                    <option value="0">作为一级分类</option>
                                    <?php echo $categories_tree; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="">
                                <label for="input-parent"><span class="form-required">*</span>分类</label>
                                <div>
                                    <select class="form-control" name="mode_type" id="input-parent">
                                        <option value="0">请选择分类</option>
                                        <option value="1">保密工作责任书（通用部门)</option>
                                        <option value="3">员工保密承诺书</option>
                                        <option value="4">涉密人员保证书</option>
                                        <option value="5">涉密人员离岗保密承诺书</option>
                                    </select>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="input-name"><span class="form-required">*</span>分类名称</label>
                            <div>
                                <input type="text" class="form-control" id="input-name" name="name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-description">协议模板文件</label>
                            <div>

                                <ul id="files" class="pic-list list-unstyled form-inline">
                                </ul>
                                <a href="javascript:uploadMultiFile('附件上传','#files','files-item-tpl','file');"
                                   class="btn btn-sm btn-default">选择文件</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="display:none;">
                            <label for="input-description">签名位置</label>
                            <div>

                                <ul id="axes" class="pic-list list-unstyled form-inline col-md-12">
                                    <empty name="category.more.axes">
                                        <li id="axes-data0">
                                        <input type="text" class="form-control col-md-2" id="input-name" name="more[axes][page][]" value="" placeholder="页数">
                                        <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][sign][]" value="" placeholder="请填写签名坐标">
                                        <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][time][]" value="" placeholder="请填写签名日期坐标">
                                        
                                    </li>
                                </ul>
                                <a href="javascript:;"
                                   class="btn btn-sm btn-default add-axes">添加位置</a>
                            </div>
                        </div>
                    
                    
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="">
                    <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0"><?php echo lang('SAVE'); ?>
                    </button>
                    <a class="btn btn-default" href="<?php echo url('AdminCategory/index'); ?>"><?php echo lang('BACK'); ?></a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/js/admin.js"></script>
<script type="text/javascript">
    //编辑器路径定义
    var editorURL = GV.WEB_ROOT;
</script>
<script type="text/javascript" src="/static/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/static/js/ueditor/ueditor.all.min.js"></script>
<script>
    $('#input-list_tpl').val("<?php echo (isset($list_tpl) && ($list_tpl !== '')?$list_tpl:''); ?>");
    $('#input-one_tpl').val("<?php echo (isset($one_tpl) && ($one_tpl !== '')?$one_tpl:''); ?>");

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

            var i = 10;
            $('.add-axes').click(function(){
                var html = '<li id="axes-data'+i+'"><input type="text" class="form-control col-md-2" id="input-name" name="more[axes][page][]" value="" placeholder="页数"><input type="text" class="form-control col-md-5" id="input-name" name="more[axes][sign][]" value="" placeholder="请填写签名坐标"><input type="text" class="form-control col-md-5" id="input-name" name="more[axes][time][]" value="" placeholder="请填写签名日期坐标"><a href="javascript:del('+i+');">移除</a></li>';
                $('#axes').append(html);
                i++;
            })
        });

    function del(i){
        $("#axes-data"+i).remove();
        // (function(){$("#axes-data'+i+'").remove();}
    }
</script>
</body>
</html>