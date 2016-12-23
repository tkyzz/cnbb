<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>菜鸟帮帮-企业登录</title><meta name="description" content="菜鸟帮帮是国内领先的金融实习生招聘平台,500强实习,优质实习机会,优秀实习生,找实习就上菜鸟帮帮,实习生招聘首选菜鸟帮帮,大学生金融实习第一品牌。"><meta name="keywords" content="实习,实习生,找实习,实习生招聘,寒假实习,菜鸟帮帮,大学生实习,实习网,实习吧"><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script></head><body><?php if($navclass == 'index'): ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/indexPage.css"><?php else: ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><?php endif; ?><div class="top"><div class="top-nav"><a href="/logout.html?return=/index.html"><img src="/public/img/cjn_logo.png"/></a><div class="other-nav"><ul class="my-nav"><li><a class="student-link" href="/logout.html">我是学生</a></li><li><span class="part-line">|</span></li><li class="my"><a class="app-download" href="/app.html"><i></i>App下载</a><!--                         <div class="app-code"><img src="/Public/img/app_download.jpg"/></div> --></li></ul></div></div></div><div class="org-logon"><div class="logon-info"><div class="slogan"><img src="/Public/img/orgImg/company_sign_text.png"/><a class="register-link" href=""><img src="/Public/img/orgImg/register.png"/></a></div><div class="logon-box"><div class="tab-menu"><span class="sub-menu phone_reg active">手机号注册</span><span class="sub-menu email_reg">邮箱注册</span></div><div class="tab-cont"><div class="tab-item"><div class="input-item phone"><i></i><div class="input-box"><input id="register_phone" type="text" placeholder="请输入手机号" /></div></div><div class="input-item password"><i></i><div class="input-box"><input id="register_password" type="password" placeholder="请输入密码" maxlength="18"/></div></div><div class="input-item sms-code"><i></i><div class="input-box code-box"><input id="verify_code" type="text" maxlength="4" placeholder="请输入验证码" /><div class="code-img"><img alt="验证码" src="/verifyImg.html" class="js_verifyImg" title="点击刷新"></div></div></div><div class="input-item sms-code"><i></i><div class="input-box code-box"><input id="smsCode" type="text" placeholder="请输入短信验证码" /><input class="send-sms js_comsend_phone_code" type="button" data-id="1" data-type="register" value="获取验证码"></div></div><div class="btn"><input class="sub-btn login-btn js_org_register" type="button" value="注册菜鸟帮帮"></div><!--<div class="btn"><input class="sub-btn login-btn" type="button" value="登录中…" disabled></div>--><div class="other-way"><a href="/hrLogin.html">已有账号？<span>立即登录</span></a></div></div><div class="tab-item"><div class="input-item email"><i></i><div class="input-box"><input id="register_email" type="text" placeholder="请输入邮箱" /></div></div><p class="input-tips">用企业邮箱注册无需审核可直接发布岗位</p><div class="input-item password"><i></i><div class="input-box"><input id="register_pwd" type="password" placeholder="请输入密码" maxlength="18" /></div></div><div class="input-item sms-code"><i></i><div class="input-box code-box"><input id="verify_email_code" type="text" placeholder="请输入验证码" maxlength="4"/><div class="code-img"><img alt="验证码" src="/verifyImg.html" class="js_verifyImg" title="点击刷新"></div></div></div><div class="btn"><input class="sub-btn login-btn js_org_email_register" type="button" value="注册菜鸟帮帮"></div><!--<div class="btn"><input class="sub-btn login-btn" type="button" value="登录中…" disabled></div>--><div class="other-way"><a href="/hrLogin.html">已有账号？<span>立即登录</span></a></div></div></div></div></div></div><div class="pro-info"><div class="pro-ad"><div class="pro-item"><p class="ad-key">海量、精准</p><div class="ad-img"><img src="/Public/img/orgImg/ad1.png"/></div><div class="ad-detail">                    千所高校，数十万名学生<br>                    指定高校简历推荐服务<br>                    助您锁定心仪优秀人才
                </div></div><div class="pro-item"><p class="ad-key">高效、智能</p><div class="ad-img"><img src="/Public/img/orgImg/ad2.png"/></div><div class="ad-detail">                    面试通知进度管理功能<br>                    学生面试承诺到场服务<br>                    让您轻松搞定实习招聘
                </div></div><div class="pro-item"><p class="ad-key">专属、陪伴</p><div class="ad-img"><img src="/Public/img/orgImg/ad3.png"/></div><div class="ad-detail">                    一对一专属招聘顾问服务<br>                    7×24小时全天候客服待命<br>                    给您随时随心的管家服务
                </div></div><!--<a class="more-view" href="">点击了解企业版产品详情<i></i></a>--></div></div><div class="pro-info pro-school"><div class="pro-ad"><div class="school-img"><img src="/Public/img/orgImg/school_img.jpg"/></div><p class="ad-text">这些高校学生都来菜鸟帮帮找实习机会，你还不赶快下手？</p><a class="more-view" href="">现在注册即送专业版用户权限<i></i></a></div></div><div class="pro-info pro-cooperation"><div class="pro-ad"><div class="cooperation-title"><img src="/Public/img/orgImg/gxhz_title.png"/></div><div class="pro-item"><div class="item-img"><img src="/Public/img/orgImg/gxhz1.png"/></div><div class="item-info">                    超<span>10</span>万名学生简历注册
                </div></div><div class="pro-item"><div class="item-img"><img src="/Public/img/orgImg/gxhz2.png"/></div><div class="item-info"><span>3000</span>多个实习岗位人才对接成功
                </div></div><div class="pro-item"><div class="item-img"><img src="/Public/img/orgImg/gxhz3.png"/></div><div class="item-info"><span>500</span>多所高校实习基地签约
                </div></div><div class="pro-item"><div class="item-img"><img src="/Public/img/orgImg/gxhz4.png"/></div><div class="item-info">                    连续3年发布《金融基础人才供需调研报告》，被上海政府官网全文转载，呈交上海市委书记韩正。
                </div></div><div class="pro-item"><div class="item-img"><img src="/Public/img/orgImg/gxhz5.png"/></div><div class="item-info"><span>200</span>多场高校职业发展巡回讲座
                </div></div><a class="more-view" href="">现在注册即送专业版用户权限<i></i></a></div></div><input type="hidden" id="sendcodetime" value="180"/><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>.2"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --><script src="/Public/js/member.js"></script><script>//$(function(){
      //     $("body").keydown(function(e){ 
      //     var curKey = e.which; 
      //     var str = $('#search').val();
      //     if(curKey == 13 && str){ 
      //     $(".keyword").click(); 
      //     return false; 
      //     }
      // }); 


            $("body").keydown(function(e){ 
               var str = $('[type="password"]').val();
               str = str.substr(str.length-1,1);
               if(str >= 'A' && str <= 'Z'){
                  layer.tips('大小写锁定已打开', '#register_password',{time:0});
               }else{
                  layer.closeAll('tips');
               }
              
          }); 

//             var str = $(this).val();
//             alert(str.substr(str.length-1,1));
//           var keyCode = e.which; 
//           console.log(keyCode);
//          // var str = $('#search').val();
//             if (  keyCode ==20 ) // CapsLock打开，且没有按住shift键。 )// CapsLock打开，且按住shift键。  
//               {

//                 $("p").hover(function(){
//                      layer.tips('Hi，我是tips', '#register_password');
//                 },function(){
//                     $("p").css("background-color","pink");
//                 });
// }
//         }); 

  
// });
</script></body></html>