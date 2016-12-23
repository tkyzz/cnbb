$(function () {
    $(".sign").find("input").focus(function () {
        $(".sign").find(".org-web").hide();
    }).blur(function () {
        $(".sign").find(".org-web").show();
    });
});

/*用户
author zhuyi
 */
    //获取验证码
    function show_time(obj) {
        var remain = parseInt($("#sendcodetime").val()) * 1e3;
        time_distance = remain - 1e3;
        if (time_distance >= 0) {
            int_second = Math.floor(time_distance / 1e3);
            /*if (int_second < 10)
                 int_second = "0" + int_second;*/
            $(obj).val(int_second +' S').attr("disabled", "disabled");
            $("#sendcodetime").val(int_second);
            setTimeout(function() {
                show_time(obj);
            }, 1e3);
        } else {
            $(obj).val("重新发送").removeAttr("disabled").removeClass("disabled");
            $("#sendcodetime").val(180);
        }
    }
	//登录
	
    // $("body").delegate("#login", "click", function() {
    $('#login').click(function(){
        //var emailTest = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        var emailTest = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var msg = "请填写正确的手机号";
        var phoneTest = /^1\d{10}$/;
        var username = $("#username").val();
        var password = $("#password").val();
        var url_return = $("#return_url").val();
        if (!(phoneTest.test(username) || emailTest.test(username))) {
            layer.msg(msg, {
                icon:5
            });
            return false;
        }
        if (password.length == 0) {
            layer.msg("密码不能为空！", {
                icon:5
            });
            return false;
        }
        $("#login").val("登录中").attr('disabled',true);
        $.post("/m/login", {
            username:username,
            password:password,
            return_url:url_return
        }, function(data) {
        	//console.log(data);
            if (data.status == 1) {
                // $("#password").val("123123412341123123412341");
                $("#login").val("登录成功");
                //url是否有效
                //if(data.url.indexOf('http://'+window.location.host)>-1){

                    window.location.href = data.url;

            } else if (data.status == -1) {
                layer.msg("这里是学生用户登录页面！<br>您是企业用户，系统将自动为您跳转企业用户登录页！", {
                    icon:6,
                    time:3e3
                });
                setTimeout(function() {
                    window.location.href = "/hrLogin.html";
                }, 2500);
                $("#login").val("登录").removeAttr("disabled");
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
                $("#login").val("登录").removeAttr("disabled");
            }
        }, "json");
    });

    //验证码

    var captcha_img = $(".js_verifyImg");
    var verifyimg = captcha_img.attr("src");
    captcha_img.attr("title", "点击刷新");
    $(".js_verifyImg").click(function() {
        if (verifyimg.indexOf("?") > 0) {
            captcha_img.attr("src", verifyimg + "&random=" + Math.random());
        } else {
            captcha_img.attr("src", verifyimg.replace(/\?.*$/, "") + "?" + Math.random());
        }
    });

    //注册
    $("#register").click(function() {
        var phoneTest = /^1(3|4|5|7|8)\d{9}$/;
        var username = $("#username").val();
        var password = $("#password").val();
        var verify = $("#smsCode").val();
        var return_url = $("#return_url").val();
        if (username.length == 0) {
            //layer.tips('请输入手机号', '#js_phone');
            layer.msg("请输入手机号", {
                icon:5
            });
            return false;
        }
        if (!phoneTest.test(username)) {
            layer.msg("手机格式不正确", {
                icon:2
            });
            return;
        }
        if (password.length == 0) {
            layer.msg("请输入密码", {
                icon:5
            });
            return false;
        }
        if (password.length < 6) {
            layer.msg("密码至少6位", {
                icon:2
            });
            return false;
        }
        if (verify.length == 0) {
            layer.msg("请输入短信验证码", {
                icon:5
            });
            return false;
        }
        _hmt.push(['_trackEvent', 'WAP学生注册流程监控', username , '注册提交']);
        $("#register").val("注册中").attr("disabled", true);
        $.post("/m/register", {
            return_url:return_url,
            username:username,
            password:password,
            verify:verify,
            mt:1
        }, function(data) {
            if (data.status == 1) {
                _hmt.push(['_trackEvent', 'WAP学生注册流程监控', username , '注册成功']);
                $("#password").val("123123412341123123412341");
                $("#register").val("注册成功");
                window.location.href = data.url;
            } else {
                $("#register").val("学生注册").removeAttr("disabled");
                layer.msg(data.info, {
                    icon:5
                });
            }
        }, "json");
    });


    //学生发送验证码
    $("#js_send_phone_code").click(function() {
        var verify = $("#verify_code").val();
        var phoneTest = /^1(3|4|5|7|8)\d{9}$/;
        var phone = $("#username").val();
        var usage = 1;
        var type = "register";
        if (phone.length == 0) {
            layer.msg("请输入手机号", {
                icon:5
            });
            return;
        }
        if (!phoneTest.test(phone)) {
            layer.msg("手机格式不正确", {
                icon:5
            });
            return;
        }
        if (verify.length != 4) {
            layer.msg("请输入四位图片验证码！", {
                icon:5
            });
            return false;
        }
        _hmt.push(['_trackEvent', 'WAP学生注册流程监控', phone , '获取验证码']);
        $.post("/sendCode", {
            phone:phone,
            usage:usage,
            verify:verify,
            type:type
        }, function(data) {
            if (data.status == 1) {
                $('#js_send_phone_code').addClass("countdown");
                show_time("#js_send_phone_code");
            } else {
                 $(".js_verifyImg").click();
                $(".verify_code").val("");
                $(".js_send_phone_code").removeAttr("disabled");
                if (data.msg != null) {
                    layer.msg(data.msg, {
                        icon:5
                    });
                } else {
                    layer.msg("系统出错,工程师正在抢修中……", {
                        icon:5
                    });
                }
            }
        }, "json");
    });