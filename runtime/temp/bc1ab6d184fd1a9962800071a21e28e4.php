<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:83:"/www/wwwroot/dage.gouwuduoduo.com/public/../application/index/view/index/index.html";i:1533740828;s:73:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/meta.html";i:1535552921;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/header.html";i:1532767849;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/banner.html";i:1531576599;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/footer.html";i:1531736146;}*/ ?>
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
<div class="show_content" style="padding:0;">
	<!-- banner -->
	<div class="container">
	<div class="trent-slider">
		<!-- banner内容 -->
		<?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $key = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;if($key == '1'): ?>
		<div class="t-slide current-t-slide"><img onclick="href_url('<?php echo $vo['url']; ?>','tab')" src="<?php echo $vo['image']; ?>" alt="<?php echo $vo['keywords']; ?>" /></div>
		<?php else: ?>
		<div class="t-slide"><img onclick="href_url('<?php echo $vo['url']; ?>','tab')" src="<?php echo $vo['image']; ?>" alt="<?php echo $vo['keywords']; ?>" /></div>
		<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		<!-- 左右箭头和底部标记 -->
		<div class="arrow right-arrow">
			<div class="arrow-container">
				<div class="arrow-icon"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
			</div>
		</div>
		<div class="arrow left-arrow">
			<div class="arrow-container">
				<div class="arrow-icon"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
			</div>
		</div>
		<div class="t-dots-container">
			<div class="t-slide-dots-wrap">
				<div class="t-slide-dots"> </div>
			</div>
		</div>
	
	</div>
</div>
<link rel="stylesheet" type="text/css" href="/assets/index/css/banner/htmleaf-demo.css">
<link rel="stylesheet" href="/assets/index/css/banner/main.css">
<script src="/assets/index/js/main.js"></script>

	
	<!-- 导航 -->
	<div class="banner_head">
		<div class="banner_head_c">
			<div class="banner_head_c_title">内容：</div>
			<div class="banner_head_c_con">
				<?php if(is_array($cate_list) || $cate_list instanceof \think\Collection || $cate_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<a onclick="href_url('/index/index/list.html?list&cate_id=<?php echo $vo['id']; ?>')"><?php echo $vo['title']; ?></a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="banner_head_c">
			<div class="banner_head_c_title">地区：</div>
			<div class="banner_head_c_con">
				<?php if(is_array($area_list) || $area_list instanceof \think\Collection || $area_list instanceof \think\Paginator): $i = 0; $__LIST__ = $area_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<a onclick="href_url('/index/index/list.html?list&area_id=<?php echo $vo['id']; ?>')"><?php echo $vo['title']; ?></a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="banner_head_c" style="border:0;">
			<div class="banner_head_c_title">标签：</div>
			<div class="banner_head_c_con">
				<?php foreach($trans_list as $vo): ?>
				<a onclick="href_url('/index/index/list.html?list&key=<?php echo $vo['name']; ?>')"><?php echo $vo['name']; ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<!-- 内容 -->
<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	<!-- 内容导航 -->
	<div class="con_header">
		<div class="con_header_title"><b><i class="fa fa-group"></i> <?php echo $vo['type_name']; ?></b><a onclick="href_url('/index/index/list.html')">更多 ></a></div>
		<div class="con_header_con" style="display:none;">
			<?php if(is_array($vo['type']) || $vo['type'] instanceof \think\Collection || $vo['type'] instanceof \think\Paginator): $type_key = 0; $__LIST__ = $vo['type'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($type_key % 2 );++$type_key;if($type_key != '1'): ?> | <?php endif; ?><a onclick="href_url('<?php echo $type['url']; ?>')"><?php echo $type['nickname']; ?></a>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="clear"></div>
	</div>
	
	<!-- 内容区域 -->
	<div class="content">
		<?php if(is_array($vo['data']) || $vo['data'] instanceof \think\Collection || $vo['data'] instanceof \think\Paginator): $d_key = 0; $__LIST__ = $vo['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($d_key % 2 );++$d_key;?>
		<div class="content_c" <?php if($d_key%5 == 1): ?>style="margin-left: 0;"<?php endif; ?>>
			<div class="content_c_img">
				<a onclick="href_url('/index/index/show.html?id=<?php echo $list['id']; ?>')"><img class="lazy" data-original="<?php echo $list['cover']; ?>"></a>
			</div>
			<div class="content_c_title"><a onclick="href_url('/index/index/show.html?id=<?php echo $list['id']; ?>')"><?php echo $list['title']; ?></a></div>
			<div class="content_c_bottom"><span>添加时间：<?php echo datetime($list['createtime'],'Y-m-d'); ?></span><span class="content_c_bottom_hits">点击量：<?php echo $list['hits']; ?></span></div>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<div class="clear"></div>
	</div>
<?php endforeach; endif; else: echo "" ;endif; ?>

<!-- 底部 -->
<div class="bot">
	<div class="footer">
		<?php echo $footer['footer']; ?>
	</div>
</div>
</body>
<script>

</script>
</html>