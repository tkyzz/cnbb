/**
 * Created by Administrator on 2016/7/4.
 */
$(document).ready(function() {
    $(".input-box").each(function() {
        $(this).children("input").focus(function() {
            $(this).next("label").css("display", "none");
        });
        $(this).children("input").blur(function() {
            if ($(this).val() == "") {
                $(this).next("label").show();
            } else {
                $(this).next("label").hide();
            }
        });
    });
    $(".tab-title span").each(function(index) {
        $(this).click(function() {
            $(this).addClass("select").siblings().removeClass("select");
            $(".sign-box").eq(index).css("display", "block").siblings(".sign-box").css("display", "none");
        });
    });
    //    recommend hove
    $(".sub-recommend").each(function() {
        $(this).hover(function() {
            $(this).find($(".hove-bg")).css("display", "block");
        }, function() {
            $(this).find($(".hove-bg")).css("display", "none");
        });
    });
    //    profile-item hove
    $(".profile-cover").each(function() {
        $(this).hover(function() {
            $(this).find(".profile-info").css("display", "none");
            $(this).find(".profile-state").css("display", "block");
        }, function() {
            $(this).find(".profile-info").css("display", "block");
            $(this).find(".profile-state").css("display", "none");
        });
    });
    //    profile-remove cancel
    $("#cancel").click(function() {
        $(".warn-layer").hide();
    });
    //    my-nav show/hide
    $(".my").hover(function() {
        $(this).toggleClass("nav-hove");
        $(this).children("div").stop().slideToggle();
    });
    //    companyProfile company-info
    $(".section-more").click(function() {
        var infoBoxH = $(".info-box").height();
        var infoH = $(".company-info").height();
        if (infoBoxH <= 230) {
            $(this).hide();
            $(this).parent().parent().height(infoBoxH);
            return;
        }
        if (infoBoxH > infoH) {
            $(this).addClass("up");
            $(this).parent().parent().height(infoBoxH + 40);
        } else {
            $(this).removeClass("up");
            $(this).parent().parent().height(230);
        }
    });
    //    postList more related
    $("#moreBtn").click(function() {
        $(this).toggleClass("more-down");
        $("#moreRelated").toggle();
    });
    //    tips show
    $(".tips-title").hover(function() {
        $(this).next(".tips-info").toggle();
    });
    //    newProfile level-info show
    $(".block-append").each(function() {
        $(this).click(function() {
            $(this).next(".level-info").show();
            $(this).hide();
        });
    });
    //    profileEdit select-container
    $(".hope-info").each(function(index) {
        $(this).find(".input-box").click(function() {
            var i = $(".select-container");
            if (i.eq(index).is(":visible") == false) {
                i.eq(index).show();
                $(this).children("input").val("点击收起");
                $(this).addClass("active");
            } else {
                i.eq(index).hide();
                $(this).children("input").val("点击选择");
                $(this).removeClass("active");
            }
        });
    });
    //    myFeedback feedback-detail show/hide
    $(".feedback-item").each(function(index) {
        $(this).find(".feedback-btn").click(function() {
            var deliver_id = $(this).attr("data-id");
            //反馈通知状态
            $.ajax({
                async:false,
                type:"POST",
                url:"/ajax/feedbackmsg",
                data:{
                    deliver_id:deliver_id,
                    op:"readdeliver"
                },
                dataType:"json",
                success:function(data) {
                    if (data.status == 1) {
                        $.post("/ajax/getmsgnum", {
                            op:"get"
                        }, function(data) {
                            if (data.status == 1) {
                                if (data.info.deliver == 0) {
                                    $(".js_feedmsg_num").hide();
                                } else {
                                    $(".js_feedmsg_num").show();
                                }
                            }
                        }, "json");
                    }
                }
            });
            $(".feedback-detail").eq(index).show();
        });
        $(this).find(".feedback-up").click(function() {
            $(".feedback-detail").eq(index).hide();
        });
    });
    //    postDetail detail-favorite
    $(".detail-favorite").click(function() {
        var post_id = $(this).attr("data-id");
        if ($(".detail-favorite").hasClass("favorite-active")) {
            $.post("/ajax/fav", {
                post_id:post_id,
                type:"delete"
            }, function(data) {
                if (data.status == 1) {
                    $(".detail-favorite").removeClass("favorite-active");
                    $("#favoriteTips").text("取消收藏");
                    setTimeout(function() {
                        $("#favoriteTips").text("");
                    }, 500);
                } else {
                    $("#favoriteTips").text(data.msg);
                    setTimeout(function() {
                        $("#favoriteTips").text("");
                    }, 500);
                }
            }, "json");
        } else {
            $.post("/ajax/fav", {
                post_id:post_id,
                type:"post"
            }, function(data) {
                if (data.status == 1) {
                    $(".detail-favorite").addClass("favorite-active");
                    $("#favoriteTips").text("收藏成功");
                    setTimeout(function() {
                        $("#favoriteTips").text("");
                    }, 500);
                } else {
                    $("#favoriteTips").text(data.msg);
                    setTimeout(function() {
                        $("#favoriteTips").text("");
                    }, 500);
                }
            }, "json");
        }
    });
    //    postDetails popup show
    $("#js_post").click(function() {
        var is_completed = $("#post_resume").find(":selected").attr("data-id");
        var resume_baseid = $("#post_resume").find(":selected").attr("data-baseid");
        if (is_completed != "1") {
            $(".js_wsjl_tc").attr("href", "/resume/detail/" + resume_baseid + ".html");
            $("#noProfilePopup").show();
            return false;
        }
        var resume_id = $("#post_resume").val();
        var trade = $("#job_trade").val();
        var city = $("#job_city").val();
        var work_type = $("#job_work_type").val();
        var work_duration = $("#job_work_duration").val();
        var week_workdays = $("#job_week_workdays").val();
        $.post("/ajax/getIntention", {
            resume_id:resume_id,
            trade:trade,
            city:city,
            work_type:work_type,
            work_duration:work_duration,
            week_workdays:week_workdays
        }, function(data) {
            var info = data.info;
            if (data.status == 1) {
                if (info.result.city == 1 && info.result.trade == 1 && info.result.work_days == 1 && info.result.work_type == 1) {
                    $("#surePopup").show();
                } else {
                    $("#willPopup").show();
                }
                $("#intention_id").val(info.id);
                $("#arrive_days").val(info.arrive_days);
                $(".js_my_worktype").html(info.work_type_name + '<span class="point"></span>');
                $(".js_my_city").attr("data-id", info.city_id).attr("data-name", info.city);
                $(".js_my_city").html(info.city + '<span class="point"></span>');
                $(".js_my_trade").attr("data-id", info.trade_id).attr("data-name", info.trade);
                $(".js_my_trade").html(info.trade + '<span class="point"></span>');
                $(".js_my_worktype").attr("data-id", info.work_type);
                $(".js_my_workdays").attr("data-week", info.week_workdays).attr("data-duration", info.work_duration);
                var work_days = "";
                if (info.work_type == 1) {
                    work_days = "每周工作" + info.week_workdays + "天";
                } else if (info.work_type == 2) {
                    work_days = "至少连续实习" + info.work_duration + "个月，每周工作" + info.week_workdays + "天";
                }
                $(".js_my_workdays").html(work_days + '<span class="point"></span>');
                if (info.result.city == 1) {
                    $(".js_pp_city").addClass("matching");
                } else {
                    $(".js_pp_city").addClass("mismatching");
                }
                if (info.result.trade == 1) {
                    $(".js_pp_trade").addClass("matching");
                } else {
                    $(".js_pp_trade").addClass("mismatching");
                }
                if (info.result.work_days == 1) {
                    $(".js_pp_workdays").addClass("matching");
                } else {
                    $(".js_pp_workdays").addClass("mismatching");
                }
                if (info.result.work_type == 1) {
                    $(".js_pp_worktype").addClass("matching");
                } else {
                    $(".js_pp_worktype").addClass("mismatching");
                }
            } else {
                alert(data.msg);
            }
        }, "json");
    });
    //    postDetail detail-favorite
    $(".detail-share").hover(function() {
        $("#shareBar").toggle();
    });
    //    postDetails popup show
    // $(".apply-btn").click(function () {
    //     $("#willPopup").show();
    // });
    //    postDetails popup hide
    $(".popup-close").click(function() {
        $(".popup").hide();
    });
    //    settings popup show/hide
    // $(".settings-btn").click(function () {
    //     $(".popup").show();
    //     setTimeout(function () {
    //         $("#savePopup").hide("slow");
    //     },1000);
    // });
    //    myProfile new profile popup
    $("#newProfile").click(function() {
        $("#newPopup").show();
    });
    //    footer app-code show/hide
    $(".code-nav").hover(function() {
        $(this).parent().find(".app-code").toggle();
    });
});

//orgLogon register or logon
$(function() {
    var navL = $(".tab-menu").find(".sub-menu").length;
    var contL = $(".tab-cont").find(".tab-item").length;
    if (navL != contL) {
        return;
    }
});