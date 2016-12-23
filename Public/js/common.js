//省市区
function getcity(obj, code) {
    $("#" + obj).html('<option value="">请选择城市</option>');
    var html = "";
    if (code.length == 0){
        return false;
    }
    $.get("/ajax/getcity", {
        code:code
    }, function(data) {
        if (data.status == 1) {
            $.each(data.msg, function(index, obj) {
                if ($(".sx_city_code").val() == obj.code || $(".hk_city_code").val() == obj.code) {
                    html += "<option value=" + obj.code + " selected>" + obj.name + "</option>";
                } else {
                    html += "<option value=" + obj.code + ">" + obj.name + "</option>";
                }
            });
            $("#" + obj).append(html);
        }
    }, "json");
}

function explorer() {
    var explorer = navigator.userAgent;
    //ie 
    if (explorer.indexOf("MSIE") >= 0) {
        window.location.reload();
    } else if (explorer.indexOf("Firefox") >= 0) {
        window.location.href = window.location.href;
        var url = window.location.href;
        //location.replace(location);
        //if(url.indexOf('#')>-1){
        url = url.substring(0, url.indexOf("#"));
        //alert(url.indexOf(substring[, startindex]));
        //}
        // alert(location.protocol+location.hostname);
        window.location.href = url;
    } else if (explorer.indexOf("Chrome") >= 0) {
        window.location.reload();
    } else if (explorer.indexOf("Opera") >= 0) {
        window.location.href = window.location.href;
    } else if (explorer.indexOf("Safari") >= 0) {
        window.location.href = window.location.href;
    } else if (explorer.indexOf("Netscape") >= 0) {
        window.location.href = window.location.href;
    }
}

//获取二级行业
function gertrade(obj, id) {
    var html = "";
    $("#" + obj).html('<option value="">二级行业</option>');
    if (id.length == 0){
        return false;
    }
    $.get("/ajax/gettrade", {
        pid:id
    }, function(data) {
        if (data.status == 1) {
            $.each(data.info, function(index, obj) {
                html += "<option value=" + obj.id + ">" + obj.name + "</option>";
            });
            $("#" + obj).append(html);
        }
    }, "json");
}

//文本域计数
function count_text_num(obj, res) {
    $(obj).keyup(function() {
        var value = $(obj).val();
        if ($(obj).val().length >= 2e3) {
            $(obj).val(value.substring(0, 2e3));
        }
        $(res).html("<span>" + value.length + "</span>/2000");
    });
}

