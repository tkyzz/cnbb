<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>菜鸟帮帮-岗位详情</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/postDetail.css">
    <link rel="stylesheet" href="/Public/css/h5/nativeShare.css"/>
</head>
<body>
    <div class="page">
        <header class="header">
            <a class="back" href="/m/postList.html"><i></i></a>
            <span class="title">岗位详情</span>
            <div class="others">
                <span class="sub-nav share" id="share"><i></i></span>
                <span class="sub-nav my" id="my"><i></i></span>
            </div>
            <div class="my-cont" id="my-cont">
                <?php if(!empty($_SESSION['user']['access_token'])): ?><a class="cont-item" href="/m/myresume.html">
                        <img class="item-img" src="/Public/img/wap/my_profile.png"/>
                        <p class="item-title">我的简历</p>
                    </a>
                    <a class="cont-item" href="/m/feedback.html">
                        <img class="item-img" src="/Public/img/wap/feedback.png"/>
                        <p class="item-title">投递反馈</p>
                    </a>
                <?php else: ?>
                    <a class="cont-item" href="/m/login.html">
                        <img class="item-img" src="/Public/img/wap/my_profile.png"/>
                        <p class="item-title">我的简历</p>
                    </a>
                    <a class="cont-item" href="/m/login.html">
                        <img class="item-img" src="/Public/img/wap/feedback.png"/>
                        <p class="item-title">投递反馈</p>
                    </a><?php endif; ?>
            </div>
        </header>
        <nav class="bottom-nav">
        <?php if($is_show == 0): ?><a class="sub-nav edit-profile" href="/m/login.html">创建简历<span class="nav-tag"></span></a>
            <input class="sub-nav delivery" data="0" type="button" value="一键投递">
        <?php elseif($is_show == 1): ?>
            <a class="sub-nav edit-profile"><?php echo ($myresume['name']); ?><span class="nav-tag"></span></a>
            <?php if(!empty($res["is_delivered"])): ?><input class="sub-nav delivery" data="2" type="button" value="已投递">
            <?php else: ?>
            <input class="sub-nav delivery" data="1" type="button" value="一键投递"><?php endif; ?>
            <input type="hidden" name="resume_id" value="<?php echo ($myresume['id']); ?>">
            <input type="hidden" name="post_id" value="<?php echo ($res["id"]); ?>">
        <?php else: ?>
            <a class="sub-nav edit-profile" href="/m/myResume.html">创建简历<span class="nav-tag"></span></a>
            <input class="sub-nav delivery" data="-1" type="button" value="一键投递"><?php endif; ?>
        </nav>
        <div class="footer">
            <div class="logo"><img src="/Public/img/wap/logo.png"/></div>
            <div class="slogan"><img src="/Public/img/wap/slogan.png"/></div>
            <div class="app-download">
                <div class="cartoon"><img src="/Public/img/wap/cartoon.png"/></div>
                <a class="download" href="<?php echo ($download_url); ?>"><img src="/Public/img/wap/download_btn.png"/></a>
            </div>
        </div>

        <div class="content">
            <div class="cont-item">
                <div class="name-pay">
                    <span class="post-name"><?php echo ($res["name"]); ?></span>
                  <?php if(($res['esalary']) >= "1"): ?><span class="post-pay"><?php echo ($res['ssalary']); ?>-<?php echo ($res['esalary']); if($res['salary_unit'] == 0): ?>元/天<?php else: ?>元/月<?php endif; ?></span>
                  <?php else: ?>
                  <span class="post-pay"> <?php if($res['ssalary'] <= 0): ?>面议<?php else: if($res['salary_unit'] == 0): echo ($res["ssalary"]); ?>元/天<?php else: echo ($res["ssalary"]); ?>元/月<?php endif; endif; ?></span><?php endif; ?>
                </div>
                <div class="post-basic">
                    <div class="basic-left">
                        <span class="basic-item post-degree"><i></i><?php echo (smartDegree($res["degree"])); ?></span>
                        <span class="basic-item post-type"><i></i><?php echo (smartdictval($res["work_type"])); ?></span>
                        <?php if(!empty($res["work_days"])): ?><span class="basic-item post-days"><i></i><?php echo ($res["work_days"]); ?>天/周</span><?php endif; ?>
                        <?php if(!empty($$res['work_duration'])): ?><span class="basic-item post-month"><i></i>至少<?php echo ($res['work_duration']/30); ?>个月</span><?php endif; ?>
                    </div>
                    <div class="basic-right">
                        <span class="basic-item post-duration"><?php echo (smartJobStrTime($res["last_time"])); ?></span>
                    </div>
                </div>

                <?php if(!empty($res["high_lights"])): ?><div class="post-basic">
                    <span class="basic-title">岗位亮点</span>
                    <span class="post-key"><?php echo ($res["high_lights"]); ?></span>
                </div><?php endif; ?>

                <div class="post-basic">
                    <span class="basic-title">福利标签</span>
                    <div class="welfare">
                    <?php if(is_array($res["fl_tags"])): foreach($res["fl_tags"] as $key=>$v): ?><span class="sub-welfare"><?php echo ($v); ?></span><?php endforeach; endif; ?>
                    </div>
                </div>

                <div class="post-basic">
                    <a class="basic-item post-addr" href="/m/map.html?addr=<?php echo ($res["province_name"]); echo ($res["city_name"]); ?> <?php echo ($res["zone_name"]); echo ($res["addr"]); ?>">
                    <i></i>
                    <?php if(is_zhixia($res['province_name'])): echo ($res["province_name"]); ?>-<?php echo ($res["zone_name"]); if(!empty($res["addr"])): ?>-<?php echo ($res["addr"]); endif; ?>
                                       <?php else: ?>
                                       <?php echo ($res["province_name"]); ?>-<?php echo ($res["city_name"]); ?>-<?php if(!empty($res["zone_name"])): echo ($res["zone_name"]); else: ?>全市<?php endif; if(!empty($res["addr"])): ?>-<?php echo ($res["addr"]); endif; endif; ?>
                        <i class="go"></i>
                    </a>
                </div>
            </div>

            <div class="cont-item">
                <div class="org-img"><img src="<?php echo ($res["org"]["b_logo_url"]); ?>"/></div>
                <div class="org-info">
                    <p class="org-name"><?php echo ($res["org"]["fullname"]); ?></p>
                    <div class="info-box">
                        <span class="info-item"><?php echo ($res["org"]["trade_name"]); ?></span>
                        <span class="info-item"><?php echo ($res["org"]["nature_name"]); ?></span>
                        <span class="info-item"><?php echo ($res["org"]["scale_name"]); ?></span>
                    </div>
                </div>
            </div>

            <div class="cont-item">
                <div class="post-info">
                    <div class="part-title">
                        <div class="title-tag"><span></span></div>
                        <span class="title-info">岗位描述</span>
                    </div>
                    <div class="part-info">
                        <?php echo (nl2br($res["remark"])); ?>
                    </div>
                </div>
                <div class="post-info">
                    <div class="part-title">
                        <div class="title-tag"><span></span></div>
                        <span class="title-info">岗位要求</span>
                    </div>
                    <div class="part-info">
                        <?php echo (nl2br($res["post_remark"])); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="jiathis_style_m" style="display:none;"></div>
