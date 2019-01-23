<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:82:"/www/wwwroot/dage.gouwuduoduo.com/public/../application/index/view/index/show.html";i:1535552921;s:73:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/meta.html";i:1535552921;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/header.html";i:1532767849;s:78:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/recommend.html";i:1532865649;s:75:"/www/wwwroot/dage.gouwuduoduo.com/application/index/view/common/footer.html";i:1531736146;}*/ ?>
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

<!-- 内容 -->
<div class="show_content">
	<!-- 路径  -->
	<div class="show_path">
		<a onclick="href_url('/index/index/index.html')">首页</a> > <a onclick="href_url('/index/index/list.html?list&area_id=<?php echo $data['area_id']; ?>')"><?php echo $data['area_name']; ?></a>
	</div>
	
	<!-- 标题 -->
	<div class="show_path">
		<h3><?php echo $data['title']; ?></h3>
	</div>
	
	<div class="content show_con">
		<div class="show_l">
			<div class="show_l_con">
				<video id="my_video" width="100%" height="100%" controls poster="<?php echo $data['cover']; ?>">
					<source src="<?php echo $data['videopath']; ?>" type="video/mp4">
					<source src="<?php echo $data['videopath']; ?>" type="video/webm">
					<source src="<?php echo $data['videopath']; ?>" type="video/ogg">
				</video>
			</div>
		</div>
		<div class="show_r">
			<?php if(is_array($data_left) || $data_left instanceof \think\Collection || $data_left instanceof \think\Paginator): $i = 0; $__LIST__ = $data_left;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="show_r_con">
				<div class="show_r_con_l"><img onclick="href_url('/index/index/show.html?id=<?php echo $vo['id']; ?>')" src="<?php echo $vo['cover']; ?>" /></div>
				<div class="show_r_con_r">
					<div class="show_r_con_r_title"><a onclick="href_url('/index/index/show.html?id=<?php echo $vo['id']; ?>')"><?php echo $vo['title']; ?></a></div>
					<div class="show_r_con_r_hits"><span>播放量：<?php echo $vo['hits']; ?></span></div>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			
		</div>
		<div class="clear"></div>
	</div>
	<!-- 详情简介 -->
	<div class="jianjie_title_top">
		<div class="jianjie_title"><h3><span>视频名称：</span><?php echo $data['title']; ?></h3></div>
		<div class="jianjie_title">
			<span>热度：</span><b><?php echo $data['hits']; ?></b>
			<span class="jianjie_title_mleft">上传日期：</span><b><?php echo datetime($data['createtime']); ?></b>
			<span class="jianjie_title_mleft">标签：</span><b><?php echo $data['tag']; ?></b>
		</div>
	</div>
	<div class="jianjie_content">
		<!-- 过渡线 -->
		<div class="hr_content"></div>
		<div class="jianjie_title">
			<span>分享链接：</span><b id="txt_CopyLink"><?php echo $url_path; ?></b> <a onclick="copyToClipboard()">点击复制</a>
		</div>
	</div>
</div>


<!-- 详情内容下边的推荐 -->
<div class="content roll">
	<div class="g1">
		<ul>
			<?php if(is_array($data_list) || $data_list instanceof \think\Collection || $data_list instanceof \think\Paginator): $key = 0; $__LIST__ = $data_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
			<li><div class="content_c">
					<div class="content_c_img"><a onclick="href_url('/index/index/show.html?id=<?php echo $vo['id']; ?>')"><img src="<?php echo $vo['cover']; ?>"></a></div>
					<div class="content_c_title"><a onclick="href_url('/index/index/show.html?id=<?php echo $vo['id']; ?>')"><?php echo $vo['title']; ?></a></div>
					<div class="content_c_bottom"><span>添加时间：<?php echo datetime($vo['createtime'],'Y-m-d'); ?></span><span class="content_c_bottom_hits">点击量：<?php echo $vo['hits']; ?></span></div>
			</div></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript" src="/assets/index/recommend/jquery.imgscroll.min.js"></script>
<script type="text/javascript">
    $(".g1").imgscroll({
        speed: 10, //图片滚动速度
        amount: 0, //图片滚动过渡时间
        dir: "left"   // "left" 或 "up" 向左或向上滚动
    });
</script>

<!-- 过渡线 -->
<div class="hr_content"></div>

<!-- 底部 -->
<div class="bot">
	<div class="footer">
		<?php echo $footer['footer']; ?>
	</div>
</div>
</body>
<script src="/assets/js/video.min.js"></script>
<script>
    var myPlayer = videojs('my_video');
    videojs("my_video").ready(function(){
        var myPlayer = this;
        myPlayer.play();
    });
</script>
</html>