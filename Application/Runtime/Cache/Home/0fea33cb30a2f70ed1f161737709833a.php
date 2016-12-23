<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="description" content="金融机构实习，找菜鸟帮帮"><meta name="keys" content="实习,金融,学生"><title>菜鸟帮帮-企业注册</title><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script></head><body><div class="page info-page company-page"><?php if($navclass == 'index'): ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/indexPage.css"><?php else: ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><?php endif; ?><div class="top"><div class="top-nav"><a href="/logout.html?return=/index.html"><img src="/public/img/cjn_logo.png"/></a><div class="other-nav"><ul class="my-nav"><li><a class="student-link" href="/logout.html">我是学生</a></li><li><span class="part-line">|</span></li><li class="my"><a class="app-download" href="/app.html"><i></i>App下载</a><!--                         <div class="app-code"><img src="/Public/img/app_download.jpg"/></div> --></li></ul></div></div></div><div class="logon-box"><div class="email-info"><div class="email-img"><img src="/Public/img/email_img.png"></div><div class="info"><p class="send-mailbox">验证邮件已发送至：<span class="js_email"><?php echo (session('email')); ?></span></p><span class="others-info">请登录邮箱点击邮件内的链接，此链接24小时后失效。</span></div></div><!--重新发送验证邮件使用--><!--<div class="email-info mail-success">--><!--<div class="email-img sign-email-img"><img src="../img/email_success.png"></div>--><!--<p class="success-mailbox">邮件发送成功</p>--><!--</div>--><span class="info-space"></span><div class="email-info email-tips"><div class="email-img"><img src="/Public/img/email_tips.png"></div><div class="info"><span class="others-info">没有收到验证邮件怎么办？</span><ul class="tips-info"><li>邮箱地址填写错误？<a href="<?php echo ($url); ?>"><?php echo ($tips); ?></a></li><li>邮件有时会调皮进入垃圾信箱、广告信箱，请留意</li><li>稍等几分钟，若还未收到验证邮件，<a href="javascript:;" id="js_re_send">重新发送验证邮件</a></li></ul></div></div></div><input type="hidden" name="" id="p_url" value="<?php echo ($p_url); ?>"><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>.2"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --></div><script src="/Public/js/member.js"></script><script type="text/javascript">    $('#js_re_send').click(function(){
        var p_url = $('#p_url').val();
        var email = $('.js_email').text();
        if(email.length == 0 || p_url.length == 0){
            return false;
        }
        $.post(p_url,{email:email},
          function(data){
             if (data.status==1) {
                    layer.msg(data.msg, {icon: 1});
                    //window.location.reload();
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
              },
          "json");
    });


</script></body></html>