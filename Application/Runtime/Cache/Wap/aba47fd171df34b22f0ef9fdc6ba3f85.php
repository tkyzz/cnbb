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
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/postList.css">
<!--     <link rel="stylesheet" href="/Public/js/dropload/dropload.css">
    <script src="/Public/js/dropload/dropload.min.js"></script> -->
</head>
<body>
    <header class="header">
        <a class="working-place" href="javascript:;"><i></i><span class="place"><?php echo ((isset($nowcity) && ($nowcity !== ""))?($nowcity):'上海'); ?></span></a>
        <span class="title">菜鸟帮帮岗位列表</span>
        <div class="others"><span class="sub-nav my" id="my"><i></i></span></div>
        <!-- <span class="my" id="my"><i></i></span> -->
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
    <div class="footer">
        <div class="logo"><img src="/Public/img/wap/logo.png"/></div>
        <div class="slogan"><img src="/Public/img/wap/slogan.png"/></div>
        <div class="app-download">
            <div class="cartoon"><img src="/Public/img/wap/cartoon.png"/></div>
            <a class="download" href="<?php echo ($download_url); ?>"><img src="/Public/img/wap/download_btn.png"/></a>
        </div>
    </div>
    <div class="content">
        <div class="post-filter-box">
            <div class="term-select">
                <span class="select-item">岗位性质<i></i></span>
                <span class="select-item">行业领域<i></i></span>
            </div>
            <div class="post-filter">
                <div class="filter-info">
                    <div class="filter-block">
                        <p class="block-title">岗位性质</p>
                        <div class="filter-term">
                            <span class="sub-option jobsea work_type" data-op="work_type" data-id="0">不限</span>
                            <span class="sub-option jobsea work_type" data-op="work_type" data-id="2">日常</span>
                            <span class="sub-option jobsea work_type" data-op="work_type" data-id="1">假期</span>
                        </div>
                    </div>
                    <div class="filter-block work_day_area" style="display:none;">
                        <p class="block-title">至少连续实习月数</p>
                        <div class="filter-term">
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="1">1个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="2">2个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="3">3个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="4">4个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="5">5个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="6">6个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="7">7个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="8">8个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="9">9个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="10">10个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="11">11个月</span>
                            <span class="sub-option jobsea work_day" data-op="work_day" data-id="12">12个月</span>
                        </div>
                    </div>
                    <div class="filter-block">
                        <p class="block-title">每周工作天数</p>
                        <div class="filter-term">
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="1">1天</span>
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="2">2天</span>
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="3">3天</span>
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="4">4天</span>
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="5">5天</span>
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="6">6天</span>
                            <span class="sub-option jobsea week_day" data-op="week_day" data-id="7">7天</span>
                        </div>
                    </div>
                    <input class="filter-btn sec_sub" type="button" value="确定"/>
                </div>
                <div class="filter-info">
                    <div class="filter-block">
                        <p class="block-title">行业领域</p>
                        <div class="filter-term">
                            <!-- <span class="sub-option jobsea trade" data-op="trade" data-id="0">不限</span> -->
                            <span class="sub-option jobsea trade" data-op="trade" data-id="1">商业银行</span>
                            <span class="sub-option jobsea trade" data-op="trade" data-id="5">证券投资</span>
                            <span class="sub-option jobsea trade" data-op="trade" data-id="11">保险</span>
                            <span class="sub-option jobsea trade" data-op="trade" data-id="13">新兴金融行业</span>
                            <span class="sub-option jobsea trade" data-op="trade" data-id="16">财务会计</span>
                            <span class="sub-option jobsea trade" data-op="trade" data-id="20">其他</span>
                        </div>
                    </div>
                    <input class="filter-btn sec_sub" type="button" value="确定"/>
                </div>
            </div>
        </div>

        <div class="post-list">
        <?php if(is_array($res["posts"])): foreach($res["posts"] as $k=>$v): ?><a class="post-item" href="/m/post/<?php echo (smartBase64($v["id"])); ?>.html">
                <div class="post-avatar"><img src="<?php echo ((isset($v["org"]["b_logo_url"]) && ($v["org"]["b_logo_url"] !== ""))?($v["org"]["b_logo_url"]):'/Public/img/wap/company_icon.jpg'); ?>"/></div>
                <div class="post-info">
                    <div class="info-line">
                        <span class="line-block post-name"><?php echo ($v["name"]); ?></span>
                          <?php if(($v['esalary']) >= "1"): ?><span class="line-block post-pay"><?php echo ($v['ssalary']); ?>-<?php echo ($v['esalary']); if($v['salary_unit'] == 0): ?>元/天<?php else: ?>元/月<?php endif; ?></span>
                          <?php else: ?>
                          <span class="line-block post-pay"> <?php if($v['ssalary'] <= 0): ?>面议<?php else: if($v['salary_unit'] == 0): echo ($v["ssalary"]); ?>元/天<?php else: echo ($v["ssalary"]); ?>元/月<?php endif; endif; ?></span><?php endif; ?>
                        <!-- <span class="line-block post-pay">3500-8000元/月</span> -->

                    </div>
                    <div class="info-line">
                        <span class="line-block post-org"><?php echo ($v["org"]["abbrname"]); ?></span>
                        <span class="line-block post-addr"><i></i><?php echo ($v["city_name"]); ?>-<?php if(!empty($v["zone_name"])): echo ($v["zone_name"]); else: ?>全市<?php endif; ?></span>
                    </div>
                    <div class="info-line">
                        <div class="line-block post-others">
                            <span class="sub-attr"><?php echo (smartDegree($v["degree"])); ?></span>
                            <?php if(!empty($v["work_days"])): ?><span class="sub-attr"><?php echo ($v["work_days"]); ?>天/周</span><?php endif; ?>
                            <?php if(!empty($v["work_duration"])): ?><span class="sub-attr">至少<?php echo ($v['work_duration']/30); ?>个月</span><?php endif; ?>
                        </div>
                        <span class="line-block post-time"><?php echo (smartJobStrTime($v["last_time"])); ?></span>
                    </div>
                </div>
            </a><?php endforeach; endif; ?>
        </div>
    </div>
    <input type="hidden" id="page" value="2">
    <input type="hidden" id="city" value="<?php echo ($_GET['city']); ?>">
    <input type="hidden" id="trade" data-v="" value="<?php echo ($_GET['trade']); ?>">
    <input type="hidden" id="work_type" data-v="" value="<?php echo ($_GET['work_type']); ?>">
    <input type="hidden" id="week_day" data-v="" value="<?php echo ($_GET['week_day']); ?>">
    <input type="hidden" id="work_day" data-v="" value="<?php echo ($_GET['work_day']); ?>">
    <script src="/Public/js/style_h5.js"></script>
    <script src="/Public/js/wap/mpost.js?v=1.1"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.working-place').click(function(){
                var url = '/m/jobSetCity.html';
                var params = window.location.search;
                if ( params ) {
                    url += params;
                }
                window.location.href = url;
            });
            $(window).scroll(function() {
                //$(document).scrollTop() 获取垂直滚动的距离
                //$(document).scrollLeft() 这是获取水平滚动条的距离
                // if ($(document).scrollTop() <= 0) {
                //     alert("滚动条已经到达顶部为0");
                // }


                if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                    var sum = 0;
                    $('.post-item').each(function(){
                        sum ++;
                    });
                    //alert(sum);
                    if(sum < 10){
                        layer.msg('没有更多岗位了',{icon:2});
                        return false;
                    }
                    var page = $('#page').val(); 
                    var index = layer.load(1, {
                      shade: [0.1,'#fff'] //0.1透明度的白色背景
                    });
                    $.ajax({
                        type: 'post',
                        url: getJobUrl(true),
                        dataType: 'json',
                        success: function(data){
                            if( data.status == 1 ){
                                $('#page').val(parseInt(page)+1); 
                                $('.post-list').append(data.html);
                                // 每次数据加载完，必须重置
                               // me.resetload();
                            }else{
                                layer.msg(data.msg,{icon:2});
                                // 每次数据加载完，必须重置
                                //me.resetload();
                            }
                            layer.closeAll('loading'); //关闭加载层
                        },
                        error: function(xhr, type){
                            layer.closeAll('loading'); //关闭加载层
                            layer.msg('网络异常，请重试',{icon:2});
                            // 即使加载出错，也得重置
                          // me.resetload();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>