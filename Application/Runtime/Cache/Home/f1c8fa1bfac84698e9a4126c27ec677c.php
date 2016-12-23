<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计
      var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "//hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script><meta charset="UTF-8"><title>菜鸟帮帮-账号设置-修改密码</title></head><body><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><div class="top"><div class="top-nav"><a href="/index.html"><img src="/Public/img/cjn_logo.png"/></a><div class="menu"><a class="sub-menu index-menu <?php if($nav == 'index'): ?>active<?php endif; ?>" href="/index.html"></a><a class="sub-menu ds-menu <?php if($nav == 'post'): ?>active<?php endif; ?>" href="/postList.html"></a><?php if($_SESSION['member']['type']== 1): ?><a class="sub-menu jm-menu <?php if($nav == 'resume'): ?>active<?php endif; ?>" href="/resume/list.html"></a><?php else: ?><a class="sub-menu jm-menu" href="/login.html?return_url=<?php echo (return_url('/resume/list.html')); ?>"></a><?php endif; ?></div></div><?php if($_SESSION['member']['type']== 1): ?><div class="other-nav"><ul class="my-nav"><li><a class="my-message" href="/messages.html"><i></i>专属推荐<span class="new-tag js_recommend_num" <?php if(empty($_SESSION['message_num']['recommend'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li><a class="my-reply" href="/resume/myFeedback.html"><i></i>投递反馈<span class="new-tag js_feedmsg_num" <?php if(empty($_SESSION['message_num']['deliver'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li id="my" class="my"><span><i></i><?php if(empty($_SESSION['member']['nick_name'])): echo (substr_replace($_SESSION['member']['user_name'],'****',4,4)); else: echo ($_SESSION['member']['nick_name']); endif; ?></span><div id="myNav" class="my-top-nav"><a class="sub-nav" href="/resume/list.html">我的简历</a><a class="sub-nav" href="/resume/myFavorite.html">我的收藏</a><!-- <a class="sub-nav" href="/systemNotice.html">系统通知</a> --><a class="sub-nav" href="/userInfo/setting">账号设置</a><a class="sub-nav" href="/logout.html">退出</a></div></li><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php else: ?><div class="other-nav"><div class="logon"><a class="logon-item active" href="/login.html">登录</a><span>|</span><a class="logon-item" href="/register.html">注册</a></div><ul class="my-nav"><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php endif; ?></div><div class="profile-banner"><img src="/Public/img/profile_top.jpg"/></div><div class="my-info-box"><div class="content"><p class="block-title">账号设置<span>Account settings</span></p></div><div class="my-detail"><div class="detail settings"><div class="slide-nav"><a class="sub-slide-nav myinfo" href="/userInfo/setting.html"><i></i>个人信息</a><a class="sub-slide-nav intention active" href="/userInfo/changePwd.html"><i></i>修改密码</a><!-- <a class="sub-slide-nav invitation" href="/userInfo/invitation.html"><i></i>邀请码</a> --></div><div class="settings-info"><form><div class="input-box"><input id="oldPassword" type="password" maxlength="18" /><label for="oldPassword">请输入当前密码</label></div><div class="input-box"><input id="newPassword" type="password" maxlength="18" /><label for="newPassword">请输入新密码</label></div><div class="input-box"><input id="surePassword" type="password" maxlength="18" /><label for="surePassword">确认密码</label></div><a class="settings-btn js_change_pwd" href="javascript:;">保存</a></form></div></div></div></div><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/min/common.min.js?<?php echo date("Ymd");?>"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
  //     $(window).scroll(function () {
  //         if ($(document).scrollTop() >= ($(document).height()-$(window).height())){
  //             $(".bottom-ad").css("bottom","76px");
  //         }else {
  //             $(".bottom-ad").css("bottom","0");
  //         }
  //     })
  // });
//IE9以下placeholder
$(function(){
    if(!placeholderSupport()){   // 判断浏览器是否支持 placeholder
        $('[placeholder]').focus(function() {
            var input = $(this);
            if(input.attr('type') == 'password'){
              return false;
            }
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
            var input = $(this);
            if(input.attr('type') == 'password'){
              return false;
            }
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
    }
});
function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}
</script><!-- End of KF5 supportbox script --></body></html>