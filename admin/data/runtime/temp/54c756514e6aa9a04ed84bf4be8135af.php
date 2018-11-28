<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:58:"themes/admin_simpleboot3/protocol/admin_category/edit.html";i:1543367297;s:77:"/var/www/sign_online/admin/public/themes/admin_simpleboot3/public/header.html";i:1540625985;}*/ ?>
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


    <link href="/sign_online/admin/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/sign_online/admin/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/sign_online/admin/public/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
            ROOT: "/sign_online/admin/public/",
            WEB_ROOT: "/sign_online/admin/public/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/sign_online/admin/public/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/sign_online/admin/public/static/js/wind.js"></script>
    <script src="/sign_online/admin/public/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
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

</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('AdminCategory/index'); ?>">协议分类管理</a></li>
        <li><a href="<?php echo url('AdminCategory/add'); ?>">添加协议分类</a></li>
        <li class="active"><a>编辑协议分类</a></li>
    </ul>
    <div class="row margin-top-20">
        
        <div class="col-md-12">
            <form class="js-ajax-form" action="<?php echo url('AdminCategory/editPost'); ?>" method="post">
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
                            <label for="input-name"><span class="form-required">*</span>协议标题</label>
                            <div>
                                <input type="text" class="form-control" id="input-name" name="name" value="<?php echo $category['name']; ?>">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="input-name">分类别名</label>
                            <div>
                                <input type="text" class="form-control" id="input-alias" name="alias"
                                       value="<?php echo (isset($alias) && ($alias !== '')?$alias:''); ?>">
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="input-description">协议模板内容</label>
                            <div>
                                <script type="text/plain" id="content" name="description"><?php echo $category['description']; ?></script>
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="input-description">缩略图</label>
                            <div>
                                <input type="hidden" name="more[thumbnail]" class="form-control"
                                       value="<?php echo (isset($more['thumbnail']) && ($more['thumbnail'] !== '')?$more['thumbnail']:''); ?>" id="js-thumbnail-input">
                                <div>
                                    <a href="javascript:uploadOneImage('图片上传','#js-thumbnail-input');">
                                        <?php if(empty($more['thumbnail'])): ?>
                                            <img src="/sign_online/admin/public/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                                 id="js-thumbnail-input-preview"
                                                 width="135" style="cursor: pointer"/>
                                            <?php else: ?>
                                            <img src="<?php echo cmf_get_image_preview_url($more['thumbnail']); ?>"
                                                 id="js-thumbnail-input-preview"
                                            width="135" style="cursor: pointer"/>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="input-description">协议模板文件</label>
                            <div>
                                <!-- <input type="hidden" name="more[thumbnail]" class="form-control"
                                       value="<?php echo (isset($more['thumbnail']) && ($more['thumbnail'] !== '')?$more['thumbnail']:''); ?>" id="js-thumbnail-input">
                                <div>
                                    <a href="javascript:uploadOneImage('图片上传','#js-thumbnail-input');">
                                        <?php if(empty($more['thumbnail'])): ?>
                                            <img src="/sign_online/admin/public/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                                 id="js-thumbnail-input-preview"
                                                 width="135" style="cursor: pointer"/>
                                            <?php else: ?>
                                            <img src="<?php echo cmf_get_image_preview_url($more['thumbnail']); ?>"
                                                 id="js-thumbnail-input-preview"
                                            width="135" style="cursor: pointer"/>
                                        <?php endif; ?>
                                    </a>
                                </div> -->

                                <ul id="files" class="pic-list list-unstyled form-inline">
                                        <?php if(!(empty($category['more']['files']) || (($category['more']['files'] instanceof \think\Collection || $category['more']['files'] instanceof \think\Paginator ) && $category['more']['files']->isEmpty()))): if(is_array($category['more']['files']) || $category['more']['files'] instanceof \think\Collection || $category['more']['files'] instanceof \think\Paginator): if( count($category['more']['files'])==0 ) : echo "" ;else: foreach($category['more']['files'] as $key=>$vo): $file_url=cmf_get_file_download_url($vo['url']); ?>
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
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input-description">签名位置</label>
                            <div>

                                <ul id="axes" class="pic-list list-unstyled form-inline col-md-12">
                                    <?php if(empty($category['more']['axes']) || (($category['more']['axes'] instanceof \think\Collection || $category['more']['axes'] instanceof \think\Paginator ) && $category['more']['axes']->isEmpty())): ?>
                                            <li id="axes-data0">
                                                    <span class="form-control col-md-2">承诺人</span>
                                                    <input type="text" class="form-control col-md-2" id="input-name" name="more[axes][page][]" value="" placeholder="页数">
                                                    <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][sign][]" value="" placeholder="请填写签名坐标">
                                                    <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][time][]" value="" placeholder="请填写签名日期坐标">
                                                    
                                                </li>
            
                                                <li id="axes-data0">
                                                        <span class="form-control col-md-2">负责人</span>
                                                    <input type="text" class="form-control col-md-2" id="input-name" name="more[axes][page][]" value="" placeholder="页数">
                                                    <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][sign][]" value="" placeholder="请填写签名坐标">
                                                    <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][time][]" value="" placeholder="请填写签名日期坐标">
                                                    
                                                </li>
                                    <?php endif; if(!(empty($category['more']['axes']) || (($category['more']['axes'] instanceof \think\Collection || $category['more']['axes'] instanceof \think\Paginator ) && $category['more']['axes']->isEmpty()))): if(is_array($category['more']['axes']) || $category['more']['axes'] instanceof \think\Collection || $category['more']['axes'] instanceof \think\Paginator): if( count($category['more']['axes'])==0 ) : echo "" ;else: foreach($category['more']['axes'] as $key=>$vo): ?>
                                                        
                                                <li id="axes-data<?php echo $key; ?>">
                                                    <span class="form-control col-md-2"><?php if($key == 0): ?>承诺人<?php else: ?>负责人<?php endif; ?></span>
                                                    <input type="text" class="form-control col-md-2" id="input-name" name="more[axes][page][]" value="<?php echo $vo['page']; ?>" placeholder="页数">
                                                    <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][sign][]" value="<?php echo $vo['sign']; ?>" placeholder="请填写签名坐标">
                                                    <input type="text" class="form-control col-md-5" id="input-name" name="more[axes][time][]" value="<?php echo $vo['time']; ?>" placeholder="请填写签名日期坐标">
                                                    <!-- <a href="javascript:(function(){$('#axes-data<?php echo $key; ?>').remove();})();">移除</a> -->
                                                </li>

                                                
                                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                </ul>
                                <!-- <a href="javascript:;"
                                   class="btn btn-sm btn-default add-axes">添加位置</a> -->
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="input-description">公章位置</label>
                                <div>
    
                                    <ul id="axes" class="pic-list list-unstyled form-inline col-md-12">
                                        <li id="axes-data0">
                                            <input type="text" class="form-control col-md-2" id="input-name" name="more[seal][page]"
                                                value="<?php echo $category['more']['seal']['page']; ?>" placeholder="页数">
                                            <input type="text" class="form-control col-md-5" id="input-name" name="more[seal][sign]"
                                                value="<?php echo $category['more']['seal']['sign']; ?>" placeholder="请填写公章坐标">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                    
                    
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    <button type="submit" class="btn btn-primary js-ajax-submit" data-refresh="0"><?php echo lang('SAVE'); ?>
                    </button>
                    <a class="btn btn-default" href="<?php echo url('AdminCategory/index'); ?>"><?php echo lang('BACK'); ?></a>
                    <!-- <a class="btn btn-success" href="<?php echo url('AdminCoor/index'); ?>" target="_blank">获取坐标</a> -->
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="/sign_online/admin/public/static/js/admin.js"></script>
<script type="text/javascript">
    //编辑器路径定义
    var editorURL = GV.WEB_ROOT;
</script>
<script type="text/javascript" src="/sign_online/admin/public/static/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/sign_online/admin/public/static/js/ueditor/ueditor.all.min.js"></script>
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
                $('#thumbnail-preview').attr('src', '/sign_online/admin/public/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
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