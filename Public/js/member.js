$(function() {

    $(".phone_reg").click(function() {
        $(this).addClass("active").siblings().removeClass("active");
        $(".tab-cont").find(".tab-item").eq(1).hide();
        $(".tab-cont").find(".tab-item").eq(0).show();
    });
    $(".email_reg").click(function() {
        $(this).addClass("active").siblings().removeClass("active");
        $(".tab-cont").find(".tab-item").eq(0).hide();
        $(".tab-cont").find(".tab-item").eq(1).show();
    });
    $("#keep").click(function() {
        if ($(this).attr("checked") && !$(this).attr("data")) {
            $(this).attr("data", 1);
            layer.alert("警告：请不要在他人电脑上选择此项！", {
                btn:[ "好的" ],
                title:"提示"
            });
        }
    });
    //企业登录
    $("body").delegate(".js_org_login", "click", function() {
        //var emailTest = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        var emailTest = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var msg = "请填写正确的邮箱或手机号";
        var phoneTest = /^1\d{10}$/;
        var phone = $("#login_phone").val();
        var password = $("#login_password").val();
        var url_return = $("#url_return").val();
        var is_keep = $("#keep").attr("checked");
        if (is_keep == "checked") {
            is_keep == 1;
        } else {
            is_keep == 0;
        }
        if (!(phoneTest.test(phone) || emailTest.test(phone))) {
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
        $(".js_org_login").val("登录中...").attr("disabled", true);
        $.post("/hrLogin", {
            phone:phone,
            password:password,
            is_keep:is_keep
        }, function(data) {
            if (data.status == 1) {
                $("#log_pwd").val("123123412341123123412341");
                $(".js_org_login").val("登录成功");
                window.location.href = data.url;
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
                //$('#password').val(password);
                $(".js_org_login").val("登录").removeAttr("disabled");
            }
        }, "json");
    });
    //企业手机注册
    $(".js_org_register").click(function() {
        var phoneTest = /^1(3|4|5|7|8)\d{9}$/;
        var username = $("#register_phone").val();
        var password = $("#register_password").val();
        var verify = $("#smsCode").val();
        var verify_code = $("#verify_code").val();
        if (username.length == 0) {
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
        if (verify_code.length == 0) {
            layer.msg("请输入图形验证码", {
                icon:5
            });
            return false;
        }
        $(".js_org_register").val("注册中...").attr("disabled", true);
        $.post("/hrRegister", {
            username:username,
            password:password,
            verify:verify,
            mt:2,
            is_phone:"true"
        }, function(data) {
            if (data.status == 1) {
                if (data.is_phone == 0) {
                    data.url = data.url + "?email=" + data.email;
                }
                $("#phonepassword").val("123123412341123123412341");
                window.location.href = data.url;
            } else {
                $(".code-img").click();
                $(".js_org_register").val("注册").removeAttr("disabled");
                layer.msg(data.info, {
                    icon:5
                });
            }
        }, "json");
    });
    //企业邮箱注册
    $(".js_org_email_register").click(function() {
        //var emailTest = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        var emailTest = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-\_])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var msg = "请填写正确的邮箱";
        var username = $("#register_email").val();
        var password = $("#register_pwd").val();
        //图形验证码
        var verify_code = $("#verify_email_code").val();
        if (username.length == 0) {
            layer.msg("请输入邮箱", {
                icon:5
            });
            return false;
        }
        if (!emailTest.test(username)) {
            layer.msg("邮箱格式不正确", {
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
        if (verify_code.length == 0) {
            layer.msg("请输入图形验证码", {
                icon:5
            });
            return false;
        }
        $(".js_org_email_register").val("注册中...").attr("disabled", true);
        $.post("/hrRegister", {
            username:username,
            password:password,
            verify_code:verify_code,
            mt:2,
            is_phone:"false"
        }, function(data) {
            if (data.status == 1) {
                if (data.is_phone == 0) {
                    data.url = data.url + "?email=" + data.email;
                }
                $("#phonepassword").val("123123412341123123412341");
                window.location.href = data.url;
            } else {
                $(".code-img").click();
                $(".js_org_email_register").val("注册").removeAttr("disabled");
                layer.msg(data.info, {
                    icon:5
                });
            }
        }, "json");
    });
    //企业发送验证码
    $(".js_comsend_phone_code").click(function() {
        var verify = $("#verify_code").val();
        var phoneTest = /^1(3|4|5|7|8)\d{9}$/;
        var phone = $("#register_phone").val();
        var usage = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        if (phone.length == 0) {
            layer.msg("请输入手机号", {
                icon:5
            });
            return;
        }
        if (!phoneTest.test(phone)) {
            layer.msg("手机格式不正确", {
                icon:2
            });
            return;
        }
        if (verify.length != 4) {
            layer.msg("请输入四位图片验证码！", {
                icon:5
            });
            return false;
        }
        $.post("/sendCode", {
            phone:phone,
            usage:usage,
            verify:verify,
            type:type
        }, function(data) {
            if (data.status == 1) {
                // alert(data.info);
                show_time(".js_comsend_phone_code");
            } else {
                $(".code-img").click();
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
    //再次发送邮件
    $(".js_reemail").click(function() {
        email = $('input[type="email"]').val();
        var emailauth = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (!emailauth.test(email)) {
            layer.msg("邮箱格式不正确", {
                icon:5
            });
            return true;
        }
        $.post("/reAuth", {
            email:email
        }, function(data) {
            if (data.status == 1) {
                window.location.href = "/registerActive.html";
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
            }
        }, "json");
    });
    //简称不能大于全称
    $.validator.addMethod("checkjcqc", function(value, element) {
        var qc = $('[name="fullname"]').val();
        var jc = $('[name="abbrname"]').val();
        if (qc.length < jc.length) {
            return false;
        } else {
            return true;
        }
    }, "简称不能长于全称");
    //创建企业
    //点击提交创建机构
    $(".js_sub_orgcreate").click(function() {
        if ($("#createComForm").valid()) {
            $("#createComForm").submit();
        }
    });
    //创建机构
    $("#createComForm").validate({
        //   errorPlacement : function(error, element) { 
        //     if(element.attr('name') == 'yyzz'){
        //         error.appendTo(element.parent().parent());
        //     }
        //     // else{
        //     //     error.appendTo(element.prev().prev());
        //     // }
        // }, 
        errorLabelContainer:"#error",
        ignore:"",
        onkeyup:false,
        rules:{
            fullname:{
                required:true,
                numCheck:true,
                userNamecheck:true
            },
            abbrname:{
                required:true,
                numCheck:true,
                userNamecheck:true,
                // checkjcqc:true
            },
            trade:{
                required:true
            },
            subtrade:{
                required:true
            },
            // nature:{
            //     required:true
            // },
            province:{
                required:true
            },
            city:{
                required:true
            },
            addr:{
                required:true
            },
            remark:{
                required:true
            }
        },
        messages:{
            fullname:{
                required:"请输入企业名称",
                numCheck:"企业名称不能为纯数字",
                userNamecheck:"企业名称不能有非法字符"
            },
            abbrname:{
                required:"请输入企业简称",
                numCheck:"简称不能为纯数字",
                userNamecheck:"简称不能有非法字符",
                // checkjcqc:"简称不能长于全称"
            },
            trade:{
                required:"请选择行业"
            },
            subtrade:{
                required:"请选择二级行业"
            },
            // nature:{
            //     required:"请选择公司性质"
            // },
            province:{
                required:"请选择省/直辖市"
            },
            city:{
                required:"请选择城市"
            },
            addr:{
                required:"请输入地址"
            },
            remark:{
                required:"请输入企业简介"
            }
        },
        submitHandler:function(form) {
            $("#createComForm").ajaxSubmit({
                url:"/company/create",
                type:"POST",
                dataType:"json",
                beforeSubmit:function() {
                    $(".js_sub_orgcreate").val("提交中...").attr("disabled", true);
                },
                success:function(data) {
                    if (data.status == 1) {
                        window.location.href = data.url;
                    } else {
                        layer.msg(data.msg, {
                            icon:5
                        });
                        $(".js_sub_orgcreate").val("重新提交").removeAttr("disabled");
                    }
                }
            });
        }
    });
    //点击提交创建机构
    $("#sub_extra").click(function() {
        if ($("#comExtraForm").valid()) {
            $("#comExtraForm").submit();
        }
    });
    //更新企业额外信息
    $("#comExtraForm").validate({
        //   errorPlacement : function(error, element) { 
        //     if(element.attr('name') == 'yyzz'){
        //         error.appendTo(element.parent().parent());
        //     }
        //     // else{
        //     //     error.appendTo(element.prev().prev());
        //     // }
        // }, 
        errorLabelContainer:"#error",
        ignore:"",
        onkeyup:false,
        rules:{
            contacter:{
                required:true,
                numCheck:true,
                userNamecheck:true
            },
            contacter_mail:{
                required:true,
                email:true
            },
            //yyzz_img:{required:true},
            contacter_phone:{
                isTelNo:true,
                checkpmmust:true
            },
            contacter_mobile:{
                isMobile:true,
                checkpmmust:true
            }
        },
        messages:{
            contacter:{
                required:"请输入联系人",
                numCheck:"联系人不能为纯数字",
                userNamecheck:"联系人不能有非法字符"
            },
            contacter_mail:{
                required:"请输入联系人邮箱",
                email:"邮箱格式不正确"
            },
            //yyzz_img:{required:'请上传营业执照副本'},
            contacter_phone:{
                isTelNo:"请填写正确的座机号",
                checkpmmust:"手机号和座机任选其一"
            },
            contacter_mobile:{
                isMobile:"请填写正确的手机号",
                checkpmmust:"手机号和座机任选其一"
            }
        },
        submitHandler:function(form) {
            if ($("#is_orgemail").val() != 1) {
                if ($("#yyzz_id").attr("data-show") == 0) {
                    if ($("#yyzz_id").val().length == 0) {
                        $("#weiscyyzz").show();
                        $("#yyzz_id").attr("data-show", 1);
                        return;
                    }
                }
            } else {}
            $("#comExtraForm").ajaxSubmit({
                url:"/company/extra",
                type:"POST",
                dataType:"json",
                beforeSubmit:function() {
                    $("#sub_extra").val("正在提交...").attr("disabled", true);
                },
                success:function(data) {
                    if (data.status == 1) {
                        window.location.href = data.url;
                    } else {
                        layer.msg(data.msg, {
                            icon:5
                        });
                        $("#sub_extra").val("重新提交").removeAttr("disabled");
                    }
                }
            });
        }
    });
    //图片上传
    $("#yyzz_img").change(function() {
        var fname = $("#yyzz_img").val();
        if (fname) {
            if (/\.(jpg|jpeg|png)$/i.test(fname)) {
                $("#yyzzForm").submit();
            } else {
                layer.msg("格式不正确", {
                    icon:5
                });
            }
        }
        return;
    });
    //上传营业执照
    $("#yyzzForm").validate({
        //   errorPlacement : function(error, element) { 
        //     if(element.attr('name') == 'yyzz'){
        //         error.appendTo(element.parent().parent());
        //     }
        //     // else{
        //     //     error.appendTo(element.prev().prev());
        //     // }
        // }, 
        errorLabelContainer:"#error",
        ignore:"",
        onkeyup:false,
        rules:{},
        messages:{},
        submitHandler:function(form) {
            $("#yyzzForm").ajaxSubmit({
                url:"/picUpload",
                type:"POST",
                data:{
                    name:"yyzz_img"
                },
                dataType:"json",
                beforeSubmit:function() {
                    var index = layer.load(1, {
                        shade:[ .1, "#fff" ]
                    });
                },
                success:function(data) {
                    if (data.status == 1) {
                        layer.closeAll();
                        layer.msg("上传成功！", {
                            icon:1
                        });
                        //var html = '<img src="'+data.path+'"/>';
                        $("#js_yyzz_show").attr("src", data.path);
                        //$('.img-box').append(html);
                        $("#yyzz_id").val(data.file_id);
                    } else {
                        layer.closeAll();
                        layer.msg(data.msg, {
                            icon:5
                        });
                    }
                }
            });
        }
    });
});