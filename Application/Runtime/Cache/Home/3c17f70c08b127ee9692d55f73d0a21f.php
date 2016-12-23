<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="description" content="金融机构实习，找菜鸟帮帮"><meta name="keys" content="实习,金融,学生"><title>菜鸟帮帮-企业基本信息</title><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script></head><body><div class="page company-page company-basic-info company-touch-info"><?php if($navclass == 'index'): ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/indexPage.css"><?php else: ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><?php endif; ?><div class="top"><div class="top-nav"><a href="/logout.html?return=/index.html"><img src="/public/img/cjn_logo.png"/></a><div class="other-nav"><ul class="my-nav"><li><a class="student-link" href="/logout.html">我是学生</a></li><li><span class="part-line">|</span></li><li class="my"><a class="app-download" href="/app.html"><i></i>App下载</a><!--                         <div class="app-code"><img src="/Public/img/app_download.jpg"/></div> --></li></ul></div></div></div><div class="logon-box"><form id="comExtraForm" name="comExtraForm" method="post"><div class="basic-title"><span class="title-cont">企业联系方式（我们不会对用户显示这些信息）</span><span class="title-line"></span></div><div class="basic-item"><span class="basic-name">企业联系人</span><input class="basic-cont" type="text" name="contacter" placeholder="请输入企业联系人"/></div><div class="basic-item"><span class="basic-name">企业联系邮箱</span><input class="basic-cont" type="text" name="contacter_mail" placeholder="请输入企业联系邮箱" value="<?php echo (session('email')); ?>"/></div><div class="basic-item contact-number"><span class="basic-name">企业联系电话（任选其一）</span><div class="number"><input class="basic-cont" type="text" name="contacter_phone" placeholder="座机"/><input class="basic-cont" type="text" name="contacter_mobile" value="<?php echo (cookie('reg_phone')); ?>" placeholder="手机"/></div></div><input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>"><input type="text" name="yyzz_img" id="yyzz_id" data-show="0" style="height:0.5px;width:0px;padding:0px;margin:0px;"></form><input type="hidden" id="is_orgemail" value="<?php echo ($is_orgemail); ?>"><?php if(empty($is_orgemail)): ?><form id="yyzzForm" name="yyzzForm" method="post"><div class="basic-title other-title"><span class="title-cont">企业其他资料认证（我们不会对用户显示这些信息）</span><span class="title-line"></span></div><div class="data-upload"><div class="upload-box"><p class="example">示例</p><div class="upload-item"><div class="mask"><i></i>请上传营业执照或名片</div><div class="img-box"><img id="js_yyzz_show" src=""/></div><input type="file" id="yyzz_img" name="yyzz_img" alt="请选择图片"></div><div class="upload-item"><img src="/Public/img/orgImg/example.jpg"/></div></div><div class="upload-tips">                    1.上传营业执照或名片要清晰可辨（见上传示例），审核通过后将有已认证标识。<br>                    2.为保证信息安全，您上传的资质证明不提供预览功能，请谅解。<br>                    3.该资质证明只用作菜鸟帮帮审核认证使用，请您放心上传。
                </div></div></form><?php endif; ?><span id="error"></span><input class="submit-btn" id="sub_extra" type="button" value="下一步"></div><div class="popup" id="weiscyyzz"><div class="popup-info upload-popup"><a class="popup-close" href="javascript:;"><i></i></a><div class="popup-img"><img src="/Public/img/upload_popup.png"/></div><p class="no-upload">未上传企业资料</p><p class="upload-tips">由于您使用的是个人邮箱，<br>所以必须认证企业资质后才可以开通招聘服务！</p><div class="upload-active"><button class="sub-btn keep-btn" onclick="$('#weiscyyzz').hide();$('#yyzz_id').attr('data-show',0);">返回</button><a class="sub-btn other-link" onclick="$('#weiscyyzz').hide();$('#comExtraForm').submit();">跳过</a></div></div></div><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>.2"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --></div><script src="/Public/js/member.js"></script></body></html>