

$(function() {
    //继续投递
    $(".js_continue_post").click(function() {
        var resume_id = $("#post_resume").val();
        var post_id = $(this).attr("data-id");
        var org_id = $("input[name=org_id]").val();
        $(this).attr("disabled", "disabled");
        $("#willPopup").hide();
        layer.msg("拼命投递中……", {
            icon:1
        });
        $.post("/ajax/deliver", {
            resume_id:resume_id,
            post_id:post_id
        }, function(data) {
            if (data.status == 1) {
                window.location.href = "/post/" + org_id + "/deliver.html";
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
                $(".js_continue_post").removeAttr("disabled");
                window.location.reload();
            }
        }, "json");
    });
    //一键修改求职意向
    $(".js_edit_intention").click(function() {
        var id = $("#intention_id").val();
        var arrive_days = $("#arrive_days").val();
        var city_id = $(".js_my_city").attr("data-id");
        var city_name = $(".js_my_city").attr("data-name");
        var job_city_id = $(".js_pp_city").attr("data-id");
        var job_city_name = $(".js_pp_city").attr("data-name");
        var trade_id = $(".js_my_trade").attr("data-id");
        var trade_name = $(".js_my_trade").attr("data-name");
        var job_trade_id = $(".js_pp_trade").attr("data-id");
        var job_trade_name = $(".js_pp_trade").attr("data-name");
        var work_type = $(".js_pp_worktype").attr("data-id");
        var week_workdays = $(".js_pp_workdays").attr("data-week");
        var work_duration = $(".js_pp_workdays").attr("data-duration");
        $(this).attr("disabled", true);
        $.ajax({
            async:false,
            type:"POST",
            url:"/ajax/yjIntention",
            data:{
                id:id,
                arrive_days:arrive_days,
                city_id:city_id,
                city_name:city_name,
                job_city_id:job_city_id,
                job_city_name:job_city_name,
                trade_id:trade_id,
                trade_name:trade_name,
                job_trade_id:job_trade_id,
                job_trade_name:job_trade_name,
                work_type:work_type,
                week_workdays:week_workdays,
                work_duration:work_duration
            },
            dataType:"json",
            success:function(data) {
                if (data.status == 1) {
                    $("#willPopup").hide();
                    var resume_id = $("#post_resume").val();
                    var post_id = $(".js_continue_post").attr("data-id");
                    var org_id = $("input[name=org_id]").val();
                    layer.msg("拼命投递中……", {
                        icon:1
                    });
                    $.post("/ajax/deliver", {
                        resume_id:resume_id,
                        post_id:post_id
                    }, function(data) {
                        if (data.status == 1) {
                            window.location.href = "/post/" + org_id + "/deliver.html";
                        } else {
                            $(".js_edit_intention").attr("disabled", false);
                            layer.msg(data.msg, {
                                icon:5
                            });
                            window.location.reload();
                        }
                    }, "json");
                } else {
                    layer.msg(data.msg, {
                        icon:5
                    });
                    $(this).attr("disabled", false);
                    window.location.reload();
                }
            }
        });
    });
    //没有简历弹框
    $("#js_noresume").click(function() {
        $("#noResumePopup").show();
    });

    $(".cancel").click(function() {});
});