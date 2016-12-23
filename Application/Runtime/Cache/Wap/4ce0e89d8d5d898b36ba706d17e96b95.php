<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>工作地点</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/postList.css">
    <script src="/Public/js/style_h5.js"></script>
</head>
<body>
    <div class="page">
        <header class="header">
            <a class="back" href="javascript:;" onclick="JavaScript:history.back(-1);"><i></i></a>
            <span class="title">工作地点</span>
        </header>
        <div class="content">
            <p class="place-title">主要城市</p>
            <div class="place-list">
            <?php if(is_array($city)): foreach($city as $k=>$v): ?><span class="place-item" data-id="<?php echo ($v["code"]); ?>"><?php echo ($v["name"]); ?></span><?php endforeach; endif; ?>
            </div>
        </div>
    </div>
    <input type="hidden" id="trade" value="<?php echo ($_GET['trade']); ?>">
    <input type="hidden" id="work_type" value="<?php echo ($_GET['work_type']); ?>">
    <input type="hidden" id="week_day" value="<?php echo ($_GET['week_day']); ?>">
    <input type="hidden" id="work_day" value="<?php echo ($_GET['work_day']); ?>">
</body>
<script>
$(function(){

    $('.place-item').click(function(){
        var city = $(this).attr('data-id');
        var trade = $('#trade').val();
        var work_type = $('#work_type').val();
        var week_day = $('#week_day').val();
        var work_day = $('#work_day').val();
        var url = '/m/postList.html?';
        var paramarr = new Array();
        if ( trade ) {
            paramarr.push("trade=" + trade);
        }
        if ( work_type ) {
            paramarr.push("work_type=" + work_type);
        }
        if ( week_day ) {
            paramarr.push("week_day=" + week_day);
        }
        if ( work_day ) {
            paramarr.push("work_day=" + work_day);
        }
        paramarr.push("city=" + city);
        window.location.href = url+paramarr.join('&');
    });
})
</script>
</html>