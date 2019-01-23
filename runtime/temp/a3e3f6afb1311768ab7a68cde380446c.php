<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/www/wwwroot/dage.gouwuduoduo.com/public/../application/index/view/index/share.html";i:1535553015;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<title><?php echo $data['title']; ?></title>
</head>
<body style="margin: 0; padding: 0;">

<div style="width: 100%; height: auto;">
	<a style="position:fixed; right: 20px; top: 20px;" href="http://dage.gouwuduoduo.com" target="_blank">首页</a>
	<video id="my_video" width="100%" height="100%" controls poster="<?php echo $data['cover']; ?>">
		<source src="<?php echo $data['videopath']; ?>" type="video/mp4">
		<source src="<?php echo $data['videopath']; ?>" type="video/webm">
		<source src="<?php echo $data['videopath']; ?>" type="video/ogg">
	</video>
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