<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>菜鸟帮帮</title>
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
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/sign.css">
</head>
<body>
    <div class="sign-page">
        <header class="header">
            <a class="back" href="javascript:window.history.go(-1)"><i></i></a>
            <span class="title">菜鸟帮帮</span>
        </header>

        <div class="sign register">
            <div class="sign-item phone">
                <div class="border border-top"></div>
                <div class="border border-bottom"></div>
                <i></i>
                <input class="input" type="text" id="username" placeholder="请输入手机号">
            </div>
            <div class="sign-item password">
                <div class="border border-top"></div>
                <div class="border border-bottom"></div>
                <i></i>
                <input class="input" type="password" id="password" placeholder="请输入密码">
            </div>
            <div class="sign-item code-img">
                <div class="border border-top"></div>
                <div class="border border-bottom"></div>
                <i></i>
                <div class="input">
                    <input class="input-code" type="text" id="verify_code" placeholder="请输入验证码">
                     <div class="register-code"><img alt="验证码" src="/m/Verify.html" class="js_verifyImg" title="点击刷新"> </div>
                </div>
            </div>
            <div class="sign-item code-sms">
                <div class="border border-top"></div>
                <div class="border border-bottom"></div>
                <i></i>
                <div class="input">
                    <input class="input-sms" type="text" id="smsCode" placeholder="请输入短信验证码"/>
                    <input class="sms-btn" type="button" id="js_send_phone_code" value="获取短信验证码"/>
                </div>
            </div>
            <input class="sign-btn" type="button" id="register" value="学生注册"/>
            <div class="sign-link">
                <div class="line line-left"></div>
                <div class="line line-right"></div>
                <a class="link" href="/m/login.html<?php if(!empty($_GET['return'])): ?>?return=<?php echo ($_GET['return']); endif; ?>">立即登录</a>
            </div>
            <div class="org-web">
                <i></i>
                企业用户请登录b.cainiaobangbang.com
            </div>
        </div>
    </div>
    <input type="hidden" id="sendcodetime" value="180"/>
    <input type="hidden" id="return_url" value="<?php echo ($_GET['return']); ?>">
</body>
<script src="/Public/js/wap/user.js"></script>
</html>