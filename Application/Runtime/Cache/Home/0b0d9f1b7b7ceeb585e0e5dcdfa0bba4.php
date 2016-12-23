<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script><meta charset="UTF-8"><title>菜鸟帮帮-面试通知</title></head><body><!--     <link rel="stylesheet" type="text/css" href="??public.css,main.css,login.css,pikaday.css"> --><!--     <link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"> --><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><div class="top"><div class="top-nav"><a href="/index.html"><img src="/Public/img/cjn_logo.png"/></a><div class="menu"><a class="sub-menu index-menu <?php if($nav == 'index'): ?>active<?php endif; ?>" href="/index.html"></a><a class="sub-menu ds-menu <?php if($nav == 'post'): ?>active<?php endif; ?>" href="/postList.html"></a><?php if($_SESSION['member']['type']== 1): ?><a class="sub-menu jm-menu <?php if($nav == 'resume'): ?>active<?php endif; ?>" href="/resume/list.html"></a><?php else: ?><a class="sub-menu jm-menu" href="/login.html?return_url=<?php echo (return_url('/resume/list.html')); ?>"></a><?php endif; ?></div></div><?php if($_SESSION['member']['type']== 1): ?><div class="other-nav"><ul class="my-nav"><li><a class="my-message" href="/messages.html"><i></i>专属推荐<span class="new-tag js_recommend_num" <?php if(empty($_SESSION['message_num']['recommend'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li><a class="my-reply" href="/resume/myFeedback.html"><i></i>投递反馈<span class="new-tag js_feedmsg_num" <?php if(empty($_SESSION['message_num']['deliver'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li id="my" class="my"><span><i></i><?php if(empty($_SESSION['member']['nick_name'])): echo (substr_replace($_SESSION['member']['user_name'],'****',4,4)); else: echo ($_SESSION['member']['nick_name']); endif; ?></span><div id="myNav" class="my-top-nav"><a class="sub-nav" href="/resume/list.html">我的简历</a><a class="sub-nav" href="/resume/myFavorite.html">我的收藏</a><!-- <a class="sub-nav" href="/systemNotice.html">系统通知</a> --><a class="sub-nav" href="/userInfo/setting">账号设置</a><a class="sub-nav" href="/logout.html">退出</a></div></li><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php else: ?><div class="other-nav"><div class="logon"><a class="logon-item active" href="/login.html">登录</a><span>|</span><a class="logon-item" href="/register.html">注册</a></div><ul class="my-nav"><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php endif; ?></div><div class="profile-banner"><img src="/Public/img/profile_top.jpg"/></div><div class="my-info-box"><div class="content"><div class="profile-block"><a class="block-info profile-notice" href="/resume/myNotice.html"><span <?php if($nav == notice): ?>class="active"<?php endif; ?>><i></i>面试通知<span class="new-tag notice-tag" <?php if(empty($_SESSION['message_num']['notice'])): ?>style="display:none;"<?php endif; ?>><?php echo ($_SESSION['message_num']['notice']); ?></span></notempty></span></a><a class="block-info profile-reply" href="/resume/myFeedback.html"><span <?php if($nav == feed): ?>class="active"<?php endif; ?>><i></i>投递反馈<span class="new-tag js_feedmsg_num" <?php if(empty($_SESSION['message_num']['deliver'])): ?>style="display:none;"<?php endif; ?>></span></span></a><a class="block-info profile-favorites" href="/resume/myFavorite.html"><span <?php if($nav == favorite): ?>class="active"<?php endif; ?>><i></i>我的收藏</span></a><a class="block-info profile-list" href="/resume/list.html"><span <?php if($nav == resume): ?>class="active"<?php endif; ?>><i></i>我的简历</span></a><a class="block-info profile-post" href="/messages.html"><span <?php if($nav == message): ?>class="active"<?php endif; ?>><i></i>专属推荐<span class="new-tag js_recommend_num" <?php if(empty($_SESSION['message_num']['recommend'])): ?>style="display:none;"<?php endif; ?>></span></span></a></div><!--<p class="block-title">面试通知</p>--></div><div class="my-detail"><?php if(is_array($res)): foreach($res as $key=>$v): ?><div class="detail my-notice"><a class="from-info" href="companyProfile.html"><div class="avatar"><img src="<?php echo ($v["org"]["b_logo_url"]); ?>"/></div><span class="from-name"><?php echo ($v["org"]["abbrname"]); ?></span></a><div class="notice-info"><!-- 面试提醒 --><?php if($v['msg_count'] >= 4): ?><div class="notice-item <?php if($v['messages'][3]['interview_message']['is_end'] == 0): ?>new-notice<?php endif; ?>"><p class="notice-title <?php if($v['msg_count'] == 4): ?>notice-up<?php endif; ?>"><span class="notice-post">【面试提醒】<a class="from" href="/post/<?php echo (smartBase64($v["post"]["id"])); ?>.html" target="_blank"><?php echo ($v["post"]["name"]); ?></a><!--<i class="notice-icon"></i>--></span><span class="time"><?php echo (smartTimeFormat($v["messages"]["3"]["post_time"])); ?></span><i class="up-down"></i></p><div class="notice-cont"><p class="interview-cont"><?php echo ($v["messages"]["content"]); ?></p></p></div></div><?php endif; ?><!-- 再次改期 --><?php if($v['msg_count'] >= 3): ?><div class="notice-item <?php if($v['messages'][2]['interview_message']['is_end'] == 0): ?>new-notice<?php endif; ?>"><p class="notice-title <?php if($v['msg_count'] == 3): ?>notice-up<?php endif; ?>"><span class="notice-post">【面试改期】<a class="from" href="/post/<?php echo (smartBase64($v["post"]["id"])); ?>.html" target="_blank"><?php echo ($v["post"]["name"]); ?></a><!--<i class="notice-icon"></i>--></span><span class="time"><?php echo (smartTimeFormat($v["messages"]["2"]["post_time"])); ?></span><i class="up-down"></i></p><div class="notice-cont"><p class="interview-cont"><?php echo ($v["messages"]["0"]["content"]); ?></p><p class="interview-info">面试时间：<span><?php echo (smartTimeFormat($v["messages"]["0"]["interview_message"]["interview_time"])); ?></span></p><p class="interview-info">面试地点：<span><?php echo ($v["messages"]["0"]["interview_message"]["address"]); ?></span></p><p class="interview-info">面试要求：<span><?php echo ($v["messages"]["0"]["interview_message"]["claim"]); ?></span></p><p class="interview-info info-tel">联系电话：<span><?php echo ($v["messages"]["0"]["interview_message"]["phone"]); ?></span></p><?php if(is_array($v["messages"]["1"]["interview_message"]["event_items"])): foreach($v["messages"]["1"]["interview_message"]["event_items"] as $key=>$val): if($v['messages'][1]['interview_message']['selected_event_id'] == $val['event_id']): ?><p class="reply-warn">                                面试时间更改为：<span><?php echo (str_replace('/','.',$val["value"])); ?></span></p><?php endif; endforeach; endif; if($v['messages'][2]['interview_message']['selected_event_item_type'] == 0): ?><div class="notice-btn"><a class="sure" href="javascript:;" data-id="<?php echo ($v["messages"]["2"]["id"]); ?>" data-eventid="<?php echo ($v["messages"]["2"]["interview_message"]["event_items"]["0"]["event_id"]); ?>">参加</a><a class="resign" href="javascript:;" data-id="<?php echo ($v["messages"]["2"]["id"]); ?>" data-eventid="<?php echo ($v["messages"]["2"]["interview_message"]["event_items"]["1"]["event_id"]); ?>">放弃</a></div><?php elseif($v['messages'][2]['interview_message']['selected_event_item_type'] == 2): ?><div class="results results-sure"><p class="profile-results"><span class="last-results">你已确认参加面试</span></p><div class="last-reply"><img src="/Public/img/company_sure.png"/></div></div><?php elseif($v['messages'][2]['interview_message']['selected_event_item_type'] == 3): ?><div class="results results-resign"><p class="profile-results"><span class="last-results">你已放弃面试机会</span></p><div class="last-reply"><img src="/Public/img/resign.png"/></div></div><?php endif; ?></div></div><?php endif; ?><!-- 改期 --><?php if($v['msg_count'] >= 2): ?><div class="notice-item <?php if($v['messages'][1]['interview_message']['is_end'] == 0): ?>new-notice<?php endif; ?>"><p class="notice-title <?php if($v['msg_count'] == 2): ?>notice-up<?php endif; ?>"><span class="notice-post">【面试改期】<a class="from" href="/post/<?php echo (smartBase64($v["post"]["id"])); ?>.html" target="_blank"><?php echo ($v["post"]["name"]); ?></a><!--<i class="notice-icon"></i>--></span><span class="time"><?php echo (smartTimeFormat($v["messages"]["1"]["post_time"])); ?></span><i class="up-down"></i></p><div class="notice-cont"><p class="interview-cont"><?php echo ($v["messages"]["0"]["content"]); ?></p><p class="interview-info">面试时间：<span><?php echo (smartTimeFormat($v["messages"]["0"]["interview_message"]["interview_time"])); ?></span></p><p class="interview-info">面试地点：<span><?php echo ($v["messages"]["0"]["interview_message"]["address"]); ?></span></p><p class="interview-info">面试要求：<span><?php echo ($v["messages"]["0"]["interview_message"]["claim"]); ?></span></p><p class="interview-info">联系电话：<span><?php echo ($v["messages"]["0"]["interview_message"]["phone"]); ?></span></p><?php if($v['messages'][1]['interview_message']['is_end'] == 0): ?><p class="profile-results">                                面试时间更改为：<span><?php echo (smartTimeFormat($v['messages'][1]['interview_message']['interview_time'])); ?></span>，等待企业确认。
                            </p><?php else: ?><p class="profile-results">                                面试时间更改为：<span><?php echo (smartTimeFormat($v['messages'][1]['interview_message']['interview_time'])); ?></span><span class="last-results">你已确认参加面试</span></p><?php endif; if($v['messages'][1]['interview_message']['is_end'] == 1): ?><div class="last-reply"><img src="/Public/img/company_sure.png"/></div><?php endif; ?></div></div><?php endif; ?><!-- 面试通知 --><?php if($v['msg_count'] >= 1): ?><div class="notice-item <?php if($v['messages'][0]['interview_message']['is_end'] == 0): ?>new-notice<?php endif; ?>"><p class="notice-title <?php if($v['msg_count'] == 1): ?>notice-up<?php endif; ?>"><span class="notice-post">【面试通知】<a class="from" href="/post/<?php echo (smartBase64($v["post"]["id"])); ?>.html" target="_blank"><?php echo ($v["post"]["name"]); ?></a><!--<i class="notice-icon"></i>--></span><span class="time"><?php echo (smartTimeFormat($v["messages"]["0"]["post_time"])); ?></span><i class="up-down"></i></p><div class="notice-cont"><p class="interview-cont"><?php echo ($v["messages"]["0"]["content"]); ?></p><p class="interview-info">面试时间：<span><?php echo (smartTimeFormat($v["messages"]["0"]["interview_message"]["interview_time"])); ?></span></p><p class="interview-info">面试地点：<span><?php echo ($v["messages"]["0"]["interview_message"]["address"]); ?></span></p><p class="interview-info">面试要求：<span><?php echo ($v["messages"]["0"]["interview_message"]["claim"]); ?></span></p><p class="interview-info">联系电话：<span><?php echo ($v["messages"]["0"]["interview_message"]["phone"]); ?></span></p><?php if($v['messages'][0]['interview_message']['is_end'] == 0): ?><p class="reply-warn">                               请于<span class="reply-time"><?php echo (smartTimeFormat($v["messages"]["0"]["interview_message"]["last_reply_time"])); ?></span>前回复本通知
                               <!--无面试备选时间的change-tips不显示--><?php if($v['messages'][0]['interview_message']['event_items'][2]['value']): ?><span class="change-tips">，如需改期请点击<a class="reply-change" href="javascript:;">【改期】</a></span><?php endif; ?></p><?php endif; if($v['messages'][0]['interview_message']['event_items'][2]['value']): ?><div class="reply-info" style="display:none;"><p>我希望的面试时间</p><?php if($v['messages'][0]['interview_message']['event_items'][2]['value']): ?><div class="sub-reply"><input id="reply<?php echo (substr($v["messages"]["0"]["interview_message"]["event_items"]["2"]["event_id"],0,2)); ?>" type="radio" name="reply" value="<?php echo ($v["messages"]["0"]["interview_message"]["event_items"]["2"]["event_id"]); ?>"/><label for="reply<?php echo (substr($v["messages"]["0"]["interview_message"]["event_items"]["2"]["event_id"],0,2)); ?>"><?php echo ($v["messages"]["0"]["interview_message"]["event_items"]["2"]["value"]); ?></label></div><?php endif; if($v['messages'][0]['interview_message']['event_items'][3]['value']): ?><div class="sub-reply"><input id="reply<?php echo (substr($v["messages"]["0"]["interview_message"]["event_items"]["3"]["event_id"],0,2)); ?>" type="radio" name="reply" value="<?php echo ($v["messages"]["0"]["interview_message"]["event_items"]["3"]["event_id"]); ?>"/><label for="reply<?php echo (substr($v["messages"]["0"]["interview_message"]["event_items"]["3"]["event_id"],0,2)); ?>"><?php echo ($v["messages"]["0"]["interview_message"]["event_items"]["3"]["value"]); ?></label></div><?php endif; ?></div><?php endif; if($v['messages'][0]['interview_message']['selected_event_item_type'] == 0): ?><div class="notice-btn"><a class="sure" href="javascript:;" data-id="<?php echo ($v["messages"]["0"]["id"]); ?>" data-eventid="<?php echo ($v["messages"]["0"]["interview_message"]["event_items"]["0"]["event_id"]); ?>">参加</a><a class="resign" href="javascript:;" data-id="<?php echo ($v["messages"]["0"]["id"]); ?>" data-eventid="<?php echo ($v["messages"]["0"]["interview_message"]["event_items"]["1"]["event_id"]); ?>">放弃</a></div><?php elseif($v['messages'][0]['interview_message']['selected_event_item_type'] == 2): ?><div class="results results-sure"><p class="profile-results"><span class="last-results">你已确认参加面试</span></p><div class="last-reply"><img src="/Public/img/company_sure.png"/></div></div><?php elseif($v['messages'][0]['interview_message']['selected_event_item_type'] == 3): ?><div class="results results-resign" ><p class="profile-results"><span class="last-results">你已放弃面试机会</span></p><div class="last-reply"><img src="/Public/img/resign.png"/></div></div><?php elseif($v['messages'][0]['interview_message']['selected_event_item_type'] == 4): ?><div class="results results-sure"><p class="profile-results"><span class="last-results">你已改期</span></p><div class="last-reply"><img src="/Public/img/company_sure.png"/></div></div><?php endif; ?></div></div><?php endif; ?></div></div><?php endforeach; endif; ?><!-- 分页--><!--             <div class="paging"><span class="page-up" id="pageUp"><i></i></span><div class="page-list" id="pageGroup"><span class="active">1</span><span>2</span><span>3</span><span>4</span><span>5</span></div><span class="page-down" id="pageDown"><i></i></span></div> --></div></div><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --><script type="text/javascript">//    myNotice reply-change
    $(".my-notice").each(function () {
        $(this).find(".reply-change").click(function () {
            if ($(this).text()=="【改期】"){
                $(this).parent().parent().next(".reply-info").show();
                $(this).text("【取消改期】");
            }else {
                $(this).parent().parent().next(".reply-info").find("input").removeAttr("checked");
                $(this).parent().parent().next(".reply-info").hide();
                $(this).text("【改期】");
            }
        });

        //    myNotice notice-cont show/hide
        $(this).find(".up-down").click(function () {
            $(this).parent().toggleClass("notice-up");
            $(this).parent().next(".notice-cont").toggle();
        });

    //    myNotice results
    //同意/改期
        $(this).find(".notice-btn .sure").click(function () {
            var val = $(this).parent().parent().find(".sub-reply").children("input:radio:checked").val();
            var id= $(this).attr('data-id');
            var event_id = $(this).attr('data-eventid');
            if(event_id !=""){
                if (typeof(val)!="undefined"){
                    event_id = val;

                }
                $.post("/ajax/messageReply",{id:id,event_id:event_id},
                          function(data){
                             if (data.status==1) {
                            $(this).parent().hide();
                            $(this).parent().parent().find(".results.results-sure").show();
                            window.location.reload();
                                } else {
                                    alert(data.msg);
                                   window.location.reload();
                                }
                              },
                          "json");
             }else{
                return;
             }
        });


$('.results.results-sure').show();
        //拒绝
        $(this).find(".notice-btn .resign").click(function () {
            var id= $(this).attr('data-id');
            var event_id = $(this).attr('data-eventid');
        $.post("/ajax/messageReply",{id:id,event_id:event_id},
                  function(data){
                     if (data.status==1) {
                $(this).parent().hide();
                $(this).parent().parent().find(".results.results-resign").show();
                 window.location.reload();
                        } else {
                             window.location.reload();
                        }
                      },
                  "json");
        })

    });
 </script></body></html>