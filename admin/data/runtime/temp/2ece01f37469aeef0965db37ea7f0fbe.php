<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:37:"themes/simpleboot3/user/register.html";i:1540662485;s:69:"/var/www/sign_online/admin/public/themes/simpleboot3/public/head.html";i:1540662485;s:73:"/var/www/sign_online/admin/public/themes/simpleboot3/public/function.html";i:1540662485;s:68:"/var/www/sign_online/admin/public/themes/simpleboot3/public/nav.html";i:1540662485;s:72:"/var/www/sign_online/admin/public/themes/simpleboot3/public/scripts.html";i:1540662485;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="keywords" content=""/>
    <meta name="description" content="">
    
<?php 
/*可以加多个方法哟！*/
function _sp_helloworld(){
	echo "hello ThinkCMF!";
}

function _sp_helloworld2(){
	echo "hello ThinkCMF2!";
}


function _sp_helloworld3(){
	echo "hello ThinkCMF3!";
}

 ?>
<meta name="author" content="ThinkCMF">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">

<!-- No Baidu Siteapp-->
<meta http-equiv="Cache-Control" content="no-siteapp"/>

<!-- HTML5 shim for IE8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<![endif]-->
<link rel="icon" href="/themes/simpleboot3/public/assets/images/favicon.png" type="image/png">
<link rel="shortcut icon" href="/themes/simpleboot3/public/assets/images/favicon.png" type="image/png">
<link href="/themes/simpleboot3/public/assets/simpleboot3/themes/simpleboot3/bootstrap.min.css" rel="stylesheet">
<link href="/themes/simpleboot3/public/assets/simpleboot3/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"
      type="text/css">
<!--[if IE 7]>
<link rel="stylesheet" href="/themes/simpleboot3/public/assets/simpleboot3/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="/themes/simpleboot3/public/assets/css/style.css" rel="stylesheet">
<style>
    /*html{filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(1);}*/
    #backtotop {
        position: fixed;
        bottom: 50px;
        right: 20px;
        display: none;
        cursor: pointer;
        font-size: 50px;
        z-index: 9999;
    }

    #backtotop:hover {
        color: #333
    }

    #main-menu-user li.user {
        display: none
    }
</style>
<script type="text/javascript">
    //全局变量
    var GV = {
        ROOT: "/",
        WEB_ROOT: "/",
        JS_ROOT: "static/js/"
    };
</script>
<script src="/themes/simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
<script src="/themes/simpleboot3/public/assets/js/jquery-migrate-1.2.1.js"></script>
<script src="/static/js/wind.js"></script>
	
</head>

<body class="body-white">
<nav class="navbar navbar-default navbar-fixed-top active">
    <div class="container active">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?php echo (isset($theme_vars['company_name']) && ($theme_vars['company_name'] !== '')?$theme_vars['company_name']:'ThinkCMF'); ?></a>
        </div>

        <div class="collapse navbar-collapse active" id="bs-example-navbar-collapse-1">
            <ul id="main-menu" class="nav navbar-nav">
                <?php

function __parse_navigationdfc124d23cb94fc0bee7aa7fc984ae46($menus,$level=1){
$_parse_navigation_func_name = '__parse_navigationdfc124d23cb94fc0bee7aa7fc984ae46';
if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$menu): if(empty($menu['children'])): if($level > 1): ?>
                            <li class="menu-item menu-item-level-<?php echo $level; ?> levelgt1">
                                <a href="<?php echo (isset($menu['href']) && ($menu['href'] !== '')?$menu['href']:''); ?>" target="<?php echo (isset($menu['target']) && ($menu['target'] !== '')?$menu['target']:''); ?>">
                                    <?php echo (isset($menu['name']) && ($menu['name'] !== '')?$menu['name']:''); ?>
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="menu-item menu-item-level-<?php echo $level; ?>">
                                <a href="<?php echo (isset($menu['href']) && ($menu['href'] !== '')?$menu['href']:''); ?>" target="<?php echo (isset($menu['target']) && ($menu['target'] !== '')?$menu['target']:''); ?>">
                                    <?php echo (isset($menu['name']) && ($menu['name'] !== '')?$menu['name']:''); ?>
                                </a>
                            </li>
                        <?php endif; endif; if(!empty($menu['children'])): ?>
    <li class="dropdown dropdown-custom dropdown-custom-level-<?php echo $level; ?>">
        
                        <a href="#" class="dropdown-toggle dropdown-toggle-<?php echo $level; ?>" data-toggle="dropdown">
                            <?php echo (isset($menu['name']) && ($menu['name'] !== '')?$menu['name']:''); ?><span class="caret"></span>
                        </a>
                    
        <ul class="dropdown-menu dropdown-menu-level-<?php echo $level; ?>">
            <?php 
            $mLevel=$level+1;
             ?>
            <?php echo $_parse_navigation_func_name($menu['children'],$mLevel); ?>
        </ul>
    </li>
