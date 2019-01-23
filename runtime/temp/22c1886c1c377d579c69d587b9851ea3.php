<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"/www/wwwroot/dage.gouwuduoduo.com/public/../application/index/view/user/register.html";i:1532767849;s:73:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/meta.html";i:1535552921;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/header.html";i:1532767849;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/footer.html";i:1531736146;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?> – <?php echo __('The fastest framework based on ThinkPHP5 and Bootstrap'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<?php if(isset($keywords)): ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php endif; if(isset($description)): ?>
<meta name="description" content="<?php echo $description; ?>">
<?php endif; ?>
<meta name="author" content="FastAdmin">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />

<link rel="stylesheet" type="text/css" href="/assets/index/css/style.css">
<link href="/assets/index/css/banner/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/assets/css/frontend.css" rel="stylesheet">

<!-- 引入jquery库 -->
<script type="text/javascript" src="/assets/index/js/jquery-1.11.0.min.js"></script>

<!-- 引入自写js -->
<script src="/assets/js/czy_write.js"></script>

<!-- 图片懒加载js -->
<script src="/assets/js/jquery.lazyload.js"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="/assets/js/html5shiv.js"></script>
<script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config: <?php echo json_encode($config); ?>
    };
    
    //图片懒加载
    $(function() {
        $("img.lazy").lazyload({effect: "fadeIn"});
    });
	
</script>

<?php if($controller == 'user'): endif; ?>
<!-- 引入系统js -->
<script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>

</head>
<body>

<!-- 头部 -->
<div class="top">
	<div class="top_c">
		<div class="top_c_logo"><a href="/index/index/index.html"><img src="/assets/index/images/logo108x35_black.png" /></a></div>
		<div class="top_c_content">
			<form action="/index/index/list.html" method="get">
				<input type="text" id="key" name="key" value="<?php if(!(empty($key) || (($key instanceof \think\Collection || $key instanceof \think\Paginator ) && $key->isEmpty()))): ?><?php echo $key; endif; ?>">
				<a onclick="search_key(this)">&nbsp;</a>
			</form>
		</div>
		<div class="top_c_r">
			<ul>
				<?php if(empty($userinfo) || (($userinfo instanceof \think\Collection || $userinfo instanceof \think\Paginator ) && $userinfo->isEmpty())): ?>
				<li><a onclick="href_url('/index/user/register.html','tab')" href="javascript:void(0)">注册</a></li>
				<li><a onclick="href_url('/index/user/login.html','tab')" href="javascript:void(0)">登录</a></li>
				<?php else: ?>
				<li><a onclick="href_url('/index/user/index.html')" style="color: #ffffff;" href="javascript:void(0)">欢迎用户：<?php echo $user['nickname']; ?></a></li>
				<?php endif; ?>
				<li><a onclick="AddFavorite(window.location,document.title)" href="javascript:void(0)">加入收藏</a></li>
				<li><a onclick="SetHome(window.location)" href="javascript:void(0)">设为首页</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>
<!-- 滚动出现导航条 -->
<div class="top headertop">
	<div class="headertop_con">
		<?php if(is_array($header) || $header instanceof \think\Collection || $header instanceof \think\Paginator): $i = 0; $__LIST__ = $header;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<a onclick="href_url('<?php echo $vo['url']; ?>')"><?php echo $vo['nickname']; ?></a>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
<script type="text/javascript">
	//页面加载完成后执行
    $(document).ready(function(){
        //检测滚动条位置出现导航条
        $(window).scroll(function(){
            var top = $(window).scrollTop();
            if(top > 100){
                $('.headertop').slideDown();
            }else{
                $('.headertop').slideUp();
            }
        });
    })
 
</script>

<div id="content-container" class="container login_content">
    <div class="user-section login-section">
        <div class="logon-tab clearfix"> <a href="<?php echo url('user/login'); ?>"><?php echo __('Sign in'); ?></a> <a class="active"><?php echo __('Sign up'); ?></a> </div>
        <div class="login-main">
            <form name="form1" id="register-form" class="form-vertical" method="POST" action="">
                <input type="hidden" name="invite_user_id" value="0" />
                <input type="hidden" name="url" value="<?php echo $url; ?>" />
                <?php echo token(); ?>
                <div class="form-group">
                    <label class="control-label required"><?php echo __('Email'); ?><span class="text-success"></span></label>
                    <div class="controls">
                        <input type="text" name="email" id="email" data-rule="required;email" class="form-control input-lg" placeholder="<?php echo __('Email'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Username'); ?></label>
                    <div class="controls">
                        <input type="text" id="username" name="username" data-rule="required;username" class="form-control input-lg" placeholder="<?php echo __('Username must be 3 to 30 characters'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Password'); ?></label>
                    <div class="controls">
                        <input type="password" id="password" name="password" data-rule="required;password" class="form-control input-lg" placeholder="<?php echo __('Password must be 6 to 30 characters'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Mobile'); ?></label>
                    <div class="controls">
                        <input type="text" id="mobile" name="mobile" data-rule="required;mobile" class="form-control input-lg" placeholder="<?php echo __('Mobile'); ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Captcha'); ?></label>
                    <div class="controls">
                        <div class="input-group input-group-lg">
                            <input type="text" name="captcha" class="form-control" placeholder="<?php echo __('Captcha'); ?>" data-rule="required;length(4)" style="border-radius: 0;" />
                            <span class="input-group-addon" style="padding:0;border:none;">
                                <img src="<?php echo captcha_src(); ?>" width="140" height="42" onclick="this.src = '<?php echo captcha_src(); ?>?r=' + Math.random();"/>
                            </span>
                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo __('Sign up'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 底部 -->
<div class="bot">
	<div class="footer">
		<?php echo $footer['footer']; ?>
	</div>
</div>
</body>
</html>