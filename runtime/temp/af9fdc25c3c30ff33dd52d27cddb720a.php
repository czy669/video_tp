<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/Users/didi/czydidi/www/fastvideo/public/../application/index/view/mobile/show.html";i:1543290606;}*/ ?>
<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title><?php echo $data['title']; ?> - <?php echo __('Webname'); ?></title>
	<link rel="stylesheet" type="text/css" href="/assets/mobile/hdfay/bootstrap.min.css" />
</head>
<body>

<div>
    <video id="my_video" width="100%" height="100%" controls poster="<?php echo $data['cover']; ?>">
        <source src="<?php echo $data['videopath']; ?>" type="video/mp4">
        <source src="<?php echo $data['videopath']; ?>" type="video/webm">
        <source src="<?php echo $data['videopath']; ?>" type="video/ogg">
    </video>
</div>

<script type="text/javascript" src="/assets/index/js/jquery-1.11.0.min.js"></script>
<script src="/assets/js/video.min.js"></script>
<script>
    
</script>
</body>
</html>