<?php endif; endforeach; endif; else: echo "" ;endif; 
}
    $navMenuModel = new \app\admin\model\NavMenuModel();
    $menus = $navMenuModel->navMenusTreeArray('',0);
if(''==''): ?>
    <?php echo __parse_navigationdfc124d23cb94fc0bee7aa7fc984ae46($menus); else: ?>
    < id="main-navigation" class="nav navbar-nav navbar-nav-custom">
        <?php echo __parse_navigationdfc124d23cb94fc0bee7aa7fc984ae46($menus); ?>
    </>
<?php endif; ?>

            </ul>
            <ul class="nav navbar-nav navbar-right" id="main-menu-user">
                <!--
                <li class="login">
                    <a class="dropdown-toggle notifactions" href="/index.php/user/notification/index"> <i
                            class="fa fa-envelope"></i> <span class="count">0</span></a>
                </li>
                -->
                <li class="dropdown user login">
                    <a class="dropdown-toggle user" data-toggle="dropdown" href="#">
                        <?php $user=cmf_get_current_user(); if(empty($user['avatar'])): ?>
                            <img src="/themes/simpleboot3/public/assets/images/headicon.png" class="headicon">
                            <?php else: ?>
                            <img src="<?php echo cmf_get_user_avatar_url($user['avatar']); ?>" class="headicon" width="30"/>
                        <?php endif; ?>
                        <span class="user-nickname"></span><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo cmf_url('user/Profile/center'); ?>"><i class="fa fa-home"></i> &nbsp;个人中心</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo cmf_url('user/Index/logout'); ?>"><i class="fa fa-sign-out"></i> &nbsp;退出</a></li>
                    </ul>
                </li>
                <li class="dropdown user offline" style="display: list-item;">
                    <a class="dropdown-toggle user" data-toggle="dropdown" href="#">
                        <img src="/themes/simpleboot3/public/assets/images/headicon.png" class="headicon">
                        登录<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo cmf_url('user/Login/index'); ?>"><i class="fa fa-sign-in"></i> &nbsp;登录</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo cmf_url('user/Register/index'); ?>"><i class="fa fa-user"></i> &nbsp;注册</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right" method="post" action="<?php echo cmf_url('portal/Search/index'); ?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Search"
                           value="<?php echo input('param.keyword',''); ?>">
                </div>
                <input type="submit" class="btn btn-primary" value="Go" style="margin:0"/>
            </form>
        </div>
    </div>
</nav>

<div class="container tc-main">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center">用户注册</h2>
            <?php 
                $mobile_tab_active=empty($theme_vars['enable_mobile'])?'':'active';
                $email_tab_active=empty($theme_vars['enable_mobile'])?'active':'';
             if(!(empty($theme_vars['enable_mobile']) || (($theme_vars['enable_mobile'] instanceof \think\Collection || $theme_vars['enable_mobile'] instanceof \think\Paginator ) && $theme_vars['enable_mobile']->isEmpty()))): ?>
                <ul class="nav nav-tabs nav-justified" id="myTab" style="margin-bottom: 15px;">
                    <li class="active"><a href="#mobile" data-toggle="tab">手机注册</a></li>
                    <li><a href="#email" data-toggle="tab">邮箱注册</a></li>
                </ul>
            <?php endif; 
                $is_open_registration = cmf_is_open_registration();
             ?>

            <div class="tab-content">
                <?php if(!(empty($theme_vars['enable_mobile']) || (($theme_vars['enable_mobile'] instanceof \think\Collection || $theme_vars['enable_mobile'] instanceof \think\Paginator ) && $theme_vars['enable_mobile']->isEmpty()))): ?>
                    <div class="tab-pane <?php echo $mobile_tab_active; ?>" id="mobile">
                        <form class="js-ajax-form" action="<?php echo url('user/Register/doRegister'); ?>" method="post">

                            <div class="form-group">
                                <input type="text" name="username" placeholder="手机号" class="form-control"
                                       id="js-mobile-input">
                            </div>

                            <div class="form-group">
                                <div style="position: relative;">
                                    <input type="text" name="captcha" placeholder="验证码" class="form-control"
                                           style="width: 170px;float: left;margin-right: 30px">
                                    <?php $__CAPTCHA_SRC=url('/captcha/new').'?height=38&width=160&font_size=20'; ?>
