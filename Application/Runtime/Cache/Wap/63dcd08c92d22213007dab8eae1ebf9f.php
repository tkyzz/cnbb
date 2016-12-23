<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>投递反馈</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/feedback.css">
</head>
<body>
<header class="header">
    <a class="back" href="JavaScript:history.back(-1)"><i></i></a>
    <span class="title">投递反馈</span>
</header>
<div class="content">
    <nav class="top-nav">
        <span class="sub-nav">已投递</span>
        <span class="sub-nav">被查看</span>
        <span class="sub-nav">被邀请</span>
        <span class="sub-nav active">已确认</span>
        <span class="sub-nav">不合适</span>
    </nav>

    <div class="feedback-img"><img src="/Public/img/wap/feedback_ad.png"/></div>
    <div class="feedback">
        <div class="app-download"><a class="download-btn" href="<?php echo ($download_url); ?>">立即下载菜鸟帮帮App</a></div>
    </div>
</div>
</body>
</html>