<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"themes/admin_simpleboot3/protocol/admin_index/add.html";i:1543333503;s:77:"/var/www/sign_online/admin/public/themes/admin_simpleboot3/public/header.html";i:1540662485;}*/ ?>
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
        <li><a href="<?php echo url('AdminIndex/index'); ?>">协议管理</a></li>
        <li class="active"><a href="<?php echo url('AdminIndex/add'); ?>">添加协议</a></li>
    </ul>
    <form action="<?php echo url('AdminIndex/addPost'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    
                    <tr>
                        <th>标题<span class="form-required">*</span></th>
                        <td>
                            <input class="form-control" type="text" name="post[post_title]"
                                   id="title" required value="" placeholder="请输入标题"/>
                        </td>
                    </tr>

                    <tr>
                        <th width="100">协议模板<span class="form-required">*</span></th>
                        <td>
                            <div class="">
                                <select class="form-control valid" name="post[categories]" id="categories-model-sel" aria-invalid="false">
                                    <option value="0">请选择协议模板</option>
                                    <?php if(is_array($categories_model) || $categories_model instanceof \think\Collection || $categories_model instanceof \think\Paginator): $i = 0; $__LIST__ = $categories_model;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th width="100">行政公章<span class="form-required">*</span></th>
                        <td>
                            <input class="form-control" type="text" style="width:400px;" required value=""
                                   placeholder="请选择分类" onclick="doSelectCategory_seal();" id="js-categories-name-input-seal"
                                   readonly/>
                            <input class="form-control" type="hidden" value="" name="post[categories_seal]"
                                   id="js-categories-id-input-seal"/>
                        </td>
                    </tr>
                    <tr>
                        <th width="100">承诺人或保证人<span class="form-required">*</span></th>
                        <td>
                            <input class="form-control" type="text" style="width:400px;" required value=""
                                   placeholder="请选择分类" onclick="doSelectCategory_user();" id="js-categories-name-input-user"
                                   readonly/>
                            <input class="form-control" type="hidden" value="" name="post[categories_user]"
                                   id="js-categories-id-input-user"/>
                        </td>
                    </tr>
                    <tr>
                        <th width="100">负责人</th>
                        <td>
                            <input class="form-control" type="text" style="width:400px;" required
                                   value=""
                                   placeholder="请选择分类" onclick="doSelectCategory_user_one();" id="js-categories-name-input-user-one"
                                   readonly/>
                            <input class="form-control" type="hidden" value=""
                                   name="post[categories_user_one]"
                                   id="js-categories-id-input-user-one"/>
                        </td>
                    </tr>
                </table>
                <?php 
    \think\Hook::listen('portal_admin_article_edit_view_main',$temp5bfd793f95c10,null,false);
 ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('ADD'); ?></button>
                        <a class="btn btn-default" href="<?php echo url('AdminIndex/index'); ?>"><?php echo lang('BACK'); ?></a>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3">
                <table class="table table-bordered">
                    <tr>
                        <th><b>缩略图</b></th>
                    </tr>
                    <tr>
                        <td>
                            <div style="text-align: center;">
                                <input type="hidden" name="post[more][thumbnail]" id="thumbnail" value="">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail');">
                                    <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                         id="thumbnail-preview"
                                         width="135" style="cursor: pointer"/>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail" value="取消图片">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><b>发布时间</b></th>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control js-bootstrap-datetime" type="text" name="post[published_time]"
                                   value="<?php echo date('Y-m-d H:i:s',time()); ?>">
                        </td>
                    </tr>

                    <tr>
                        <th>文章模板</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control" name="post[more][template]" id="more-template-select">
                                <option value="">请选择模板</option>
                                <?php if(is_array($article_theme_files) || $article_theme_files instanceof \think\Collection || $article_theme_files instanceof \think\Paginator): if( count($article_theme_files)==0 ) : echo "" ;else: foreach($article_theme_files as $key=>$vo): $value=preg_replace('/^portal\//','',$vo['file']); ?>
                                    <option value="<?php echo $value; ?>"><?php echo $vo['name']; ?> <?php echo $vo['file']; ?>.html</option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <?php 
    \think\Hook::listen('portal_admin_article_edit_view_right_sidebar',$temp5bfd793f95c19,null,false);
 ?>
            </div> -->
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

        // $('#categories-model-sel').change(function(){
        //     var model_seled = $(this).val();
        //     // console.log(model_seled);
        //     editorcontent.execCommand('cleardoc');
        //     $.ajax({
        //         method: 'POST',
        //         url: "<?php echo url('AdminCategory/getmodel'); ?>",
        //         data: {
        //             id: model_seled
        //         },
        //         success: function(data, status){
        //             console.log(data);
        //             if(data.code == 200){
        //                 editorcontent.execCommand('inserthtml', data.data.description);
        //             }else{
        //                 alert(data.msg);
        //             }
        //         }
        //     })
            
        // })

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

    function doSelectCategory_user_one() {
        var selectedCategoriesId_one = $('#js-categories-id-input-user-one').val();
        var selectedCategoriesPlaces_one = $('#js-categories-place-input-user-one').val();
        openIframeLayer("<?php echo url('AdminCategory/select_user_one'); ?>?ids=" + selectedCategoriesId_one, '请选择分类', {
            area: ['700px', '400px'],
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                //do something

                var iframeWin          = window[layero.find('iframe')[0]['name']];
                var selectedCategories = iframeWin.confirm();
                // if (selectedCategories.selectedCategoriesId.length == 0) {
                //     layer.msg('请选择分类');
                //     return;
                // }else if (selectedCategories.selectedCategoriesId.length > 1) {
                //     layer.msg('只能存在一个协议负责人');
                //     return;
                // }

                $('#js-categories-id-input-user-one').val(selectedCategories.selectedCategoriesId.join(','));
                $('#js-categories-name-input-user-one').val(selectedCategories.selectedCategoriesName.join(' '));
                //console.log(layer.getFrameIndex(index));
                layer.close(index); //如果设定了yes回调，需进行手工关闭
            }
        });
    }
</script>
</body>
</html>
