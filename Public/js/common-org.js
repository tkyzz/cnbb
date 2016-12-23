    $(function(){
    //企业通用登录
    $("body").delegate("#ty_login", "click", function() {
        //var emailTest = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        var emailTest = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var msg = "请填写正确的邮箱或手机号";
        var phoneTest = /^1\d{10}$/;
        var username = $("#username").val();
        var password = $("#password").val();
        var url_return = $("#url_return").val();
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
        $("#ty_login").val("登录中...").attr("disabled", true);
        $.post("/hrLogin", {
            phone:username,
            password:password,
            is_keep:0
        }, function(data) {
            if (data.status == 1) {
                $("#log_pwd").val("123123412341123123412341");
                $("#ty_login").val("登录成功");
                window.location.href = window.location.href;
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
                //$('#password').val(password);
                $("#ty_login").val("登录").removeAttr("disabled");
            }
        }, "json");
    });

    })