<img src="<?php echo $__CAPTCHA_SRC; ?>" onclick="this.src='<?php echo $__CAPTCHA_SRC; ?>&time='+Math.random();" title="换一张" class="captcha captcha-img verify_img" style="cursor: pointer;"/>
<input type="hidden" name="_captcha_id" value="">
                                </div>
                            </div>

                            <?php if(empty($is_open_registration) || (($is_open_registration instanceof \think\Collection || $is_open_registration instanceof \think\Paginator ) && $is_open_registration->isEmpty())): ?>
                                <div class="form-group">
                                    <div style="position: relative;">
                                        <input type="text" name="code" placeholder="手机验证码" style="width:170px;"
                                               class="form-control">
                                        <a class="btn btn-success js-get-mobile-code"
                                           style="width: 163px;position: absolute;top:0;right: 0;"
                                           data-wait-msg="[second]秒后才能再次获取" data-mobile-input="#js-mobile-input"
                                           data-url="<?php echo url('user/VerificationCode/send'); ?>"
                                           daty-type="register"
                                           data-init-second-left="60">获取手机验证码</a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <input type="password" name="password" placeholder="密码" class="form-control">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block js-ajax-submit" type="submit" data-wait="1500"
                                        style="margin-left: 0px;">确定注册
                                </button>
                            </div>

                            <div class="form-group" style="text-align: center;">
                                <p>
                                    已有账号? <a href="<?php echo cmf_url('user/Login/index'); ?>">点击此处登录</a>
                                </p>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <div class="tab-pane <?php echo $email_tab_active; ?>" id="email">
                    <form class="js-ajax-form" action="<?php echo url('user/register/doRegister'); ?>" method="post">

                        <div class="form-group">
                            <input type="text" name="username" placeholder="邮箱" class="form-control"
                                   id="js-email-input">
                        </div>

                        <div class="form-group">
                            <div style="position: relative;">
                                <input type="text" name="captcha" placeholder="验证码" class="form-control"
                                       style="width: 170px;float: left;margin-right: 30px">
                                <?php $__CAPTCHA_SRC=url('/captcha/new').'?height=38&width=160&font_size=20'; ?>
<img src="<?php echo $__CAPTCHA_SRC; ?>" onclick="this.src='<?php echo $__CAPTCHA_SRC; ?>&time='+Math.random();" title="换一张" class="captcha captcha-img verify_img" style="cursor: pointer;"/>
<input type="hidden" name="_captcha_id" value="">
                            </div>
                        </div>

                        <?php if(empty($is_open_registration) || (($is_open_registration instanceof \think\Collection || $is_open_registration instanceof \think\Paginator ) && $is_open_registration->isEmpty())): ?>
                            <div class="form-group">
                                <div style="position: relative;">
                                    <input type="text" name="code" placeholder="邮件验证码" style="width:170px;"
                                           class="form-control">
                                    <a class="btn btn-success js-get-email-code"
                                       style="width: 163px;position: absolute;top:0;right: 0;"
                                       data-wait-msg="[second]秒后才能再次获取" data-email-input="#js-email-input"
                                       data-url="<?php echo url('user/VerificationCode/send'); ?>"
                                       daty-type="register"
                                       data-init-second-left="60">获取邮箱验证码</a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <input type="password" name="password" placeholder="密码" class="form-control">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-block js-ajax-submit" type="submit" data-wait="1500"
                                    style="margin-left: 0px;">确定注册
                            </button>
                        </div>

                        <div class="form-group" style="text-align: center;">
                            <p>
                                已有账号? <a href="<?php echo cmf_url('user/Login/index'); ?>">点击此处登录</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
<!-- /container -->

<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/themes/simpleboot3/public/assets/simpleboot3/bootstrap/js/bootstrap.min.js"></script>
    <script src="/static/js/frontend.js"></script>
	<script>
	$(function(){
		$("#main-menu li.dropdown").hover(function(){
			$(this).addClass("open");
		},function(){
			$(this).removeClass("open");
		});
		
		$("#main-menu a").each(function() {
			if ($(this)[0].href == String(window.location)) {
				$(this).parentsUntil("#main-menu>ul>li").addClass("active");
			}
		});
		
		$.post("<?php echo url('user/index/isLogin'); ?>",{},function(data){
		    console.log(data);
			if(data.code==1){
				if(data.data.user.avatar){
				}

				$("#main-menu-user span.user-nickname").text(data.data.user.user_nickname?data.data.user.user_nickname:data.data.user.user_login);
				$("#main-menu-user li.login").show();
                $("#main-menu-user li.offline").hide();

			}

			if(data.code==0){
                $("#main-menu-user li.login").hide();
				$("#main-menu-user li.offline").show();
			}

		});

        ;(function($){
			$.fn.totop=function(opt){
				var scrolling=false;
				return this.each(function(){
					var $this=$(this);
					$(window).scroll(function(){
						if(!scrolling){
							var sd=$(window).scrollTop();
							if(sd>100){
								$this.fadeIn();
							}else{
								$this.fadeOut();
							}
						}
					});
					
					$this.click(function(){
						scrolling=true;
						$('html, body').animate({
							scrollTop : 0
						}, 500,function(){
							scrolling=false;
							$this.fadeOut();
						});
					});
				});
			};
		})(jQuery); 
		
		$("#backtotop").totop();
		
		
	});
	</script>


</body>
</html>