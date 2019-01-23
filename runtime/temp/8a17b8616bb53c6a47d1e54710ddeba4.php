<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/Users/didi/czydidi/www/fastvideo/public/../application/index/view/test/test.html";i:1542337372;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="/assets/index/js/jquery-1.11.0.min.js"></script>
</head>
<body style="width: 1200px; margin: 0 auto;">

<input class="is_station" type="checkbox" value="yes">yes
<a onclick="click_a()">Click</a>
<script>
    function click_a() {
        var ck = $('.is_station').is(':checked');
        console.log(ck)
    }
    
    function sputdata( obj ) {
        var val1 = $(obj).parent().prev().children('input').get(0);
        var val2 = $(obj).parent().prev().children('input').get(1);
    }
</script>
</body>
</html>