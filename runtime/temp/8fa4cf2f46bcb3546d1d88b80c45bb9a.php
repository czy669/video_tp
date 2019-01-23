<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/Users/didi/czydidi/www/video_tp/public/../application/index/view/mobile/index.html";i:1543289809;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo (isset($title) && ($title !== '')?$title:''); ?> – <?php echo __('Webname'); ?></title>
	<link href="/assets/mobile/css/index_h5.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/assets/mobile/css/htmleaf-demo.css">
	<link rel="stylesheet" href="/assets/mobile/css/main.css">
</head>
<body>

<div class="htmleaf-container">
	<div class="container">
		<div class="waterfall">

			<?php if(is_array($data['data']) || $data['data'] instanceof \think\Collection || $data['data'] instanceof \think\Paginator): if( count($data['data'])==0 ) : echo "" ;else: foreach($data['data'] as $key=>$vo): ?>
			<ul class="list-group">
				<li class="list-group-item">
					<a href="show.html?id=<?php echo $vo['id']; ?>">
						<img src="<?php echo $vo['cover']; ?>" />
					</a>
				</li>
				<li class="list-group-item">
					<div class="media">
						<div class="media-body">
							<h5 class="media-heading"><?php echo $vo['title']; ?> - <?php echo $vo['id']; ?></h5>
							<small>添加时间：<?php echo datetime($vo['createtime'],'Y-m-d'); ?></small>
						</div>
					</div>
				</li>
			</ul>
			<?php endforeach; endif; else: echo "" ;endif; ?>

		</div>
	</div>
</div>

<script type="text/javascript" src="/assets/index/js/jquery-1.11.0.min.js"></script>
<script src="/assets/mobile/js/bootstrap-waterfall.js"></script>
<script>
    //$('.waterfall').data('bootstrap-waterfall-template', $('#waterfall-template').html()).waterfall();
    $(".waterfall").waterfall();
</script>
</body>
</html>