<input type="hidden" id="current_url" value="/m/post/<?php echo (smartBase64($res["id"])); ?>">

    <!--分享弹层-->
    <div class="popup" id="sharePopup" style="display:none;">
        <div class="share-info">
        <div id="nativeShare"></div>
<!--             <div class="share-nav" id="nativeShare">
                <div class="sub-nav">
                    <div class="nav-img"><img src="/Public/img/wap/weixin.jpg"/></div>
                    <p class="nav-text">微信朋友圈</p>
                </div>
                <div class="sub-nav">
                    <div class="nav-img"><img src="/Public/img/wap/kongjian.jpg"/></div>
                    <p class="nav-text">QQ空间</p>
                </div>
                <div class="sub-nav nativeShare weibo" data-app="sinaWeibo">
                    <div class="nav-img"><img src="/Public/img/wap/weibo.jpg"></div>
                    <p class="nav-text">新浪微博</p>
                </div>
            </div> -->
            <div class="share-cancel"><button class="cancel-btn">取消</button></div>
        </div>
    </div>
</body>

<script src="/Public/js/wap/nativeShare.js?v=1.4"></script>
<script src="/Public/js/style_h5.js"></script>
<script type="text/javascript">
$(function(){
        var current_url = window.location.href;
        var config = {
            url:current_url,
            title:'菜鸟帮帮',
            desc:'菜鸟帮帮',
            img:'<?php echo ($res["org"]["b_logo_url"]); ?>',
            img_title:'菜鸟帮帮',
            from:'菜鸟帮帮'
        };
        var share_obj = new nativeShare('nativeShare',config);
})
$('.delivery').click(function(){
    var data = $(this).attr('data');
    //已投递
    if (data == 2){
        layer.msg('此岗位您已投递过啦~',{icon:0});
        return false;
    }
    if ( data == 0 ) {
        //未登录
        var url = $('#current_url').val();
        if(url.length > 0){
            window.location.href = '/m/login.html?return='+url;
        }else{
            window.location.href = '/m/login.html';
        }
        
        
    } else if ( data == -1 ) {
        //没有简历
        layer.msg('请先创建简历后才能投递岗位',{icon:0});
        //window.location.href = '/mmyResume.html';
    } else if ( data == 1 ) {
        //投递
        var resume_id = $('[name="resume_id"]').val();
        var post_id = $('[name="post_id"]').val();
        var org_id = $("input[name=org_id]").val();
        $('.delivery').attr("disabled",true);
        layer.msg("拼命投递中……", {
            icon:1
        });
        $.post("/ajax/deliver", {
            resume_id:resume_id,
            post_id:post_id,
            device:2
        }, function(data) {
            if (data.status == 1) {
                $('.delivery').val('已投递').attr('data',2);
                window.location.href = "/m/deliver.html?id="+post_id;
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
                 $('.delivery').removeAttr("disabled");
                //window.location.reload();
            }
        }, "json");

    }
});
</script>
</html>