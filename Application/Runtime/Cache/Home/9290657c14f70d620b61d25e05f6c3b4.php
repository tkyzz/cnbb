<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="description" content="金融机构实习，找菜鸟帮帮"><meta name="keys" content="实习,金融,学生"><title>菜鸟帮帮-企业基本信息</title><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script></head><body><div class="page company-page company-basic-info"><?php if($navclass == 'index'): ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/indexPage.css"><?php else: ?><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><?php endif; ?><div class="top"><div class="top-nav"><a href="/logout.html?return=/index.html"><img src="/public/img/cjn_logo.png"/></a><div class="other-nav"><ul class="my-nav"><li><a class="student-link" href="/logout.html">我是学生</a></li><li><span class="part-line">|</span></li><li class="my"><a class="app-download" href="/app.html"><i></i>App下载</a><!--                         <div class="app-code"><img src="/Public/img/app_download.jpg"/></div> --></li></ul></div></div></div><form id="createComForm" name="createComForm" method="post"><div class="logon-box"><div class="basic-title"><span class="title-cont">企业基本信息</span><span class="title-line"></span></div><div class="basic-item"><span class="basic-name">企业全称</span><input class="basic-cont" type="text" name="fullname" placeholder="请输入与公司营业执照一致的企业名称，如：财金通教育科技（上海）有限公司"/></div><div class="basic-item"><span class="basic-name">企业简称</span><input class="basic-cont" type="text" name="abbrname" placeholder="请输入企业简称，如：财金通。该简称用于向学生用户展示"/></div><div class="basic-item"><span class="basic-name">所属行业</span><div  class="basic-cont basic-choose"><select onchange="gertrade('org_trade',$(this).val())" name="trade"><option value="">一级行业</option><?php if(is_array($trades)): foreach($trades as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?></select></div><div class="basic-cont basic-choose"><select id="org_trade" name="subtrade"><option value="">二级行业</option></select></div></div><!--             <div class="basic-item"><span class="basic-name">企业性质</span><div class="basic-cont basic-choose"><select name="nature"><option value="">企业性质</option><?php if(is_array($company_type)): foreach($company_type as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?></select></div></div> --><div class="basic-item"><span class="basic-name">企业地址</span><div class="basic-cont addr-choose"><select onchange="getcity('org_city',$(this).val())" name="province"><option value="">省/直辖市</option><?php if(is_array($area)): foreach($area as $key=>$v): ?><option value="<?php echo ($v["code"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?></select></div><div class="basic-cont addr-choose"><select id="org_city" name="city"><option value="">市</option></select></div><input class="basic-cont addr-detail" type="text" name="addr" placeholder="请填写机构所在的详细地址"></div><div class="basic-item"><span class="basic-name">企业简介</span><textarea class="basic-cont js_org_intro" name="remark" placeholder="请输入企业简介，可包括：企业核心业务、企业文化、竞争优势、核心价值观等亮点，供学生参考了解。描述信息越详尽，合适简历投递也会越多噢~~"></textarea><div class="font-count"><span class="js_count">0/500</div></div><!--             <div class="basic-item highlight"><span class="basic-name">亮点标签</span><div class="highlight-tag"><?php if(is_array($tag_list)): foreach($tag_list as $key=>$v): ?><span class="sub-tag"><?php echo ($v["tag_name"]); ?></span><?php endforeach; endif; ?><div class="more-tag"><input class="tag-edit" type="text" placeholder="更多标签"/><a class="tag-add">+</a></div></div></div> --><div id="error"></div><!-- <input type="text" name="tags" value="" style="height:0.5px;width:0px;padding:0px;margin:0px;"> --><input class="submit-btn js_sub_orgcreate" type="button" value="下一步"/></div></form><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>.2"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --></div><script src="/Public/js/member.js?v=1.1"></script><script type="text/javascript">// //标签高亮
// $("body").delegate(".highlight-tag span","click",function(){
//     var spans = new Array();
//     if ($(this).hasClass('active')){
//         $(this).removeClass('active');
//     }else{
//         $(this).addClass('active');
//     }
//     //遍历
//     $('.sub-tag').each(function(i){
//         if($(this).hasClass('active') == true){
//             spans.push($(this).text())
//        } 
//     });
//    // console.log(spans);
//     str = spans.join('|');
//     $('[name="tags"]').val(str);   
// });

//计数
    $('.js_org_intro').keyup(function() {
        
        var value = $('.js_org_intro').val();
        if ($('.js_org_intro').val().length > 500) {
           $('.js_org_intro').val(value.substring(0,500));
        }else{
            $('.js_count').html("<span>"+value.length+"</span>/500");
        }
        
    });
// //标签添加
// $('.tag-add').click(function(){
//     var name = $('.tag-edit').val();
//      var spans = new Array();
//     if(name == "" ){
//         return false;
//     }
//     if(name.length >8){
//         layer.msg('标签不能超过八个字', {icon: 5});
//         return false;
//     }
//     //alert(name);
//     $('.highlight-tag .more-tag').before('<span class="sub-tag active">'+name+'</span>');
//     $('.tag-edit').val("");
//     //遍历
//     $('.sub-tag').each(function(i){
//         if($(this).hasClass('active') == true){
//             spans.push($(this).text())
//        } 
//     });
//    // console.log(spans);
//     str = spans.join('|');
//     $('[name="tags"]').val(str); 
// });
</script></body></html>