//身份证验证
function nunber(idcard) {
    var err = new Array();
    err[0] = "验证错误";
    err[1] = false;
    var Errors = new Array("验证通过!", "身份证号码位数不对!", "出生日期超出范围或含有非法字符!", "身份证号码校验错误!", "身份证地区非法!");
    var area = {
        11:"北京",
        12:"天津",
        13:"河北",
        14:"山西",
        15:"内蒙古",
        21:"辽宁",
        22:"吉林",
        23:"黑龙江",
        31:"上海",
        32:"江苏",
        33:"浙江",
        34:"安徽",
        35:"福建",
        36:"江西",
        37:"山东",
        41:"河南",
        42:"湖北",
        43:"湖南",
        44:"广东",
        45:"广西",
        46:"海南",
        50:"重庆",
        51:"四川",
        52:"贵州",
        53:"云南",
        54:"西藏",
        61:"陕西",
        62:"甘肃",
        63:"青海",
        64:"宁夏",
        65:"新疆",
        71:"台湾",
        81:"香港",
        82:"澳门",
        91:"国外"
    };
    var idcard, Y, JYM;
    var S, M;
    var idcard_array = new Array();
    idcard_array = idcard.split("");
    if (area[parseInt(idcard.substr(0, 2))] == null) {
        err[0] = Errors[4];
        err[1] = false;
        return err;
    }
    switch (idcard.length) {
      case 15:
        if ((parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0 || (parseInt(idcard.substr(6, 2)) + 1900) % 100 == 0 && (parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0) {
            ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;
        } else {
            ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;
        }
        if (ereg.test(idcard)) {
            err[0] = Errors[0];
            err[1] = true;
            return err;
        } else {
            err[0] = Errors[2];
            err[1] = false;
            return err;
        }
        break;

      case 18:
        //18位身份号码检测
        if (parseInt(idcard.substr(6, 4)) % 4 == 0 || parseInt(idcard.substr(6, 4)) % 100 == 0 && parseInt(idcard.substr(6, 4)) % 4 == 0) {
            ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;
        } else {
            ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;
        }
        if (ereg.test(idcard)) {
            S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7 + (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9 + (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10 + (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5 + (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8 + (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4 + (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2 + parseInt(idcard_array[7]) * 1 + parseInt(idcard_array[8]) * 6 + parseInt(idcard_array[9]) * 3;
            Y = S % 11;
            M = "F";
            JYM = "10X98765432";
            M = JYM.substr(Y, 1);
            if (M == idcard_array[17]) {
                err[0] = Errors[0];
                err[1] = true;
                return err;
            } else {
                err[0] = Errors[3];
                err[1] = false;
                return err;
            }
        } else {
            err[0] = Errors[2];
            err[1] = false;
            return err;
        }
        break;

      default:
        err[0] = Errors[1];
        err[1] = false;
        return err;
    }
}

//完善机构额外信息座机手机号
$.validator.addMethod("checkpmmust", function(value, element) {
    if ($('[name="contacter_phone"]').val() || $('[name="contacter_mobile"]').val()) {
        return true;
    } else {
        return false;
    }
}, "座机、手机号最少填一项");

//不为0
$.validator.addMethod("checkNumiso", function(value, element) {
    if (value == 0) {
        return false;
    } else {
        return true;
    }
}, "请选择时间");

//不为纯数字的公司名之类的
$.validator.addMethod("checkChunNum", function(value, element) {
    //var test = '^[0-9A-Za-z\u4e00-\u9fa5]{2,14}$';
    var test = "/^[-ÿa-zA-Z.s,()（）]+$/";
    if (!test.test(value)) {
        //alert(test.test(value));
        return false;
    } else {
        return true;
    }
}, "请选择时间");

$.validator.addMethod("isEmailPhone", function(value, element) {
    var email = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    //var phone = /^[1]([3][0-9]{1}|59|50|58|88|89)[0-9]{8}$/;
    var phone = /^1\d{10}$/;
    var msg = "请填写正确的邮箱或手机号";
    return this.optional(element) || email.test(value) || phone.test(value);
}, $.validator.format("请填写正确的邮箱或手机号"));

$.validator.addMethod("checkContactTelCode", function(value, element) {
    if ($("#telValue").val() && !$("#telCode").val()) {
        return false;
    } else {
        return true;
    }
}, "请输入电话区号");

$.validator.addMethod("checkContactTelValue", function(value, element) {
    if ($("#telCode").val() && !$("#telValue").val()) {
        return false;
    } else {
        return true;
    }
}, "请输入电话号");

//身份证验证
$.validator.addMethod("isCardNo", function(value, element) {
    var pattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    if (value.length == 0) {
        return true;
    }
    var arr = nunber(value);
    if (!arr[1]) {
        return false;
    } else {
        return true;
    }
}, "请输入正确的身份证");

//只能是中文或英文
$.validator.addMethod("isChEn", function(value, element) {
    var pattern = /(^[\u4E00-\u9FA5]+$|^[a-zA-Z]+$)/;
    if (!pattern.test(value)) {
        return false;
    } else {
        return true;
    }
}, "只能是中文或英文");

//添加方法验证
$.validator.addMethod("isTelNo", function(value, element) {
    var tel = /^[1-9]{1}\d{7}$/;
    return this.optional(element) || tel.test(value);
}, $.validator.format("电话格式不正确,7-8位数字"));

$.validator.addMethod("telcode", function(value, element) {
    var telcode = /^((\d{3})|(\d{4}))$/;
    return this.optional(element) || telcode.test(value);
}, $.validator.format("区号格式不正确"));

$.validator.addMethod("isMobile", function(value, element) {
    //var mobile = /^1\d{10}$/;/^1(3|4|5|7|8)\d{9}$/
    var mobile = /^1(3|4|5|7|8)\d{9}$/;
    return this.optional(element) || mobile.test(value);
}, $.validator.format("手机格式不正确"));

$.validator.addMethod("isQQ", function(value, element) {
    var qq = /^[1-9]\d{4,9}$/;
    return this.optional(element) || qq.test(value);
}, $.validator.format("QQ格式不正确"));

$.validator.addMethod("isMSN", function(value, element) {
    var msn = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    return this.optional(element) || msn.test(value);
}, $.validator.format("MSN格式不正确"));

$.validator.addMethod("numCheck", function(value, element) {
    if (value.length == 0) {
        return true;
    }
    return value.match(/[^0-9]/);
}, "不能只输入数字");

$.validator.addMethod("userNamecheck", function(value, element) {
    if (value.length == 0) {
        return true;
    }
    //return value.match(/^([\u4e00-\u9fa5]|[\ufe30-\uffa0]|[a-zA-Z0-9_\(\)（）])*$/);
    return value.match(/^([\u4e00-\u9fa5]|[a-zA-Z0-9_\(\)（）])*$/);
}, "请不要输入非法字符");

//获取验证码
function show_time(obj) {
    var remain = parseInt($("#sendcodetime").val()) * 1e3;
    time_distance = remain - 1e3;
    if (time_distance >= 0) {
        int_second = Math.floor(time_distance / 1e3);
        /*if (int_second < 10)
             int_second = "0" + int_second;*/
        $(obj).val(int_second + "秒后重新发送").attr("disabled", "disabled");
        $("#sendcodetime").val(int_second);
        setTimeout(function() {
            show_time(obj);
        }, 1e3);
    } else {
        $(obj).val("重新发送").removeAttr("disabled").removeClass("disabled");
        $("#sendcodetime").val(180);
    }
}

$(function() {
    //轮询   
    function chat() {
        $.post("/ajax/getmsgnum", {
            op:"get"
        }, function(data) {
            if (data.status == 1) {
                if (data.info.notice > 0) {
                    $(".notice-tag").show();
                    $(".notice-tag").html(data.info.notice);
                } else if (data.info.notice == 0) {
                    $(".notice-tag").hide();
                }
                if (data.info.deliver == 0) {
                    $(".js_feedmsg_num").hide();
                } else {
                    $(".js_feedmsg_num").show();
                }
                if (data.info.recommend == 0) {
                    $(".js_recommend_num").hide();
                } else {
                    $(".js_recommend_num").show();
                }
            }
        }, "json");
    }
    chat();
    setInterval(chat, "50000");
    //登录
    $("body").delegate("#login", "click", function() {
        var email = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        var phone = /^1(3|4|5|7|8)\d{9}$/;
        var msg = "请填写正确的邮箱或手机号";
        var username = $("#username").val();
        var password = $("#password").val();
        var url_return = $("#url_return").val();
        var is_keep = $("#keep").attr("checked");
        if (is_keep == "checked") {
            is_keep == 1;
        } else {
            is_keep == 0;
        }
        if (username.length == 0 || password.length == 0) {
            layer.msg("请输入用户名和密码！", {
                icon:5
            });
            return false;
        }
        if (!(email.test(username) || phone.test(username))) {
            layer.msg("用户名不正确！", {
                icon:5
            });
            return false;
        }
        $("#login").val("登录中...").attr("disabled", true);
        $.post("login", {
            username:username,
            password:password,
            return_url:url_return,
            is_keep:is_keep
        }, function(data) {
            if (data.status == 1) {
                $("#password").val("123123412341123123412341");
                $("#login").val("登录成功");
                //url是否有效
                //if(data.url.indexOf('http://'+window.location.host)>-1){
                if (data.url.indexOf("http://") > -1) {
                    window.location.href = data.url;
                } else {
                    window.location.href = "/index.html";
                }
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
    //更改隐藏域
    $("body").delegate(".phonecli", "click", function() {
        $("#is_phone").val(1);
        $("#mt").val("1");
        $("#module2").removeAttr("disabled");
        $(".js_wsqy").show();
    });
    $("body").delegate(".emailcli", "click", function() {
        $("#module1").attr("checked", true);
        $("#mt").val("1");
        $("#module2").attr("disabled", true);
        $(".js_wsqy").hide();
        $("#is_phone").val(0);
    });
    $("body").delegate("#module1", "click", function() {
        $(".invite-code").show();
        $(".emailcli").show();
        $("#mt").val(1);
    });
    $("body").delegate("#module2", "click", function() {
        $(".invite-code").hide();
        $(".emailcli").hide();
        $("#mt").val(2);
    });
    //注册
    $(".js_phone").keyup(function() {
        if ($(".js_send_phone_code").val() == "重新发送") {
            $(".js_send_phone_code").val("获取验证码");
        }
    });
    // 验证码生成  
    var captcha_img = $(".js_verifyImg");
    var verifyimg = captcha_img.attr("src");
    captcha_img.attr("title", "点击刷新");
    $(".code-img").click(function() {
        if (verifyimg.indexOf("?") > 0) {
            captcha_img.attr("src", verifyimg + "&random=" + Math.random());
        } else {
            captcha_img.attr("src", verifyimg.replace(/\?.*$/, "") + "?" + Math.random());
        }
    });
    //注册
    $("#signup").click(function() {
        var phoneTest = /^1(3|4|5|7|8)\d{9}$/;
        var username = $(".js_phone").val();
        var password = $("#phonepassword").val();
        var code = $("#inviteCode").val();
        var verify = $("#smsCode").val();
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
        code = code ? code :0;
        $("#signup").val("注册中...").attr("disabled", true);
        if ( username ){
            _hmt.push(['_trackEvent', '学生注册流程监控', username , '注册提交']);
        }
        $.post("/register", {
            username:username,
            password:password,
            verify:verify,
            mt:1,
            code:code
        }, function(data) {
            if (data.status == 1) {
                if (data.is_phone == 0) {
                    data.url = data.url + "?email=" + data.email;
                }
                $("#phonepassword").val("123123412341123123412341");
                if ( username ){
                    _hmt.push(['_trackEvent', '学生注册流程监控', username , '注册成功']);
                }
                window.location.href = data.url;
            } else {
                $("#signup").val("注册").removeAttr("disabled");
                layer.msg(data.info, {
                    icon:5
                });
            }
        }, "json");
    });
    //学生发送验证码
    $(".js_send_phone_code").click(function() {
        var verify = $(".verify_code").val();
        var phoneTest = /^1(3|4|5|7|8)\d{9}$/;
        var phone = $(".js_phone").val();
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
        $.post("/sendCode", {
            phone:phone,
            usage:usage,
            verify:verify,
            type:type
        }, function(data) {
            if (data.status == 1) {
                // alert(data.info);
                _hmt.push(['_trackEvent', '学生注册流程监控', phone , '获取验证码']);
                show_time(".js_send_phone_code");
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
    //邮箱找回密码
    $("#next_email").click(function() {
        var email = $(".js_email_reset_password").val();
        var emailauth = /^([a-zA-Z0-9]+[_|\_|\-\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (!emailauth.test(email)) {
            return true;
        } else {
            $.post("mailReset", {
                email:email
            }, function(data) {
                if (data.status == 0) {
                    $(".js_send_email").text(email);
                    $(".input_email").hide();
                    $(".show_email").show();
                } else {
                    alert(data.info);
                }
            }, "json");
        }
    });
    //$('#kf5-support-btn').click();
    //手机找回密码
    $("#next_phone").click(function() {
        var phone = $(".js_phone").val();
        var phoneauth = /^1\d{10}$/;
        var code = $(".js_phone_reset_code").val();
        var verify = $(".verify_code").val();
        if (!phoneauth.test(phone)) {
            layer.msg("手机号不正确", {
                icon:5
            });
            return false;
        }
        // if(verify.length != 4){
        //     layer.msg("请输入四位图形验证码", {icon: 5});
        //     return false;
        // }
        if (code.length != 4) {
            layer.msg("请输入手机验证码", {
                icon:5
            });
            return false;
        }
        $.post("/checkPhonecode", {
            phone:phone,
            code:code,
            usage:2
        }, function(data) {
            if (data.status == 1) {
                $(".input_phone").hide();
                $(".js_reset_password").show();
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
            }
        }, "json");
    });
    $(".js_sub_reset_pwd").click(function() {
        var type = $("#type").val();
        var phone = $(".js_phone").val();
        var code = $(".js_phone_reset_code").val();
        var password = $("#new_pwd").val();
        if (password != $("#t_new_pwd").val()) {
            layer.msg("两次密码不一致！", {
                icon:5
            });
            return;
        }
        $.post("/phoneReset", {
            phone:phone,
            code:code,
            password:password
        }, function(data) {
            if (data.status == 1) {
                layer.msg("修改成功！", {
                    icon:6
                });
                if (type == "company") {
                    window.location.href = "/hrLogin.html";
                } else {
                    window.location.href = "/login.html";
                }
            } else {
                alert(data.info);
            }
        }, "json");
    });
    //修改密码
    $(".js_change_pwd").click(function() {
        var oldpassword = $("#oldPassword").val();
        var newpassword = $("#newPassword").val();
        var surepassword = $("#surePassword").val();
        if (oldpassword.length == 0) {
            layer.tips("当前密码不能为空", "#oldPassword");
            //layer.msg("当前密码不能为空", {icon: 5});
            return false;
        }
        if (newpassword.length == 0) {
            layer.tips("新密码不能为空", "#newPassword");
            //layer.msg("新密码不能为空", {icon: 5});
            return false;
        }
        if (surepassword.length == 0) {
            layer.tips("请输入确认密码", "#surePassword");
            //layer.msg("请再次输入新密码", {icon: 5});
            return false;
        }
        if (newpassword != surepassword) {
            layer.msg("两次密码不一致！", {
                icon:7
            });
            return false;
        }
        if (oldpassword == surepassword) {
            layer.msg("原密码和新密码相同", {
                icon:7
            });
            return false;
        }
        $(".js_change_pwd").text("提交中").attr("disabled", true);
        $.post("/userInfo/changePwd", {
            oldpassword:oldpassword,
            newpassword:newpassword
        }, function(data) {
            if (data.status == 1) {
                $(".js_change_pwd").text("修改成功");
                setTimeout(function() {
                    window.location.href = data.url;
                }, 500);
            } else {
                $(".js_change_pwd").text("保存").attr("disabled", false);
                layer.msg(data.info, {
                    icon:5
                });
            }
        }, "json");
    });
    //简历实习省市联动
    $(".sx_prov").change(function() {
        var code = $(".sx_prov option:selected").val();
        var obj = "sx_city";
        getcity(obj, code);
    });
    //简历户口省市联动
    $(".hk_prov").change(function() {
        var code = $(".hk_prov option:selected").val();
        var obj = "hk_city";
        getcity(obj, code);
    });
    $(".js_baseinfo_edit").click(function() {
        var sx_code = $(".sx_prov  option:selected").val();
        var hk_code = $(".hk_prov  option:selected").val();
        getcity("sx_city", sx_code);
        getcity("hk_city", hk_code);
    });
    //是否为邮箱
    function isEmail(s) {
        if (!/(\S)+[@]{1}(\S)+[.]{1}(\w)+/.test(s)) {
            return false;
        }
        return true;
    }
    //点击激活提交
    $(".js_baseinfo_save").click(function() {
        if ($("#resumebaseForm").valid()) {
            $("#resumebaseForm").submit();
        }
    });
    //简历个人信息
    $("#resumebaseForm").validate({
        //   errorPlacement : function(error, element) { 
        //     console.log(error);
        //     if(element.attr('name') == 'hk_type'){
        //         error.appendTo(element.parent().parent());
        //     }else{
        //         error.outerHTML = '<label id="email-error" class="error" for="email">请填写邮箱SB</label>';
        //         error.appendTo(element.parent());
        //     }
        // }, 
        //     ignore: ":hidden",
        //     
        errorLabelContainer:"#info_error",
        onkeyup:false,
        rules:{
            full_name:{
                required:true,
                isChEn:true
            },
            mobile:{
                required:true,
                isMobile:true
            },
            gender:{
                required:true
            },
            email:{
                required:true,
                email:true
            },
            birthday:{
                required:true
            },
            height:{
                range:[ 100, 300 ]
            },
            province_id:{
                required:true
            },
            city_id:{
                required:true
            },
            hk_type:{
                required:true
            },
            hk_province_id:{
                required:true
            },
            hk_city_id:{
                required:true
            },
            card_type:{
                required:true
            },
            card_no:{
                isCardNo:true
            },
            address:{
                required:true,
                numCheck:true,
                userNamecheck:true
            }
        },
        messages:{
            full_name:{
                required:"请输入姓名",
                isChEn:"姓名只能是中文或英文"
            },
            mobile:{
                required:"请填写手机号",
                isMobile:"请填写正确的手机号"
            },
            gender:{
                required:"性别必选"
            },
            email:{
                required:"请填写邮箱",
                email:"请输入正确的邮箱"
            },
            birthday:{
                required:"出生年月为必填"
            },
            height:{
                range:"身高不正确"
            },
            province_id:{
                required:"实习省"
            },
            city_id:{
                required:"实习市"
            },
            hk_type:{
                required:"请选择户口类型"
            },
            hk_province_id:{
                required:"户口省"
            },
            hk_city_id:{
                required:"户口市"
            },
            card_type:{
                required:"证件类型"
            },
            card_no:{
                isCardNo:"请输入正确的身份证号"
            },
            address:{
                required:"详细地址必填",
                numCheck:"地址不能为纯数字",
                userNamecheck:"地址不能有非法字符"
            }
        },
        submitHandler:function(form) {
            $("#resumebaseForm").ajaxSubmit({
                url:"/ajax/updateResume",
                type:"POST",
                dataType:"json",
                beforeSubmit:function() {
                    $(form).find(".js_baseinfo_save").val("提交中...").attr("disabled", true);
                },
                success:function(data) {
                    if (data.status == 1) {
                        $(form).find(".js_baseinfo_save").val("保存成功").removeAttr("disabled");
                        $(form).find('[name="id"]').val(data.res.result);
                        $.ajax({
                            async:false,
                            type:"POST",
                            url:"/get_resumeInfo",
                            data:{
                                id:$(form).find('[name="resume_id"]').attr("data-id")
                            },
                            dataType:"json",
                            success:function(data) {
                                if (data.status == 1) {
                                    $(".js_info_show").html("");
                                    $(".js_info_show").append(data.html);
                                    $(form).find('[name="type"]').val("base_update");
                                    $(".js_info_box").find(".js_baseinfo_save").val("保存").removeAttr("disabled");
                                    $(".js_info_box").find(".profile-edit").hide();
                                    $(".js_info_box").find(".profile-show").show();
                                    var url = $("a.preview").attr("data-url");
                                    $("a.preview").attr("href", url).removeAttr("onclick");
                                } else {
                                    layer.msg(data.msg, {
                                        icon:5
                                    });
                                }
                            }
                        });
                    } else {
                        layer.msg(data.msg, {
                            icon:5
                        });
                        $(form).find(".js_baseinfo_save").val("保存").attr("disabled", false);
                    }
                }
            });
        }
    });
    // $('.stag').click(function(){
    //     var tag="";
    //         $(".stag").each(function (index,i) {//循环写入隐藏域
    //         tag+= $('.stag').has('checked').val()+'/';
    //     });
    //     alert(tag);
    // });
    //  职位岗位
    $(".jzsx").click(function() {
        $("#partTimeSelection").show();
    });
    $(".jqsx").click(function() {
        $("#partTimeSelection").hide();
    });
    //个人信息标签
    //$('.stag').on('click',function(){
    $("body").delegate(".stag", "click", function() {
        var str = "";
        var spans = new Array();
        var obj = $(this);
        //var objp = obj.parents("div");
        //var num = objp.find('span.active').size();
        $("#hint").text("");
        //alert(obj.is(':checked'));
        if (obj.is(":checked")) {
            //alert(obj.attr("checked"));
            //$('#sub-ship').removeAttr('disabled');
            obj.attr("checked", true);
        } else {
            obj.removeAttr("checked");
        }
        $(".stag:checked").each(function(i) {
            spans[i] = $(this).val();
        });
        str = spans.join("|");
        $('input[name="tags"]').val(str);
    });
});