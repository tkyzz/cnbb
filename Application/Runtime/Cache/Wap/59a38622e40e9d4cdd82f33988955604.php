<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>投递成功</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
    <script type="text/javascript">
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/deliverySuccess.css">
</head>
<body>
    <div class="download-page">
        <header class="header">
            <a class="back" href="javascript:;"><i></i></a>
            <span class="title">投递成功</span>
        </header>
        <div class="content">
            <div class="success-img"><img src="/Public/img/wap/success_phone.png"/></div>
            <div class="success-cont">
                <div class="success-icon"><img src="/Public/img/wap/success_icon.png"/></div>
                <div class="success-tips"><img src="/Public/img/wap/success_tips.png"/></div>
                <div class="success-activity">
                    <p class="app-tips">想及时获得HR的投递反馈？</p>
                    <div class="app-download"><a class="download-btn" href="<?php echo ($download_url); ?>">立即下载菜鸟帮帮App</a></div>
                    <a class="stay" href="/m/postList.html"><i></i>继续浏览岗位</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="id" value="<?php echo (smartBase64($_GET['id'])); ?>">
</body>
<script type="text/javascript">
$('.back').click(function(){
    var id = $('#id').val();
    window.location.href = '/m/post/'+id;
});
</script>
</html>