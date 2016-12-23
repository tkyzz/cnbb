<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script><meta charset="UTF-8"><title><?php echo ($co_detail["fullname"]); ?>-菜鸟帮帮-想去金融机构实习？上菜鸟帮帮！</title></head><body><!--     <link rel="stylesheet" type="text/css" href="??public.css,main.css,login.css,pikaday.css"> --><!--     <link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"> --><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><div class="top"><div class="top-nav"><a href="/index.html"><img src="/Public/img/cjn_logo.png"/></a><div class="menu"><a class="sub-menu index-menu <?php if($nav == 'index'): ?>active<?php endif; ?>" href="/index.html"></a><a class="sub-menu ds-menu <?php if($nav == 'post'): ?>active<?php endif; ?>" href="/postList.html"></a><?php if($_SESSION['member']['type']== 1): ?><a class="sub-menu jm-menu <?php if($nav == 'resume'): ?>active<?php endif; ?>" href="/resume/list.html"></a><?php else: ?><a class="sub-menu jm-menu" href="/login.html?return_url=<?php echo (return_url('/resume/list.html')); ?>"></a><?php endif; ?></div></div><?php if($_SESSION['member']['type']== 1): ?><div class="other-nav"><ul class="my-nav"><li><a class="my-message" href="/messages.html"><i></i>专属推荐<span class="new-tag js_recommend_num" <?php if(empty($_SESSION['message_num']['recommend'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li><a class="my-reply" href="/resume/myFeedback.html"><i></i>投递反馈<span class="new-tag js_feedmsg_num" <?php if(empty($_SESSION['message_num']['deliver'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li id="my" class="my"><span><i></i><?php if(empty($_SESSION['member']['nick_name'])): echo (substr_replace($_SESSION['member']['user_name'],'****',4,4)); else: echo ($_SESSION['member']['nick_name']); endif; ?></span><div id="myNav" class="my-top-nav"><a class="sub-nav" href="/resume/list.html">我的简历</a><a class="sub-nav" href="/resume/myFavorite.html">我的收藏</a><!-- <a class="sub-nav" href="/systemNotice.html">系统通知</a> --><a class="sub-nav" href="/userInfo/setting">账号设置</a><a class="sub-nav" href="/logout.html">退出</a></div></li><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php else: ?><div class="other-nav"><div class="logon"><a class="logon-item active" href="/login.html">登录</a><span>|</span><a class="logon-item" href="/register.html">注册</a></div><ul class="my-nav"><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php endif; ?></div><div class="profile-banner"><img src="/Public/img/profile_top.jpg"/><div class="profile-name"><div class="company-logo"><img src="<?php echo ($co_detail["b_logo_url"]); ?>"/></div><div class="name-url"><p class="company-name"><?php echo ($co_detail["fullname"]); ?></p><a class="company-url"><?php echo ($co_detail["website"]); ?></a></div></div></div><div class="post-info-box"><div class="content"><div class="block-share"><div class="post-share jiathis_style_32x32"><span>分享</span><a class="jiathis_button_tsina"></a><a class="jiathis_button_cqq"></a><a class="jiathis_button_weixin"></a><!-- <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a> --><!--                     <a class="share-item weixin" href=""><i></i></a><a class="share-item qq" href=""><i></i></a><a class="share-item xinlang" href=""><i></i></a><a class="share-item tieba" href=""><i></i></a> --></div></div></div><div class="my-detail"><div class="detail-top"><p class="part-title post-hot-title"><span>热招实习岗位</span></p><p class="part-title org-info-title"><span>公司介绍</span></p></div><div class="detail"><div class="sub-detail post-hot"><div class="post-tag post-condition"><div class="sub-condition"><span class="condition-name">岗位性质</span><div class="condition-info"><span class="condition-item selected jobsea active jqsx work_type" data-op="work_type" data-id="0">不限</span><span class="condition-item jobsea jqsx work_type" data-op="work_type" data-id="1">假期</span><span class="condition-item part-time jobsea jzsx work_type" data-op="work_type" data-id="2" id="aa">日常</span><div class="part-time-condition"  id="partTimeSelection"><span class="work-month">至少连续实习月数</span><span class="condition-item jobsea work_day selected" data-id="0" data-op="work_day">不限</span><div class="condition-item month-box"><span class="month-btn reduce jobsea" data-id="<?php echo ((isset($_GET['work_day']) && ($_GET['work_day'] !== ""))?($_GET['work_day']):0); ?>">-</span><span class="month duration_show"><?php echo ((isset($_GET['work_day']) && ($_GET['work_day'] !== ""))?($_GET['work_day']):1); ?>个月</span><span class="month-btn raise jobsea" data-id="<?php echo ((isset($_GET['work_day']) && ($_GET['work_day'] !== ""))?($_GET['work_day']):0); ?>">+</span></div></div></div></div><div class="sub-condition"><span class="condition-name">每周工作</span><div class="condition-info"><span class="condition-item selected jobsea week_day" data-op="week_day" data-id="0">不限</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="1">1天</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="2">2天</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="3">3天</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="4">4天</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="5">5天</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="6">6天</span><span class="condition-item jobsea week_day" data-op="week_day" data-id="7">7天</span></div></div></div><input type="hidden" name="" id="work_type" value="<?php echo ($_GET['work_type']); ?>"><input type="hidden" name="" id="week_day" value="<?php echo ($_GET['week_day']); ?>"><input type="hidden" name="" id="work_day" value="<?php echo ($_GET['work_day']); ?>"><div class="post-tag post-list-box"><?php if(is_array($res["posts"])): foreach($res["posts"] as $key=>$v): ?><div class="list-item"><div class="post-item"><div class="item-row"><a class="row-left post-name" href="/post/<?php echo (smartBase64($v["id"])); ?>.html" target="_blank"><span class="name-box"><?php echo ($v["name"]); ?></span><?php if(($v['esalary']) >= "1"): ?><span class="post-cost"><?php echo ($v['ssalary']); ?>-<?php echo ($v['esalary']); if($v['salary_unit'] == 0): ?>元/天<?php else: ?>元/月<?php endif; ?></span><?php else: ?><span class="post-cost"><?php if($v['ssalary'] <= 0): ?>面议<?php else: if($v['salary_unit'] == 0): echo ($v["ssalary"]); ?>元/天<?php else: echo ($v["ssalary"]); ?>元/月<?php endif; endif; ?></span><?php endif; ?></a><a class="row-right company-name" href="/post/company/<?php echo (smartBase64($v["org"]["id"])); ?>.html"><?php echo ($v["org"]["abbrname"]); ?></a></div><div class="item-row"><div class="row-left post-demand"><span class="sub-demand post-addr"><i></i><?php echo ($v["city_name"]); ?>-<?php if(!empty($v["zone_name"])): echo ($v["zone_name"]); else: ?>全市<?php endif; ?></span><span class="sub-demand degree"><i></i><?php echo (smartDegree($v["degree"])); ?></span></div><span class="row-right company-nature"><?php echo ($v["org"]["trade_name"]); ?>/<?php echo ($v["org"]["subtrade_name"]); ?></span></div><div class="item-row"><div class="row-left post-demand time"><span class="sub-demand post-time"><i></i><?php echo (smartWorkType($v["work_type"])); ?></span><span class="sub-demand demand-time"><i></i><?php if(!empty($v["work_days"])): echo ($v["work_days"]); ?>天/周<?php else: ?>不限<?php endif; ?></span></div><span class="row-right publish-date"><?php echo (smartJobStrTime($res["last_time"])); ?></span></div></div><a class="company-logo"><img src="<?php echo ($v["org"]["b_logo_url"]); ?>"/></a></div><?php endforeach; endif; ?></div></div><div class="sub-detail org-info"><p class="org-name">公司简介</p><div class="company-info"><div class="info-box"><div class="section"><?php echo ($co_detail["remark"]); ?></div><?php if(mb_strlen($co_detail['remark']) > 180): ?><a class="section-more" href="javascript:;">展开<i></i></a><?php endif; ?></div></div><p class="org-name">公司基本信息</p><ul class="org-basic"><li class="sub-basic industry"><i></i><?php echo ($co_detail["trade_name"]); ?></li><li class="sub-basic nature"><i></i><?php echo ($co_detail["nature_name"]); ?></li><li class="sub-basic scale"><i></i><?php echo ($co_detail["scale_name"]); ?></li><li class="sub-basic area"><i></i><?php echo ($co_detail["city_name"]); ?></li></ul><div class="org-others"><p class="others-title">福利标签</p><div class="company-welfare"><?php if(is_array($co_detail["tags"])): foreach($co_detail["tags"] as $key=>$v): ?><span class="sub-welfare"><?php echo ($v["tag_name"]); ?></span><?php endforeach; endif; ?></div></div></div></div></div></div><input type="hidden" name="org_id" id="org_id" value="<?php echo (smartBase64($co_detail["id"])); ?>"><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>.2"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --><script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script><script type="text/javascript"> $(function(){
  function getJobUrl()
{
  var url = '/post/company/'+$('#org_id').val()+'.html';
    var paramarr = new Array();
    if ($("#area").val()){
        paramarr.push("area="+$("#area").val());
    }
    if ($("#trade").val()){
        paramarr.push("trade="+$("#trade").val());
    }
    if ($("#work_type").val()){
        paramarr.push("work_type="+$("#work_type").val());
    }
    if ($("#week_day").val()){
        paramarr.push("week_day="+$("#week_day").val());
    }
    if ($("#natures").val()){
        paramarr.push("natures="+$("#natures").val());
    }
    if ($("#degrees").val()){
        paramarr.push("degrees="+$("#degrees").val());
    }
    if ($("#sort").val()){
        paramarr.push("sort="+$("#sort").val());
    }
    if ($("#keyword").val()){
        paramarr.push("keyword="+$("#keyword").val());
    }
    if ($("#work_day").val()){
        paramarr.push("work_day="+$("#work_day").val());
    }
    if (paramarr.length > 0){
        url = url+'?'+paramarr.join('&');
    }
    return url;
}

//初始化搜索条件单个
  function spsingekey(id){
    //alert(1);
      var str = $('#'+id).val();
      //alert(str);
      if (str.length==0){
        return false;
      }
      if(id=="work_day"){
        $('[data-op="work_day"]').eq(0).removeClass('selected');
      }else{
        $('.'+id).eq(0).removeClass('selected');
        $('.'+id+'[data-id='+str+']').addClass('selected').attr('data-type','cancel');
      }

  }

     spsingekey("work_type");
   spsingekey("week_day");
   spsingekey("work_day");
  // if ($('.jzsx').hasClass('active')){
  //   $('#partTimeSelection').show();
  // }
//加天数a
  $('.raise').click(function(){
    $('.duration_show').html("");
    var num = $(this).attr('data-id');
      num++;
      $("#work_day").val(num);
      $("#work_type").val(2);
      $('.duration_show').html(num+"个月");
      window.location.href = getJobUrl();
  });

  //减天数a
  $('.reduce').click(function(){
    var num = $(this).attr('data-id');
      num--;
      if (num <= 0){
        return false;
      }
      $("#work_day").val(num);
      $("#work_type").val(2);
      $('.duration_show').html("");
      $('.duration_show').html(num+"个月");
      window.location.href = getJobUrl();
  });

  $(".jobsea").click(function(){
        var id = $(this).attr('data-id');
        var op = $(this).attr('data-op');
        if ($(this).attr("data-id")=="0"){

            $("#"+op).val("");
            window.location.href = getJobUrl();
            return false;

        }else if ($(this).attr("data-type")=="cancel"){

          $(this).removeClass("active");
          $(this).removeAttr('data-type');
          arr.splice($.inArray(id,arr),1);
          $("#"+op).val(arr.join(","));
          window.location.href = getJobUrl();
          return false;

        }

        $("#"+op).val(id);
      
        
        window.location.href = getJobUrl();
        return false;

    });



 });


 </script></body></html>