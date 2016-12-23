<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>菜鸟帮帮-个人中心</title><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><?php if($js == 'new'): ?><script src="/Public/js/jquery.min.js"></script><?php else: ?><script src="/Public/js/jquery-1.8.3.min.js"></script><?php endif; ?><script src="/Public/js/layer/layer.js"></script><script type="text/javascript">    //百度统计

    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();

    //网站客服
    <?php if($browser[0] != 'Internet Explorer'): ?>document.write('<script src="\/\/assets.kf5.com\/supportbox\/main.js?' + (new Date).getDay() + '" id="kf5-provide-supportBox" kf5-domain="cainiaobangbang.kf5.com" charset="utf-8"><\/script>');<?php endif; ?></script><script type="text/javascript" src="/Public/js/selectivizr.js"></script></head><body><!--     <link rel="stylesheet" type="text/css" href="??public.css,main.css,login.css,pikaday.css"> --><!--     <link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"> --><link rel="stylesheet" type="text/css" href="/Public/css/public.css"><link rel="stylesheet" type="text/css" href="/Public/css/main.css"><link rel="stylesheet" type="text/css" href="/Public/css/login.css"><link rel="stylesheet" type="text/css" href="/Public/css/pikaday.css"><div class="top"><div class="top-nav"><a href="/index.html"><img src="/Public/img/cjn_logo.png"/></a><div class="menu"><a class="sub-menu index-menu <?php if($nav == 'index'): ?>active<?php endif; ?>" href="/index.html"></a><a class="sub-menu ds-menu <?php if($nav == 'post'): ?>active<?php endif; ?>" href="/postList.html"></a><?php if($_SESSION['member']['type']== 1): ?><a class="sub-menu jm-menu <?php if($nav == 'resume'): ?>active<?php endif; ?>" href="/resume/list.html"></a><?php else: ?><a class="sub-menu jm-menu" href="/login.html?return_url=<?php echo (return_url('/resume/list.html')); ?>"></a><?php endif; ?></div></div><?php if($_SESSION['member']['type']== 1): ?><div class="other-nav"><ul class="my-nav"><li><a class="my-message" href="/messages.html"><i></i>专属推荐<span class="new-tag js_recommend_num" <?php if(empty($_SESSION['message_num']['recommend'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li><a class="my-reply" href="/resume/myFeedback.html"><i></i>投递反馈<span class="new-tag js_feedmsg_num" <?php if(empty($_SESSION['message_num']['deliver'])): ?>style="display:none;"<?php endif; ?>></span></a></li><li id="my" class="my"><span><i></i><?php if(empty($_SESSION['member']['nick_name'])): echo (substr_replace($_SESSION['member']['user_name'],'****',4,4)); else: echo ($_SESSION['member']['nick_name']); endif; ?></span><div id="myNav" class="my-top-nav"><a class="sub-nav" href="/resume/list.html">我的简历</a><a class="sub-nav" href="/resume/myFavorite.html">我的收藏</a><!-- <a class="sub-nav" href="/systemNotice.html">系统通知</a> --><a class="sub-nav" href="/userInfo/setting">账号设置</a><a class="sub-nav" href="/logout.html">退出</a></div></li><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php else: ?><div class="other-nav"><div class="logon"><a class="logon-item active" href="/login.html">登录</a><span>|</span><a class="logon-item" href="/register.html">注册</a></div><ul class="my-nav"><li class="my"><a class="app-download" href="/app.html" target="_blank"><i></i>App下载</a><!--                     <div class="app-code"><img src="/public/img/app_download.jpg"/></div> --></li></ul><a class="pr-login" href="/hrLogin.html"><i></i>我是企业HR</a></div><?php endif; ?></div><div class="profile-banner"><img src="/Public/img/profile_top.jpg"/></div><div class="my-info-box"><div class="content"><div class="profile-block"><a class="block-info profile-notice" href="/resume/myNotice.html"><span <?php if($nav == notice): ?>class="active"<?php endif; ?>><i></i>面试通知<span class="new-tag notice-tag" <?php if(empty($_SESSION['message_num']['notice'])): ?>style="display:none;"<?php endif; ?>><?php echo ($_SESSION['message_num']['notice']); ?></span></notempty></span></a><a class="block-info profile-reply" href="/resume/myFeedback.html"><span <?php if($nav == feed): ?>class="active"<?php endif; ?>><i></i>投递反馈<span class="new-tag js_feedmsg_num" <?php if(empty($_SESSION['message_num']['deliver'])): ?>style="display:none;"<?php endif; ?>></span></span></a><a class="block-info profile-favorites" href="/resume/myFavorite.html"><span <?php if($nav == favorite): ?>class="active"<?php endif; ?>><i></i>我的收藏</span></a><a class="block-info profile-list" href="/resume/list.html"><span <?php if($nav == resume): ?>class="active"<?php endif; ?>><i></i>我的简历</span></a><a class="block-info profile-post" href="/messages.html"><span <?php if($nav == message): ?>class="active"<?php endif; ?>><i></i>专属推荐<span class="new-tag js_recommend_num" <?php if(empty($_SESSION['message_num']['recommend'])): ?>style="display:none;"<?php endif; ?>></span></span></a></div></div><div class="my-detail" id="zzz"><div class="batch-operation"><span class="batch-choose js_pl_op"></span><button class="operation-item js_pl_deliver">批量投递</button><button class="operation-item js_pl_del">批量删除</button></div><div class="detail my-favorite"><input type="hidden" name="default_id" value="<?php echo ($resume_default_id); ?>"><?php if(is_array($res["posts"])): foreach($res["posts"] as $key=>$v): ?><div class="favorite-item msg-item js_list_<?php echo ($v["id"]); ?>"><div class="batch-choose js_ie_batchchoose"><input id="batch<?php echo ($v["id"]); ?>" name="jobcheck" type="checkbox" data-id="<?php echo ($v["id"]); ?>" data-postid="<?php echo ($v["post"]["id"]); ?>"/><label for="batch<?php echo ($v["id"]); ?>" class="jobcheck_lab"></label></div><a class="avatar" href=""><img src="<?php echo ($v["post"]["org"]["b_logo_url"]); ?>"/></a><div class="favorite-info"><div class="post-info"><div class="post-basic"><a class="post-name" href="/post/<?php echo (smartBase64($v["post"]["id"])); ?>.html" target="_blank"><?php echo ($v["post"]["name"]); ?></a><?php if(($v['post']['esalary']) >= "1"): ?><span class="post-pay"><?php echo ($v['post']['ssalary']); ?>-<?php echo ($v['post']['esalary']); if($v['post']['salary_unit'] == 0): ?>元/天<?php else: ?>元/月<?php endif; ?></span><?php else: ?><span class="post-pay"><?php if($v['post']['ssalary'] <= 0): ?>面议<?php else: if($v['post']['salary_unit'] == 0): echo ($v["post"]["ssalary"]); ?>元/天<?php else: echo ($v["post"]["ssalary"]); ?>元/月<?php endif; endif; ?></span><?php endif; ?></div><div class="post-demand"><span class="publish-company"><?php echo ($v["post"]["org"]["abbrname"]); ?></span><span class="sub-demand post-addr"><i></i><?php echo ($v["post"]["city_name"]); ?></span><span class="sub-demand degree"><i></i><?php echo (smartDegree($v["post"]["degree"])); ?></span></div><div class="post-demand"><span class="sub-demand post-time"><i></i><?php echo (smartWorkType($v["post"]["work_type"])); ?></span><?php if(!empty($v["post"]["work_days"])): ?><span class="sub-demand demand-time"><i></i><?php echo ($v["post"]["work_days"]); ?>天/周</span><?php endif; ?></div></div><div class="post-active"><p class="publish-time">推送时间：<span><?php echo (smartJobStrTime($v["fav_time"])); ?></span></p><div class="active"><?php if($v["state"] == 1): ?><button class="active-btn resume" disabled>已投递<span></span></button><?php else: ?><button class="active-btn resume js_singletd" data-id="<?php echo ($v["post"]["id"]); ?>">一键投递<span></span></button><?php endif; ?><button class="active-btn undo-favorite js_singledel" data-id="<?php echo ($v["id"]); ?>" href="javascript:;">我不喜欢<span></span></button></div></div></div></div><?php endforeach; endif; ?></div><div class="tcdPageCode" <?php if($res['pageCount'] <= 1): ?>style="display:none;"<?php endif; ?>></div></div></div><!-- <a class="my-advice" href=""><i></i><span>我的建议</span></a> --><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><!--         <div class="bottom-ad"><a class="ad-img" href="/activity.html" target="_blank"><img src="/Public/img/bottom_ad.png"/></a></div> --><?php endif; ?><div class="footer"><!--登录注册及密码重置验证页面使用--><?php if($navclass == 'index' || $navclass == 'post' || $navclass == 'student' || $navclass == 'about'): ?><img src="/Public/img/cjn_logo_bottom2.png"/><?php elseif($navclass == 'user'||$navclass == 'company'): ?><!--其他页面使用--><img src="/Public/img/cjn_logo_bottom.png"/><?php endif; ?><div class="bottom-nav"><a class="sub-bottom-nav" href="/about/aboutUs.html">关于我们</a><!--  <a class="sub-bottom-nav" href="/team.html">管理团队</a> --><a class="sub-bottom-nav" href="/about/mileStone.html">大事记</a><a class="sub-bottom-nav" href="/about/ourPartner.html">合作伙伴</a><a class="sub-bottom-nav" href="/about/joinUs.html">招贤纳士</a><a class="sub-bottom-nav" href="/about/contactUs.html">联系我们</a><p class="icp"><a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备15055517号</a> @2016 cainiaobangbang.com All rights reserved</p></div><div class="code"><span class="code-nav"><img src="/Public/img/28x28.png">App下载</span><div class="app-code"><img src="/public/img/app_download.jpg"/></div></div></div></div><script src="/Public/js/style.js?<?php echo date("Ymd");?>"></script><?php if($navclass == index): ?><script src="/Public/js/slides.jquery.js?<?php echo date("Ymd");?>"></script><?php elseif($navclass == post): ?><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"><?php else: ?><script src="/Public/js/jquery.lazyload.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/common.js?<?php echo date("Ymd");?>"></script><script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script><?php endif; ?><!-- Start of KF5 supportbox script --><script type="text/javascript">  // $(function () {
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
</script><!-- End of KF5 supportbox script --><?php if(!empty($is_show)): ?><div class="popup" id="intention_tip" style="display: block"><div class="popup-info will-popup"><a class="popup-close" href="javascript:;"><i class="js_close_intention_tip"></i></a><div class="popup-img"><img src="/Public/img/will_tips.png"/></div><p class="no-will">您还未填写<span>实习意向</span>哦~</p><p class="will-tips">完善的实习意向，才能接收到最精准的推荐岗位哦~</p><a class="will-btn" href="/resume/list.html?show=1">现在就去填</a></div></div><script type="text/javascript">		//关闭弹框
		$('.js_close_intention_tip').click(function(){
		    $('#intention_tip').hide();
		   $.get("/ajax/setclose",{name:'intention_tip'},
		      function(data){

		          },
		  "json"); 
		});
    </script><?php endif; ?><!--删除推荐岗位弹层--><div class="popup" id="js_del_tip"><div class="popup-info msg-popup"><div class="popup-img"><img src="/Public/img/msg_delPost.png"/></div><p class="popup-hint">删除选中岗位吗？</p><div class="popup-btn"><button class="sub-btn sure js_qddel">是</button><button class="sub-btn" onclick="$('#js_del_tip').hide();">否</button></div></div></div><!--投递推荐选中岗位提示弹层--><div class="popup" id="js_deliver_tip"><div class="popup-info msg-popup"><div class="popup-img"><img src="/Public/img/msg_mailPost.png"/></div><p class="popup-hint">投递选中岗位吗？</p><div class="popup-btn"><button class="sub-btn sure js_qdtd" data-op="singletd">是</button><button class="sub-btn" onclick="$('#js_deliver_tip').hide();">否</button></div></div></div></body><script src="/Public/js/jquery.page.js"></script><script src="/Public/js/myCenter.js"></script><script>
$(function(){

    //分页
    $(".tcdPageCode").createPage({
    pageCount:<?php echo ($res["pageCount"]); ?>,
    current:<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>,
    backFn:function(p){
        if(p <= 1){
            var url = '/messages.html#zzz';
        }else{
            var url = '/messages.html?p='+p+'#zzz';
        }
        
        window.location.href = url;
    }
    });

})
</script></html>