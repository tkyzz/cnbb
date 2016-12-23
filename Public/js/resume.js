//    newProfile sidebar is fixed
//裁剪头像
function caijian($id) {
    var image = document.getElementById($id);
    var cropper = new Cropper(image, {
        aspectRatio:1 / 1,
        resizable:false,
        minContainerWidth:240,
        minContainerHeight:240,
        //autoCropArea:1,
        crop:function(e) {
            $("#pic_x").val(Math.round(e.detail.x));
            $("#pic_y").val(Math.round(e.detail.y));
            $("#pic_w").val(Math.round(e.detail.width));
            $("#pic_h").val(Math.round(e.detail.height));
        }
    });
}

function GetFileSize(fileId) {
    var dom = document.getElementById(fileId);
    return dom.files[0].size;
}

function testFileSize() {
    alert("文件大小=" + GetFileSize("avatar_file"));
}

//文本计数
function tj_text_num(obj, res, lenth) {
    //alert(1);
    obj.keyup(function() {
        var len = obj.val().length;
        var value = obj.val();
        if (len >= lenth) {
            len = lenth;
        }
        res.html("<span><span>" + len + "</span>/" + lenth + "</span>字");
    });
}

$(function() {});

//图片上传
$("#avatar_file").change(function() {
    var img = new Image();
    var fname = $("#avatar_file").val();
    var size = GetFileSize("avatar_file");
    //var filesize = $(this).files.item(0).fileSize;
    //alert(filesize);
    //console.log($(this));
    if (fname) {
        if (/\.(jpg|jpeg|png)$/i.test(fname)) {
            if (size > 5242880) {
                $("#avatar_file").val("");
                layer.msg("图片太大了,为" + parseInt(size / 1024 / 1024) + "MB左右", {
                    icon:2
                });
            } else {
                $("#avatarform").submit();
            }
        } else {
            $("#avatar_file").val("");
            layer.msg("上传格式不正确", {
                icon:2
            });
        }
    }
    return;
});

$("#avatarform").validate({
    rules:{},
    messages:{},
    submitHandler:function(form) {
        $("#avatarform").ajaxSubmit({
            async:false,
            dataType:"json",
            data:{
                name:"avatar_file",
                type:"noapi"
            },
            url:"/picUpload",
            beforeSubmit:function() {},
            success:function(data) {
                if (data.status == 1) {
                    $("#pic_name").val(data.path);
                    //$('#logo_name').val(data.name);
                    //$('#logo_ext').val(data.ext);
                    layer.open({
                        type:1,
                        btn:[ "确定" ],
                        title:"裁剪头像",
                        //skin: 'layui-layer-rim', //加上边框
                        fix:false,
                        scrollbar:false,
                        shift:4,
                        area:[ "600px", "450px" ],
                        //宽高
                        content:'<img id="image" src="' + data.path + '" height="800" width="600">',
                        yes:function(index, layero) {
                            layer.close(index);
                            var filename = $("#pic_name").val();
                            var pic_x = $("#pic_x").val();
                            var pic_y = $("#pic_y").val();
                            var pic_w = $("#pic_w").val();
                            var pic_h = $("#pic_h").val();
                            //layer.msg('请稍候……');
                            $.post("/ajax/upload", {
                                filename:filename,
                                pic_x:pic_x,
                                pic_y:pic_y,
                                pic_w:pic_w,
                                pic_h:pic_h
                            }, function(data) {
                                if (data.status == 1) {
                                    var html = '<img src="' + data.path + '"/>';
                                    $(".js_avatar_show").html("");
                                    //$(".my-avatar").html("");
                                    $(".js_avatar_show").append(html);
                                    //  $(".my-avatar").append(html);
                                    $("#avatar_id").val(data.file_id);
                                    //window.location.href="/post/"+org_id+"/deliver.html";
                                    layer.msg("上传成功", {
                                        icon:1
                                    });
                                } else if (data.status == 0) {
                                    layer.msg(data.msg, {
                                        icon:5
                                    });
                                }
                            }, "json").error(function() {
                                layer.msg("图片错误，无法裁剪", {
                                    icon:5
                                });
                            });
                        },
                        cancel:function(index, layero) {
                            $("#avatar_file").val("");
                            layer.close(index);
                        }
                    });
                    caijian("image");
                    $("#avatar_file").val("");
                } else {
                    ///showDialogInfo(data.msg);
                    $("#avatar_file").val("");
                    layer.msg(data.msg, {
                        icon:2
                    });
                }
            }
        });
    }
});

//简历详情 创建简历
$("#js_resume_name").blur(function() {
    var name = $("#js_resume_name").val();
    var name_cmp = $("#js_resume_name_bak").val();
    var id = $("#js_resume_name").attr("data-id");
    var type = "";
    if (name == name_cmp) {
        return false;
    }
    if (name.length == 0 || id.length == 0) {
        type = "create";
    } else {
        type = "update";
    }
    $.post("/ajax/createUpdateResume", {
        name:name,
        id:id,
        type:type
    }, function(data) {
        if (data.status == 1) {
            // alert(data.msg);
            layer.msg("简历名称修改成功！", {
                icon:6,
                time:1e3
            });
            $("#js_resume_name_bak").val(name);
        } else {}
    }, "json");
});

//设置简历公开度
$(".js_re_open").click(function() {
    var name = $("#js_resume_name_bak").val();
    var id = $("#js_resume_name").attr("data-id");
    var open_level = $(this).val();
    if (name.length == 0 || id.length == 0) {
        return false;
    }
    $.post("/ajax/createUpdateResume", {
        name:name,
        id:id,
        open_level:open_level,
        type:"update"
    }, function(data) {
        if (data.status == 1) {
            // alert(data.msg);
            $("#js_resume_name_bak").val(name);
        } else {}
    }, "json");
});

//    workDays show/hide
$("#jzsx").click(function() {
    $("#workDays").show();
});

$("#jqsx").click(function() {
    $("#workDays").hide();
});

//   点击职能选择
$("#post").click(function() {
    $("#postSelect").show();
});

//实习经验获取行业
$("#postSelect").find(".js-post-choose").children("li").click(function() {
    var val = $(this).attr("data-id");
    var trade_id = $("#industry").attr("data-id");
    if (typeof trade_id == "undefined") {
        layer.msg("请先选择行业", {
            icon:5
        });
        return false;
    }
    $(this).addClass("active").siblings().removeClass("active");
    $.get("/ajax/getwfs", {
        id:val
    }, function(data) {
        if (data.status == 1) {
            //console.log(data);
            $("#postSelect").find(".post-choose").html("");
            var html = "";
            $.each(data.info, function(index, obj) {
                if (trade_id == obj.trade_id) {
                    html += "<li data-id=" + obj.id + ">" + obj.name + "</li>";
                }
            });
            $("#postSelect").find(".post-choose").append(html);
        }
    }, "json");
});

$("#postSelect").find(".post-choose").delegate("li", "click", function() {
    var val = $(this).text();
    var id = $(this).attr("data-id");
    $(this).addClass("active").siblings().removeClass("active");
    $("#post").val(val);
    $("#post").attr("data-id", id);
    $("#postSelect").hide();
    $("#internshipForm").find('[name="function"]').val(id);
});

//   点击二级行业
$("#industry").click(function() {
    $("#industrySelect").show();
});

$("#industrySelect").find(".post-choose").delegate("li", "click", function() {
    var val = $(this).text();
    var id = $(this).attr("data-id");
    $(this).addClass("active").siblings().removeClass("active");
    $("#industry").val(val);
    $("#industry").attr("data-id", id);
    $("#industrySelect").hide();
    $("#internshipForm").find('[name="sub_trade"]').val(id);
});

//实习经验获取行业
$("#industrySelect").find(".js-trade-choose").children("li").click(function() {
    var val = $(this).attr("data-id");
    $(this).addClass("active").siblings().removeClass("active");
    $.get("/ajax/gettrade", {
        pid:val
    }, function(data) {
        if (data.status == 1) {
            //console.log(data);
            $("#industrySelect").find(".post-choose").html("");
            var html = "";
            $.each(data.info, function(index, obj) {
                html += "<li data-id=" + obj.id + ">" + obj.name + "</li>";
            });
            $("#industrySelect").find(".post-choose").append(html);
            $("#internshipForm").find('[name="trade"]').val(val);
        }
    }, "json");
});

//教育经历省获取学校
$("body").delegate(".js_get_school li", "click", function() {
    var code = $(this).attr("value");
    $(this).addClass("active");
    $.get("/ajax/ProvinceSchool", {
        code:code
    }, function(data) {
        if (data.status == 1) {
            $(".school").html("");
            var html = "";
            $.each(data.info, function(index, obj) {
                if (obj.name.length > 14) {
                    //alert(obj.name);
                    obj.name = obj.name.substring(0, 13);
                }
                html += "<li value=" + obj.id + ">" + obj.name + "</li>";
            });
            $(".school").append(html);
        }
    }, "json");
});

// //点击提交求职意向
// $(".intention_save").click(function(){
//     if($("#resume_intention").valid()){
//      $("#resume_intention").submit();
//  }
// });
// //求职意向
// $('#resume_intention').validate({
// //   errorPlacement : function(error, element) { 
// //   error.appendTo(element.parent().next());
// // }, 
// errorLabelContainer: "#intention_error",
//    // ignore: ":hidden",
//     onkeyup: false,
//     rules : {
//         work_cities_id:{required:true},
//         work_type:{required:true},
//         week_workdays:{required:true},
//         work_duration:{required:true},
//     },
//     messages : {
//         work_cities_id:{required:'请选择期望城市'},
//         work_type:{required:'请选择工作性质'},
//         week_workdays:{required:'请选择每周工作天数'},
//         work_duration:{required:'请选择连续实习时长'},
//     },
//     submitHandler:function(form) {
//         $('#resume_intention').ajaxSubmit({
//             url:'/ajax/updateResume',
//             type:'POST',
//             dataType:'json',
//             beforeSubmit:function(){
//               if($(form).find('[name="work_cities_id"]').val().length == 0){
//                 layer.msg('请选择期望的工作地点', {icon: 5});
//               }
//               if($(form).find('[name="trade_id"]').val().length == 0){
//                 layer.msg('请选择期望的行业', {icon: 5});
//               }
//                 $(form).find('.save').val('提交中...').attr('disabled',true);
//             },
//             success:function(data){
//                 //setTimeout(function(){ window.location.href=data.url; },50000);
//                 if (data.status == 1) {
//                   window.location.reload();
//                 var id = data.res.result;
//                 var data = data.param;
//                 if($(form).find('[name="duration"]').is(':checked')){
//                   var duration = '不限';
//                 }else{
//                   //alert($(form).find('[name="duration"]').is('checked'));
//                  var duration = $(form).find('.js_duration_show').text();
//                 }
//                 if($(form).find('[name="work_type"]:checked').val() == 1){
//                   var work_type = '假期';
//                   $(form).prev().find('.sub-info-duration').remove();
//                 }else{
//                    var work_type = '日常';
//                    var html = '<div class="sub-info subfield sub-info-duration"><span>连续实习时长：<span class="profile-show-duration">'+duration+'</span></span></div>';
//                   $(form).prev().find('.sub-info-duration').remove();
//                   $(form).prev().find('.sub-info:eq(4)').after(html);
//                 }
//                 if($(form).find('[name="arrive_days"] option:selected').val()==0){
//                   var arrive = '待定';
//                 }else{
//                   var arrive = $(form).find('[name="arrive_days"] option:selected').val()+'天内';
//                 }
//                 //alert($(form).find('[name="arrive_days"] option:selected').text());
//                 $(form).prev().find('.profile-show-city').text($(form).find('[name="work_cities_name"]').val());
//                 $(form).prev().find('.profile-show-trade').text($(form).find('[name="trade_name"]').val());
//                 $(form).prev().find('.profile-show-worktype').text(work_type);
//                 $(form).prev().find('.profile-show-arrive').text(arrive);
//                 $(form).prev().find('.profile-show-weekday').text($(form).find('[name="week_workdays"]:checked').next().text());
//                 //$(form).prev().find('.profile-show-duration').text(duration);
//                 $(form).find('[name="id"]').val(id);//设置id
//                 $(form).find('[name="type"]').val('intention_update');//设置更新状态
//                 $(form).find('.profile-edit').hide();
//                 $(form).prev().show();
//                 $(form).find('.save').val('保存').removeAttr('disabled');
//                 //console.log($(form).prev().find('.sub-info').eq(0).text());
//                 } else {
//                     $(form).find('.save').val('保存').removeAttr('disabled');
//                 }
//             }
//         });
//     }
// });
//编辑个人信息
$("body").delegate(".js_baseinfo_edit", "click", function() {
    $(".js_info_show").hide();
    $(".js_info_show").next().show();
});

//删除教育经历
$("#js_edu_del").click(function() {
    var edu_id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    layer.confirm("确定删除教育经历: " + name + "？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            edu_id:edu_id,
            type:"edu_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//编辑获取教育经历
$("body").delegate(".js_edu_edit", "click", function() {
    var id = $(this).attr("data-id");
    $.get("/ajax/getEduDetail", {
        id:id
    }, function(data) {
        if (data.status == 1) {
            var sch_arr = [ "1", "2", "3", "4" ];
            var info = data.info;
            //console.log(data.info);
            $("#school_name").val(info.school_name).attr("data-id", info.school_id).attr("data-provid", info.province_code);
            $("#syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#eyear").find("option[value='" + info.eyear + "']").prop("selected", true);
            $("#emonth").find("option[value='" + info.emonth + "']").prop("selected", true);
            $("#degree" + info.degree).prop("checked", "checked");
            $("#major_category_id").find("option[value='" + info.major_category_id + "']").prop("selected", true);
            $("#major").val(info.major);
            $("#major").parent().next().html("<span><span>" + info.major.length + "</span>/10</span>字");
            if (info.second_major != null) {
                $("a.second-specialty").hide();
                $(".secmajor").show();
                $("#second_major_category_id").find("option[value='" + info.second_major_category_id + "']").prop("selected", true);
                $("#second_major").val(info.second_major);
            } else {
                $("a.second-specialty").show();
                $(".secmajor").hide();
            }
            $("#faculty").val(info.faculty);
            $("#bp").val(info.bp);
            $("#rank").val(info.rank);
            $("#edu_id").val(info.id);
            $("#edu_type").val("edu_update");
            $("#js_edu_del").attr("data-id", info.id).attr("data-name", info.school_name).show();
            $(".js_edu_del").show();
            $("#resume_edu").prev(".profile-show").hide();
            $("#resume_edu").find(".profile-edit").show();
            $("#resume_edu").find(".block-append").hide();
            $("#resume_edu").find(".level-info").show();
        } else {}
    }, "json");
});

//点击提交教育经历
$("body").delegate(".edu_save", "click", function() {
    if ($("#resume_edu").valid()) {
        $("#resume_edu").submit();
    }
});

function compareDate(sdate, edate) {
    sdate = new Date(sdate.replace(/-/g, "/"));
    edate = new Date(edate.replace(/-/g, "/"));
    //alert(sdate);
    if (Date.parse(sdate) - Date.parse(edate) > 0) {
        return false;
    }
    return true;
}

// 验证身份证 
function isCardNo(card) {
    return pattern.test(card);
}

//教育经历起止时间
$.validator.addMethod("checkEduTime", function(value, element) {
    if ($("#eyear").val() == "0" && $("#emonth").val() == "0") {
        return true;
    } else {
        if (!compareDate($("#syear").val() + "-0" + $("#smonth").val() + "-01", $("#eyear").val() + "-0" + $("#emonth").val() + "-01")) {
            return false;
        } else {
            return true;
        }
    }
}, "开始时间不能大于结束时间");

//项目经历起止时间
$.validator.addMethod("checkProjectTime", function(value, element) {
    if ($("#project_eyear").val() == "0" && $("#project_emonth").val() == "0") {
        return true;
    } else {
        if (!compareDate($("#project_syear").val() + "-0" + $("#project_smonth").val() + "-01", $("#project_eyear").val() + "-0" + $("#project_emonth").val() + "-01")) {
            return false;
        } else {
            return true;
        }
    }
}, "开始时间不能大于结束时间");

//交换经历起止时间
$.validator.addMethod("checkJhTime", function(value, element) {
    if ($("#jh_eyear").val() == "0" && $("#jh_emonth").val() == "0") {
        return true;
    } else {
        if (!compareDate($("#jh_syear").val() + "-0" + $("#jh_smonth").val() + "-01", $("#jh_eyear").val() + "-0" + $("#jh_emonth").val() + "-01")) {
            return false;
        } else {
            return true;
        }
    }
}, "开始时间不能大于结束时间");

//校内职位起止时间
$.validator.addMethod("checkScjobTime", function(value, element) {
    if ($("#scjob_eyear").val() == "0" && $("#scjob_emonth").val() == "0") {
        return true;
    } else {
        if (!compareDate($("#scjob_syear").val() + "-0" + $("#scjob_smonth").val() + "-01", $("#scjob_eyear").val() + "-0" + $("#scjob_emonth").val() + "-01")) {
            return false;
        } else {
            return true;
        }
    }
}, "开始时间不能大于结束时间");

//社会实践起止时间
$.validator.addMethod("checkPracticeTime", function(value, element) {
    if ($("#practice_eyear").val() == "0" && $("#practice_emonth").val() == "0") {
        return true;
    } else {
        if (!compareDate($("#practice_syear").val() + "-0" + $("#practice_smonth").val() + "-01", $("#practice_eyear").val() + "-0" + $("#practice_emonth").val() + "-01")) {
            return false;
        } else {
            return true;
        }
    }
}, "开始时间不能大于结束时间");

//实习起止时间
$.validator.addMethod("checkInternshipTime", function(value, element) {
    if ($("#internship_eyear").val() == "0" && $("#internship_emonth").val() == "0") {
        return true;
    } else {
        if (!compareDate($("#internship_syear").val() + "-0" + $("#internship_smonth").val() + "-01", $("#internship_eyear").val() + "-0" + $("#internship_emonth").val() + "-01")) {
            return false;
        } else {
            return true;
        }
    }
}, "开始时间不能大于结束时间");

//教育经历
$("#resume_edu").validate({
    errorPlacement:function(error, element) {
        error.appendTo(element.parent().next());
    },
    errorLabelContainer:"#edu_error",
    ignore:":hidden",
    onkeyup:false,
    rules:{
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true,
            checkEduTime:true
        },
        school_name:{
            required:true
        },
        degree:{
            required:true
        },
        faculty:{
            numCheck:true,
            userNamecheck:true
        },
        major_category_id:{
            required:true
        },
        major:{
            required:true,
            numCheck:true,
            userNamecheck:true
        },
        bp:{
            range:[ 0, 5 ]
        },
        rank:{
            digits:true,
            range:[ 0, 100 ]
        }
    },
    messages:{
        syear:{
            required:"入学时间为必填",
            checkNumiso:"入学年份为必选"
        },
        smonth:{
            required:"入学时间为必填",
            checkNumiso:"入学月份为必选",
            checkEduTime:"开始时间不能大于结束时间"
        },
        school_name:{
            required:"学校为必选"
        },
        degree:{
            required:"学历为必选"
        },
        faculty:{
            numCheck:"院系不能为纯数字",
            userNamecheck:"院系不能有非法字符"
        },
        major_category_id:{
            required:"专业为必选"
        },
        major:{
            required:"专业为必填",
            numCheck:"专业不能为纯数字",
            userNamecheck:"专业不能有非法字符"
        },
        bp:{
            range:"绩点在0-5之间"
        },
        rank:{
            digits:"排名必须是数字",
            range:"排名0-100之间"
        }
    },
    submitHandler:function(form) {
        $("#resume_edu").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            data:{
                major_category_name:$("#major_category_id option:selected").text(),
                second_major_category_name:$("#second_major_category_id option:selected").text(),
                school_id:$('input[name="school_name"]').attr("data-id"),
                school_provid:$('input[name="school_name"]').attr("data-provid")
            },
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                if (data.status == 1) {
                    if ($(form).find('[name="type"]').val() == "edu_create") {
                        var name = $(form).find('[name="school_name"]').val();
                        var syear = $(form).find('[name="syear"]').val();
                        var smonth = $(form).find('[name="smonth"]').val();
                        var eyear = $(form).find('[name="eyear"]').val();
                        var emonth = $(form).find('[name="emonth"]').val();
                        var edate = "";
                        if (eyear == 0 || emonth == 0) {
                            edate = "至今";
                        } else {
                            edate = eyear + emonth;
                        }
                        var html = '<option value="' + data.res.result + '">' + name + " " + syear + smonth + "—" + edate + "</option>";
                        $("#jh_edu_id").append(html);
                        $("#project_edu_id").append(html);
                        var sch_arr = [ "上海财经大学", "同济大学", "上海交通大学", "华东师范大学", "复旦大学" ];
                        if ($.inArray(name, sch_arr) > -1) {
                            layer.alert("童鞋，你已触发了和<" + name + ">实习总猎头组队升级的机会，还不速加微信抱大腿。<br>微信号：ruirui0320shenyang", {
                                btn:[ "本宝宝知道了" ],
                                title:"来自菜鸟帮帮的隐藏任务"
                            });
                        } else {
                            layer.alert("童鞋，你已触发了和<" + name + ">实习总猎头组队升级的机会，还不速加微信抱大腿。<br>微信号：jin_san_pang", {
                                btn:[ "本宝宝知道了" ],
                                title:"来自菜鸟帮帮的隐藏任务"
                            });
                        }
                    }
                    get_edu_ajax($(form));
                } else if (data.status == -1) {
                    layer.msg(data.msg, {
                        icon:5
                    });
                    $(form).find(".save").val("提交").removeAttr("disabled");
                } else {
                    layer.msg(data.msg, {
                        icon:5
                    });
                    $(form).find(".save").val("提交").removeAttr("disabled");
                }
            }
        });
    }
});

//获取教育经历页面
function get_edu_ajax(obj) {
    $.ajax({
        async:false,
        type:"POST",
        url:"/get_resumeEdu",
        data:{
            id:$(".js_info_box").find('[name="resume_id"]').attr("data-id")
        },
        dataType:"json",
        success:function(data) {
            if (data.status == 1) {
                $(".edu_profile_show").html("");
                $(".edu_profile_show").append(data.edu_html);
                $(".edu_exchange_profile_show").html("");
                $(".edu_exchange_profile_show").append(data.exchange_html);
                $(".edu_project_profile_show").html("");
                $(".edu_project_profile_show").append(data.project_html);
                obj.find(".save").val("保存").removeAttr("disabled");
                obj.find(".profile-edit").hide();
                obj.prev().show();
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
            }
        }
    });
}

//获取校内经历页面
function get_xnjl_ajax(obj) {
    $.ajax({
        async:false,
        type:"POST",
        url:"/get_resumeXnjl",
        data:{
            id:$(".js_info_box").find('[name="resume_id"]').attr("data-id")
        },
        dataType:"json",
        success:function(data) {
            if (data.status == 1) {
                $(".rewards-profile-show").html("");
                $(".rewards-profile-show").append(data.reward_html);
                $(".jobs-profile-show").html("");
                $(".jobs-profile-show").append(data.jobs_html);
                $(".practice-profile-show").html("");
                $(".practice-profile-show").append(data.practice_html);
                obj.find(".save").val("保存").removeAttr("disabled");
                obj.find(".profile-edit").hide();
                obj.prev().show();
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
            }
        }
    });
}

//点击证书课程
$("body").delegate(".check", "click", function() {
    //  $('.check').click(function(){
    //alert(1);
    var cid = $(".js_cert_type").selected().val();
    var str = "";
    var spans = new Array();
    var obj = $(this);
    //var objp = obj.parents("div");
    //var num = objp.find('span.active').size();
    $('input[name="courses"]').val("");
    if (cid == 5) {
        if (obj.attr("checked") == "checked") {
            //$('#sub-ship').removeAttr('disabled');
            obj.removeAttr("checked");
        } else {
            //if (num > 2) {return false; }
            obj.attr("checked", true);
            var val = obj.val();
            $(".js_cert_cousers").find('.check[value!="' + val + '"]').each(function(i) {
                $(this).removeAttr("checked");
            });
        }
    } else if (cid == 10) {
        if (obj.val() == "all") {
            if (obj.attr("checked") == "checked") {
                //$('#sub-ship').removeAttr('disabled');
                obj.removeAttr("checked");
                if (obj.hasClass("certF")) {
                    $(".js_cert_cousers").find('.certF[value!="all"]').each(function(i) {
                        $(this).removeAttr("disabled");
                    });
                } else if (obj.hasClass("certP")) {
                    $(".js_cert_cousers").find('.certP[value!="all"]').each(function(i) {
                        $(this).removeAttr("disabled");
                    });
                }
            } else {
                //if (num > 2) {return false; }
                obj.attr("checked", true);
                if (obj.hasClass("certF")) {
                    $(".js_cert_cousers").find('.certF[value!="all"]').each(function(i) {
                        $(this).attr("disabled", true).removeAttr("checked");
                    });
                } else if (obj.hasClass("certP")) {
                    $(".js_cert_cousers").find('.certP[value!="all"]').each(function(i) {
                        $(this).attr("disabled", true).removeAttr("checked");
                    });
                }
            }
        }
        if (obj.val() == "all2") {
            if (obj.attr("checked") == "checked") {
                //$('#sub-ship').removeAttr('disabled');
                obj.removeAttr("checked");
                if (obj.hasClass("certF")) {
                    $(".js_cert_cousers").find('.certF[value!="all2"]').each(function(i) {
                        $(this).removeAttr("disabled");
                    });
                } else if (obj.hasClass("certP")) {
                    $(".js_cert_cousers").find('.certP[value!="all2"]').each(function(i) {
                        $(this).removeAttr("disabled");
                    });
                }
            } else {
                //if (num > 2) {return false; }
                obj.attr("checked", true);
                if (obj.hasClass("certF")) {
                    $(".js_cert_cousers").find('.certF[value!="all2"]').each(function(i) {
                        $(this).attr("disabled", true).removeAttr("checked");
                    });
                } else if (obj.hasClass("certP")) {
                    $(".js_cert_cousers").find('.certP[value!="all2"]').each(function(i) {
                        $(this).attr("disabled", true).removeAttr("checked");
                    });
                }
            }
        }
    } else {
        if (obj.val() == "all") {
            if (obj.attr("checked") == "checked") {
                //$('#sub-ship').removeAttr('disabled');
                obj.removeAttr("checked");
                $(".js_cert_cousers").find('.check[value!="all"]').each(function(i) {
                    $(this).removeAttr("disabled");
                });
            } else {
                //if (num > 2) {return false; }
                obj.attr("checked", true);
                $(".js_cert_cousers").find('.check[value!="all"]').each(function(i) {
                    $(this).attr("disabled", true).removeAttr("checked");
                });
            }
        }
    }
    $(".js_cert_cousers").find(".check:checked").each(function(i) {
        spans[i] = $(this).val();
    });
    str = spans.join(",");
    $('input[name="courses"]').val(str);
});

//ajax增加证书科目
$("body").delegate(".js_cert_type", "change", function() {
    var cid = $(this).val();
    getCertCourses(cid);
});

function getCertCourses(cid) {
    if (cid == "") {
        return false;
    }
    $.get("/ajax/getCertCourses", {
        cid:cid
    }, function(data) {
        if (data.status == 1) {
            var html = "";
            var html2 = "";
            if (cid == 10) {
                html += '<div class="certificate-stage"><p class="stage-title"><span>F阶段</span></p>';
                html2 += '<div class="certificate-stage"><p class="stage-title"><span>P阶段</span></p>';
            }
            $(".js_cert_cousers").html("");
            $.each(data.info, function(index, obj) {
                //alert(obj.id);
                if (obj.cid == 10) {
                    if (obj.group == "F") {
                        html += '<div class="check-box"><input class="check certF" id="cer' + obj.id + '"value="' + obj.id + '" type="checkbox"><label for="cer' + obj.id + '">' + obj.name + "</label></div>";
                    } else if (obj.group == "P") {
                        html2 += '<div class="check-box"><input class="check certP" id="cer' + obj.id + '"value="' + obj.id + '" type="checkbox"><label for="cer' + obj.id + '">' + obj.name + "</label></div>";
                    }
                } else {
                    html += '<div class="check-box"><input class="check" id="cer' + obj.id + '"value="' + obj.id + '" type="checkbox"><label for="cer' + obj.id + '">' + obj.name + "</label></div>";
                }
            });
            if (cid == 10) {
                html += "</div>";
                html2 += "</div>";
                html += '<div class="last-level"><span>—</span><div class="check-box"><input class="check certF" id="last1" type="checkbox" value="all"><label for="last1">全部通过</label><em></em></div></div>';
                html2 += '<div class="last-level"><span>—</span><div class="check-box"><input class="check certP" id="last2" type="checkbox" value="all2"><label for="last2">全部通过</label><em></em></div></div>';
                html += html2;
            } else if (cid == 5) {
                html += '<div class="last-level"><span>—</span><div class="check-box"><input class="check" id="last" type="checkbox" value="all"><label for="last">持证人</label><em></em></div></div>';
            } else {
                html += '<div class="last-level"><span>—</span><div class="check-box"><input class="check" id="last" type="checkbox" value="all"><label for="last">全部通过</label><em></em></div></div>';
            }
            $(".js_cert_cousers").append(html);
        } else {}
    }, "json");
}

//点击提交交换生经历
$("body").delegate(".exchange_save", "click", function() {
    if ($("#resume_edu_exchange").valid()) {
        $("#resume_edu_exchange").submit();
    }
});

//交换生经历
$("#resume_edu_exchange").validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent().parent());
    // }, 
    errorLabelContainer:"#exchange_error",
    //ignore: ":hidden",
    onkeyup:false,
    rules:{
        edu_id:{
            required:true
        },
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true,
            checkJhTime:true
        },
        country_code:{
            required:true,
            checkNumiso:true
        },
        major_cid:{
            checkNumiso:true
        },
        school_name:{
            required:true,
            numCheck:true,
            userNamecheck:true
        },
        degree:{
            required:true
        },
        faculty:{
            required:true,
            numCheck:true,
            userNamecheck:true
        },
        major_cid:{
            required:true
        },
        major:{
            required:true,
            numCheck:true,
            userNamecheck:true
        }
    },
    messages:{
        edu_id:{
            required:"请选择教育经历"
        },
        syear:{
            required:"入学时间为必填",
            checkNumiso:"入学年份必选"
        },
        smonth:{
            required:"入学时间为必填",
            checkNumiso:"入学月份必选",
            checkJhTime:"开始时间不能大于结束时间"
        },
        country_code:{
            required:"国家为必选",
            checkNumiso:"国家为必选"
        },
        major_cid:{
            checkNumiso:"专业为必选"
        },
        school_name:{
            required:"学校为必填",
            numCheck:"学校名称不能为纯数字",
            userNamecheck:"学校名称不能有非法字符"
        },
        degree:{
            required:"学历为必选"
        },
        faculty:{
            required:"院系为必填"
        },
        major_cid:{
            required:"专业为必选"
        },
        major:{
            required:"专业为必填",
            numCheck:"专业不能为纯数字",
            userNamecheck:"专业不能有非法字符"
        }
    },
    submitHandler:function(form) {
        $("#resume_edu_exchange").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                //setTimeout(function(){ window.location.href=data.url; },50000);
                if (data.status == 1) {
                    get_edu_ajax($(form));
                } else {
                    layer.msg(data.msg, {
                        icon:2
                    });
                    $(form).find(".save").val("保存").removeAttr("disabled", false);
                }
            }
        });
    }
});

//编辑获取教育交换生经历
$("body").delegate(".js_edu_exchange_edit", "click", function() {
    var id = $(this).attr("data-eduid");
    //教育经历ID
    var exchange_id = $(this).attr("data-id");
    //交换生ID
    $.get("/ajax/getEduDetail", {
        id:id,
        exchange_id:exchange_id,
        type:"exchange"
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            //console.log(data.info);
            $("#jh_school_name").val(info.school_name);
            $("#jh_school_name").parent().next().html("<span><span>" + info.school_name.length + "</span>/18</span>字");
            $("#jh_country_code").find("option[value='" + info.country_code + "']").prop("selected", true);
            $("#jh_syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#jh_smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#jh_eyear").find("option[value='" + info.eyear + "']").prop("selected", true);
            $("#jh_emonth").find("option[value='" + info.emonth + "']").prop("selected", true);
            $("#jh_id").val(info.id);
            $("#jh_major_cid").find("option[value='" + info.major_category_id + "']").prop("selected", true);
            $("#jh_major").val(info.major);
            $("#jh_major").parent().next().html("<span><span>" + info.major.length + "</span>/10</span>字");
            $("#jh_edu_id").val(info.edu_id);
            $("#jh_remark").val(info.remark);
            $("#jh_edu_type").val("edu_exchange_update");
            $("#jh_edu_id").attr("disabled", true);
            $("#js_jh_edu__del").attr("data-id", info.id);
            $("#js_jh_edu__del").attr("data-name", info.school_name);
            $(".js_jh_edu__del").show();
            $("#resume_edu_exchange").prev(".profile-show").hide();
            $("#resume_edu_exchange").find(".profile-edit").show();
            $("#resume_edu_exchange").find(".block-append").hide();
            $("#resume_edu_exchange").find(".level-info").show();
        } else {}
    }, "json");
});

//删除教育交换生经历
$("body").delegate("#js_jh_edu__del", "click", function() {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    layer.confirm("确定删除交换生经历: " + name + "？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"edu_exchange_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//点击提交专业研究项目经历
$("body").delegate(".project_save", "click", function() {
    if ($("#resume_edu_other").valid()) {
        $("#resume_edu_other").submit();
    }
});

//专业研究项目经历
$("#resume_edu_other").validate({
    errorPlacement:function(error, element) {
        error.appendTo(element.parent().parent());
    },
    errorLabelContainer:"#project_error",
    //ignore: ":hidden",
    onkeyup:false,
    rules:{
        edu_id:{
            required:true,
            checkNumiso:true
        },
        name:{
            required:true,
            numCheck:true,
            userNamecheck:true
        },
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true,
            checkProjectTime:true
        },
        role:{
            required:true
        }
    },
    messages:{
        edu_id:{
            required:"请选择教育经历",
            checkNumiso:"教育经历必选"
        },
        name:{
            required:"请输入项目名称",
            numCheck:"名称不能为纯数字",
            userNamecheck:"名称不能有非法字符"
        },
        syear:{
            required:"入学时间为必选",
            checkNumiso:"入学年份必选"
        },
        smonth:{
            required:"入学时间为必选",
            checkNumiso:"入学月份必选",
            checkProjectTime:"开始时间不能大于结束时间"
        },
        role:{
            required:"请选择角色"
        }
    },
    submitHandler:function(form) {
        $("#resume_edu_other").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                //setTimeout(function(){ window.location.href=data.url; },50000);
                if (data.status == 1) {
                    get_edu_ajax($(form));
                } else {
                    layer.msg(data.msg, {
                        icon:2
                    });
                    $(form).find(".save").val("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑获取教育专业研究项目经历
$("body").delegate(".js_edu_project_edit", "click", function() {
    var id = $(this).attr("data-eduid");
    //教育经历ID
    var other_id = $(this).attr("data-id");
    //交换生ID
    $.get("/ajax/getEduDetail", {
        id:id,
        other_id:other_id,
        type:"other"
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            //console.log(data.info);
            $("#project_name").val(info.name);
            $("#project_name").parent().next().html("<span><span>" + info.name.length + "</span>/18</span>字");
            $("#jh_country_code").find("option[value='" + info.country_code + "']").prop("selected", true);
            $("#project_syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#project_smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#project_eyear").find("option[value='" + info.eyear + "']").prop("selected", true);
            $("#project_emonth").find("option[value='" + info.emonth + "']").prop("selected", true);
            $("#project_id").val(info.id);
            $("#role" + info.role).prop("checked", true);
            $("#project_edu_id").val(info.edu_id);
            $("#project_remark").val(info.remark);
            $("#project_edu_id").attr("disabled", true);
            $("#project_edu_type").val("edu_ex_update");
            $(".js_project_edu__del").attr("data-id", info.id).attr("data-name", info.name);
            $(".js_project_edu__del").show();
            $("#resume_edu_other").prev(".profile-show").hide();
            $("#resume_edu_other").find(".profile-edit").show();
            $("#resume_edu_other").find(".block-append").hide();
            $("#resume_edu_other").find(".level-info").show();
        } else {}
    }, "json");
});

//删除教育专业项目经历
$("body").delegate(".js_project_edu__del", "click", function() {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    layer.confirm("确定删除项目经历: " + name + " 吗？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"edu_ex_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//语言技能
//点击提交语言技能
$("body").delegate(".skill_save", "click", function() {
    if ($("#resume_skill").valid()) {
        $("#resume_skill").submit();
    }
});

//语言技能
$("#resume_skill").validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent().parent());
    // }, 
    errorLabelContainer:"#skill_error",
    // ignore: ":hidden",
    onkeyup:false,
    rules:{
        //en:{required:true},
        englishscore:{
            digits:true,
            min:1
        },
        ieltsscore:{
            range:[ 1, 9 ]
        },
        toeflscore:{
            range:[ 1, 120 ]
        }
    },
    messages:{
        //en:{required:'英语水平为必选'},
        englishscore:{
            digits:"必须为大于0的正整数",
            min:"必须为大于0的正整数"
        },
        ieltsscore:{
            range:"雅思分数为{0}-{1}分"
        },
        toeflscore:{
            range:"托福分数为{0}-{1}分"
        }
    },
    submitHandler:function(form) {
        $("#resume_skill").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").attr("disabled", true);
            },
            success:function(data) {
                if (data.status == 1) {
                    //window.location.href = window.location.href+'?cs'+Math.random();
                    $.ajax({
                        async:false,
                        type:"POST",
                        url:"/get_resumeSkill",
                        data:{
                            id:$(".js_info_box").find('[name="resume_id"]').attr("data-id")
                        },
                        dataType:"json",
                        success:function(data) {
                            if (data.status == 1) {
                                $(form).prev().html("");
                                $(form).prev().append(data.html);
                                $(form).find(".save").val("保存").removeAttr("disabled");
                                $(form).find(".profile-edit").hide();
                                $(form).prev().show();
                            } else {
                                layer.msg(data.msg, {
                                    icon:5
                                });
                            }
                        }
                    });
                } else {
                    if (data.msg == "json不正确") {
                        layer.msg("其他语言能力必须填完整", {
                            icon:5
                        });
                    } else {
                        layer.msg(data.msg, {
                            icon:5
                        });
                    }
                    $(form).find(".save").text("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑语言技能
$("body").delegate(".js_skill_edit", "click", function() {
    var id = $(this).attr("data-id");
    //教育经历ID
    $.get("/ajax/getSkill", {
        resume_id:id
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            $("#skill_en option").each(function(i, n) {
                if ($(this).val() == info.en_level) {
                    if ($(this).prop("selected") != "true") $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });
            if (info.english_score > 0 && info.en_level >= 0) {
                $('[name="englishscore"]').val(info.english_score);
            } else {
                $('[name="englishscore"]').val("");
            }
            if (info.ielts != 0) {
                $('[name="ielts"]').attr("checked", true);
                if (info.ielts != -1) {
                    $('[name="ieltsscore"]').val(info.ielts);
                }
            } else {
                $('[name="ielts"]').removeAttr("checked");
                $('[name="ieltsscore"]').val("");
            }
            if (info.toefl != 0) {
                $('[name="toefl"]').attr("checked", true);
                if (info.toefl != -1) {
                    $('[name="toeflscore"]').val(info.toefl);
                }
            } else {
                $('[name="toefl"]').removeAttr("checked");
                $('[name="toeflscore"]').val("");
            }
            if (typeof info.other_languages[0] != "undefined" && info.other_languages[0].name != "") {
                $("#skill_name").find("option[value='" + info.other_languages[0]["name"] + "']").attr("selected", true);
                $("#proficiency").find("option[value='" + info.other_languages[0]["proficiency"] + "']").attr("selected", true);
            }
            $("#skill_other_sel").html("");
            for (var i in info.other_languages) {
                if (i == 0) {
                    continue;
                }
                //alert(info.other_languages[i]['name']);
                var option = "";
                var sloption = "";
                //<option value="0">一般</option><option value="1">良好</option><option value="2">熟练</option>'
                //       +'<option value="3">精通</option>
                var lang_arr = [ "德语", "法语", "俄语", "韩语", "日语", "计算机" ];
                var sl_arr = [ "一般", "良好", "熟练", "精通" ];
                for (var j in lang_arr) {
                    if (info.other_languages[i]["name"] == lang_arr[j]) {
                        //alert(lang_arr[j]);
                        option += '<option value="' + lang_arr[j] + '" selected>' + lang_arr[j] + "</option>";
                    } else {
                        option += '<option value="' + lang_arr[j] + '">' + lang_arr[j] + "</option>";
                    }
                }
                for (var t in sl_arr) {
                    if (info.other_languages[i]["proficiency"] == t) {
                        //alert(lang_arr[j]);
                        sloption += '<option value="' + t + '" selected>' + sl_arr[t] + "</option>";
                    } else {
                        sloption += '<option value="' + t + '">' + sl_arr[t] + "</option>";
                    }
                }
                //alert(sloption);
                var more = '<div class="more-language"><div class="input-box"><select name="name[]" id="skill_name2"><option value="">选择语种</option>' + option + '</select></div><div class="input-box">' + '<select name="proficiency[]" id="proficiency2"><option value="">熟练程度</option>' + sloption + "</select></div></div>";
                $("#skill_other_sel").append(more);
            }
            // if (typeof(info.other_languages[0])!="undefined" && info.other_languages[0].name !=""){
            //  $('#skill_name1').find("option[value='"+info.other_languages[0].name+"']").attr("selected",true);
            //  $('#proficiency1').find("option[value='"+info.other_languages[0].proficiency+"']").attr("selected",true);
            //  $('#literacy1').find("option[value='"+info.other_languages[0].literacy+"']").attr("selected",true);
            //  $("#lwability1").find("option[value='"+info.other_languages[0].lwability+"']").attr("selected",true);
            // }
            // if (typeof(info.other_languages[1])!="undefined" && info.other_languages[1].name !="" && info.other_languages[1].name !='计算机'){
            //  $('#skill_name2').find("option[value='"+info.other_languages[1].name+"']").attr("selected",true);
            //  $('#proficiency2').find("option[value='"+info.other_languages[1].proficiency+"']").attr("selected",true);
            //  $('#literacy2').find("option[value='"+info.other_languages[1].literacy+"']").attr("selected",true);
            //  $("#lwability2").find("option[value='"+info.other_languages[1].lwability+"']").attr("selected",true);
            // }
            // if (typeof(info.other_languages[1])!="undefined" && info.other_languages[1].name =="计算机"){
            //  $("#jsjproficiency").find("option[value='"+info.other_languages[1].proficiency+"']").attr("selected",true);
            // }
            // if (typeof(info.other_languages[2])!="undefined" && info.other_languages[2].name =="计算机"){
            //  $("#jsjproficiency").find("option[value='"+info.other_languages[2].proficiency+"']").attr("selected",true);
            // }
            $("#js_skill_type").val("skill_update");
            //$('#skill_other').val(info.other);
            $(".js_skill__del").show().attr("data-id", data.info.id);
            $('[name="skill_id"]').val(data.info.id);
            $("#resume_skill").prev(".profile-show").hide();
            $("#resume_skill").find(".profile-edit").show();
            $("#resume_skill").find(".block-append").hide();
            $("#resume_skill").find(".level-info").show();
        } else {}
    }, "json");
});

//删除语言技能
$("body").delegate(".js_skill__del", "click", function() {
    var id = $(this).attr("data-id");
    if (id == 0) {
        return false;
    }
    layer.confirm("确定删除当前语言技能吗？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"skill_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//实习经验
//点击提交实习经验
$("body").delegate(".internship_save", "click", function() {
    if ($("#internshipForm").valid()) {
        $("#internshipForm").submit();
    }
});

//实习经验
$("#internshipForm").validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent().parent());
    // }, 
    errorLabelContainer:"#internship_error",
    //ignore: ":hidden",
    onkeyup:false,
    rules:{
        company_name:{
            required:true,
            numCheck:true,
            userNamecheck:true
        },
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true,
            checkInternshipTime:true
        },
        work_type:{
            required:true
        },
        work_remark:{
            required:true
        },
        department:{
            required:true,
            numCheck:true,
            userNamecheck:true
        },
        sel_trade:{
            required:true
        },
        nature:{
            required:true
        },
        sel_function:{
            required:true
        }
    },
    messages:{
        company_name:{
            required:"请输入公司名称",
            numCheck:"请输入正确的公司名称",
            userNamecheck:"公司名称不能包含非法字符"
        },
        syear:{
            required:"请选择开始时间",
            checkNumiso:"请选择开始年份"
        },
        smonth:{
            required:"请选择开始时间",
            checkNumiso:"请选择开始月份",
            checkInternshipTime:"开始时间不能大于结束时间"
        },
        work_type:{
            required:"请选择工作类型"
        },
        work_remark:{
            required:"请输入工作描述"
        },
        department:{
            required:"部门不能为空",
            numCheck:"部门不能为纯数字",
            userNamecheck:"部门不能有非法字符"
        },
        sel_trade:{
            required:"请选择行业"
        },
        nature:{
            required:"请选择公司性质"
        },
        sel_function:{
            required:"请选择职能"
        }
    },
    submitHandler:function(form) {
        $("#internshipForm").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                //setTimeout(function(){ window.location.href=data.url; },50000);
                if (data.status == 1) {
                    $.ajax({
                        async:false,
                        type:"POST",
                        url:"/get_resumeInternship",
                        data:{
                            id:$(".js_info_box").find('[name="resume_id"]').attr("data-id")
                        },
                        dataType:"json",
                        success:function(data) {
                            if (data.status == 1) {
                                $(form).prev().html("");
                                $(form).prev().append(data.html);
                                $(form).find(".save").val("保存").removeAttr("disabled");
                                $(form).find(".profile-edit").hide();
                                $(form).prev().show();
                            } else {
                                $(form).find(".save").val("保存").removeAttr("disabled");
                                layer.msg(data.msg, {
                                    icon:5
                                });
                            }
                        },
                        error:function() {
                            layer.msg("出现错误，请重试！", {
                                icon:5
                            });
                        }
                    });
                } else {
                    layer.msg(data.msg, {
                        icon:5
                    });
                    $(form).find(".save").val("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑实习经验
$("body").delegate(".js_internship_edit", "click", function() {
    var id = $(this).attr("data-id");
    //实习经历ID
    $.get("/ajax/getInternship", {
        id:id
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            0;
            //console.log(data.info);
            $("#internshipForm").find('[name="id"]').val(info.id);
            $(".js_intership_del").attr("data-id", info.id).attr("data-name", info.company_name);
            $("#internshipForm").find('[name="company_name"]').val(info.company_name);
            $("#internshipForm").find('[name="company_name"]').parent().next().html("<span><span>" + info.company_name.length + "</span>/24</span>字");
            $("#internship_syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#internship_smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#internship_eyear").find("option[value='" + info.eyear + "']").prop("selected", true);
            $("#internship_emonth").find("option[value='" + info.emonth + "']").prop("selected", true);
            $("#internship_nature").find("option[value='" + info.nature + "']").prop("selected", true);
            $("#internship_department").val(info.department);
            $("#industry").val(info.subtrade_name).attr("data-id", info.subtrade);
            $("#post").val(info.function_name);
            $("#workType" + info.work_type).prop("checked", true);
            $("#work_remark").val(info.work_remark);
            $("#work_ex").val(info.work_ex);
            $("#internshipForm").find('[name="trade"]').val(info.trade);
            $("#internshipForm").find('[name="sub_trade"]').val(info.subtrade);
            $("#internshipForm").find('[name="function"]').val(info.func);
            $("#internshipForm").find('[name="type"]').val("internship_update");
            $(".work_remark").html("");
            $(".work_remarknum").html("<span>" + info.work_remark.length + "</span>/2000");
            $(".work_ex").html("");
            $(".work_exnum").html("<span>" + info.work_ex.length + "</span>/2000");
            $("#internshipForm").prev(".profile-show").hide();
            $("#internshipForm").find(".profile-edit").show();
            $("#internshipForm").find(".block-append").hide();
            $("#internshipForm").find(".level-info").show();
        } else {
            layer.msg(data.msg, {
                icon:5
            });
        }
    }, "json");
});

//删除实习经验
$("body").delegate(".js_intership_del", "click", function() {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    layer.confirm("确定删除" + name + "的实习经验吗？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"internship_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:5
                });
            }
        }, "json");
    }, function() {});
});

//校内经历
//点击学生奖励和荣誉
$("body").delegate(".reward_save", "click", function() {
    if ($("#school_reward").valid()) {
        $("#school_reward").submit();
    }
});

//学生奖励和荣誉
$("#school_reward").validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent());
    // }, 
    errorLabelContainer:"#reward_error",
    //ignore: ":hidden",
    onkeyup:false,
    rules:{
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true
        },
        level:{
            required:true
        },
        name:{
            required:true,
            numCheck:true,
            userNamecheck:true
        }
    },
    messages:{
        syear:{
            required:"请选择获得时间",
            checkNumiso:"请选择获得年份"
        },
        smonth:{
            required:"请选择获得时间",
            checkNumiso:"请选择获得月份"
        },
        level:{
            required:"请选择等级"
        },
        name:{
            required:"请输入奖项名称",
            numCheck:"名称不能为纯数字",
            userNamecheck:"名称不能有非法字符"
        }
    },
    submitHandler:function(form) {
        $("#school_reward").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                if (data.status == 1) {
                    get_xnjl_ajax($(form));
                } else {
                    layer.msg(data.msg, {
                        icon:5
                    });
                    $(form).find(".save").val("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑学生奖励和荣誉
$("body").delegate(".js_reward_edit", "click", function() {
    var resume_id = $(this).attr("data-resumeid");
    //教育经历ID
    var id = $(this).attr("data-id");
    //教育经历ID
    $.get("/ajax/getReward", {
        resume_id:resume_id,
        id:id
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            //console.log(data.info);
            $("#reward_syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#reward_smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#level" + info.level).prop("checked", true);
            $("#reward_name").val(info.name);
            $("#reward_name").parent().next().html("<span><span>" + info.name.length + "</span>/18</span>字");
            $("#reward_id").val(info.id);
            $("#reward_type").val("school_reword_update");
            $(".js_reward__del").attr("data-id", info.id).attr("data-name", info.name);
            $("#school_reward").prev(".profile-show").hide();
            $("#school_reward").find(".profile-edit").show();
            $("#school_reward").find(".block-append").hide();
            $("#school_reward").find(".level-info").show();
        } else {}
    }, "json");
});

//删除学生奖励和荣誉
$("body").delegate(".js_reward__del", "click", function() {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    if (id == 0) {
        return false;
    }
    layer.confirm("确定删除校内荣誉: " + name + "吗？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"school_reword_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//点击校内职位
$("body").delegate(".school_job_save", "click", function() {
    if ($("#school_job").valid()) {
        $("#school_job").submit();
    }
});

//校内职位
$("#school_job").validate({
    errorPlacement:function(error, element) {
        error.appendTo(element.parent().parent());
    },
    errorLabelContainer:"#school_job_error",
    //ignore: ":hidden",
    onkeyup:false,
    rules:{
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true,
            checkScjobTime:true
        },
        remark:{
            required:true
        },
        role:{
            required:true
        }
    },
    messages:{
        syear:{
            required:"请选择开始时间",
            checkNumiso:"请选择开始年份"
        },
        smonth:{
            required:"请选择开始时间",
            checkNumiso:"请选择开始月份",
            checkScjobTime:"开始时间不能大于结束时间"
        },
        remark:{
            required:"请输入职务描述"
        },
        role:{
            required:"请选择角色"
        }
    },
    submitHandler:function(form) {
        $("#school_job").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                if (data.status == 1) {
                    get_xnjl_ajax($(form));
                } else {
                    $(form).find(".save").val("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑校内职位
$("body").delegate(".js_scjob_edit", "click", function() {
    var resume_id = $(this).attr("data-resumeid");
    //教育经历ID
    var id = $(this).attr("data-id");
    //教育经历ID
    $.get("/ajax/getSchoolJob", {
        resume_id:resume_id,
        id:id
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            //console.log(data.info);
            $("#scjob_syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#scjob_smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#scjob_eyear").find("option[value='" + info.eyear + "']").prop("selected", true);
            $("#scjob_emonth").find("option[value='" + info.emonth + "']").prop("selected", true);
            $("#prole" + info.role).prop("checked", true);
            $("#scjob_remark").val(info.remark);
            $("#scjob_id").val(info.id);
            $("#school_job").find("[name=type]").val("school_job_update");
            $(".js_scjob__del").attr("data-id", info.id);
            $("#school_job").prev(".profile-show").hide();
            $("#school_job").find(".profile-edit").show();
            $("#school_job").find(".block-append").hide();
            $("#school_job").find(".level-info").show();
        } else {}
    }, "json");
});

//添加校内职位
$("body").delegate(".js_scjob_add", "click", function() {
    $("#scjob_res").click();
    $("#scjob_syear").val("0");
    $("#scjob_smonth").val("0");
    $("#scjob_eyear").val("0");
    $("#scjob_emonth").val("0");
    $('input[name="role"]').attr("checked", false);
    $("#school_job").prev(".profile-show").hide();
    $("#school_job").find(".profile-edit").show();
    $("#school_job").find(".block-append").hide();
    $("#school_job").find(".level-info").show();
});

//校内职位取消
$(".js_scjob_cancel").click(function() {
    if ($(this).attr("data-id").length > 0) {
        $(".edu_project_profile_show").show();
        $(".project_block").hide();
        $(".edu_project_profile_edit").hide();
    } else {
        $(".edu_project_profile_show").hide();
        $(".project_block").show();
        $(".edu_project_profile_edit").show();
    }
    $(".project_sub").hide();
});

//删除校内职务
$(".js_scjob__del").click(function() {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    if (id == 0) {
        return false;
    }
    layer.confirm("确定删除校内职务吗？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"school_job_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//点击社会实践
$(".practice_save").click(function() {
    if ($("#school_practice").valid()) {
        $("#school_practice").submit();
    }
});

//学生社会实践
$("#school_practice").validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent().parent());
    // }, 
    errorLabelContainer:"#practice_error",
    //ignore: ":hidden",
    onkeyup:false,
    rules:{
        syear:{
            required:true,
            checkNumiso:true
        },
        smonth:{
            required:true,
            checkNumiso:true,
            checkPracticeTime:true
        },
        remark:{
            required:true
        },
        name:{
            required:true,
            numCheck:true,
            userNamecheck:true
        }
    },
    messages:{
        syear:{
            required:"请选择开始时间",
            checkNumiso:"请选择开始年份"
        },
        smonth:{
            required:"请选择开始时间",
            checkNumiso:"请选择开始月份",
            checkPracticeTime:"开始时间不能大于结束时间"
        },
        remark:{
            required:"请输入实践描述"
        },
        name:{
            required:"请输入社会实践名称",
            numCheck:"名称不能为纯数字",
            userNamecheck:"名称不能有非法字符"
        }
    },
    submitHandler:function(form) {
        $("#school_practice").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                if (data.status == 1) {
                    get_xnjl_ajax($(form));
                } else {
                    $(form).find(".save").text("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑社会实践
$("body").delegate(".js_practice_edit", "click", function() {
    var resume_id = $(this).attr("data-resumeid");
    //教育经历ID
    var id = $(this).attr("data-id");
    //教育经历ID
    $.get("/ajax/getPractice", {
        resume_id:resume_id,
        id:id
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            //console.log(data.info);
            $("#practice_id").val(info.id);
            $("#practice_syear").find("option[value='" + info.syear + "']").prop("selected", true);
            $("#practice_smonth").find("option[value='" + info.smonth + "']").prop("selected", true);
            $("#practice_eyear").find("option[value='" + info.eyear + "']").prop("selected", true);
            $("#practice_emonth").find("option[value='" + info.emonth + "']").prop("selected", true);
            $("#practice_name").val(info.name);
            $("#practice_name").parent().next().html("<span><span>" + info.name.length + "</span>/18</span>字");
            $("#practice_remark").val(info.remark);
            $("#school_practice").prev(".profile-show").hide();
            $("#school_practice").find(".profile-edit").show();
            $("#school_practice").find(".block-append").hide();
            $("#school_practice").find(".level-info").show();
            $("#practice_type").val("school_practice_update");
            $(".js_practice__del").attr("data-id", info.id).attr("data-name", info.name);
            $("#practice_remarknum").html("");
            $("#practice_remarknum").html("<span>" + info.remark.length + "</span>/2000");
        } else {
            layer.msg(data.msg, {
                icon:5
            });
        }
    }, "json");
});

//   //删除社会实践
$(".js_practice__del").click(function() {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    if (id == 0) {
        return false;
    }
    layer.confirm("确定删除社会实践 : " + name + "吗？", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"school_practice_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//添加
//教育添加
$("body").delegate(".js_edu_add", "click", function() {
    $(".school").html("");
    $("#schoolSelect").hide();
    $(".js_get_school li").removeClass("active");
    $("#school_name").val("");
    $("a.second-specialty").show();
    $(".secmajor").hide();
    $("#faculty").val("");
    $("#syear").val("0");
    $("#smonth").val("0");
    $("#eyear").val("0");
    $("#emonth").val("0");
    $("#major_category_id").val("0");
    $("#major").val("");
    $("#major").parent().next().html("<span><span>0</span>/10</span>字");
    $("#second_major_category_id").val("0");
    $("#second_major").val("");
    $('input[name="degree"]').attr("checked", false);
    $("#bp").val("");
    $("#rank").val("");
    $("#edu_type").val("edu_create");
    $("#js_edu_del").attr("data-id", "").attr("data-name", "");
    $(".edu_profile_show").hide();
    $(".edu_profile_edit").show();
    $(".edu_sub").show();
    $("#js_edu_del").hide();
});

//交换生添加
$("body").delegate(".js_edu_exchange_add", "click", function() {
    $("#jh_edu_id").val("0");
    $("#jh_country_code").val("0");
    $("#jh_school_name").val("");
    $("#jh_school_name").parent().next().html("<span><span>0</span>/18</span>字");
    $("#jh_major_cid").val("0");
    $("#jh_major").val("");
    $("#jh_major").parent().next().html("<span><span>0</span>/10</span>字");
    $("#jh_syear").val("0");
    $("#jh_smonth").val("0");
    $("#jh_eyear").val("0");
    $("#jh_emonth").val("0");
    $("#jh_remark").val("");
    $("#js_jh_edu__del").attr("data-id", "").attr("data-name", "");
    $("#jh_edu_type").val("edu_exchange_create");
    $("#jh_edu_id").removeAttr("disabled");
    $(".js_jh_edu__del").hide();
    $("#resume_edu_exchange").prev(".profile-show").hide();
    $("#resume_edu_exchange").find(".profile-edit").show();
    $("#resume_edu_exchange").find(".block-append").hide();
    $("#resume_edu_exchange").find(".level-info").show();
});

//项目添加
$("body").delegate(".js_edu_project_add", "click", function() {
    $("#project_edu_id").val("0");
    $("#project_name").val("");
    $("#project_name").parent().next().html("<span><span>0</span>/18</span>字");
    $("#project_syear").val("0");
    $("#project_smonth").val("0");
    $("#project_eyear").val("0");
    $("#project_emonth").val("0");
    $('input[name="role"]').attr("checked", false);
    $("#project_remark").val("");
    $("#project_edu_id").removeAttr("disabled");
    $("#project_edu_type").val("edu_ex_create");
    $("#js_project_edu__del").attr("data-id", "").attr("data-name", "");
    $(".js_project_edu__del").hide();
    $("#resume_edu_other").prev(".profile-show").hide();
    $("#resume_edu_other").find(".profile-edit").show();
    $("#resume_edu_other").find(".block-append").hide();
    $("#resume_edu_other").find(".level-info").show();
});

//项目取消
// $('.js_project_cancel').click(function(){
//  if ($(this).attr('data-id').length >0){
//    $('.edu_project_profile_show').show();
//    $('.project_block').hide();
//    $('.edu_project_profile_edit').hide();
//  }else{
//    $('.edu_project_profile_show').hide();
//    $('.project_block').show();
//    $('.edu_project_profile_edit').show();
//  }
//  $('.project_sub').hide();
// });
//荣誉添加
$("body").delegate(".js_reward_add", "click", function() {
    $("#reward_syear").val("0");
    $("#reward_smonth").val("0");
    $('input[name="level"]').attr("checked", false);
    $("#reward_name").val("");
    $("#reward_name").parent().next().html("<span><span>0</span>/18</span>字");
    $("#js_reward_del").attr("data-id", "").attr("data-name", "");
    $("#reward_type").val("school_reword_create");
    $("#school_reward").prev(".profile-show").hide();
    $("#school_reward").find(".profile-edit").show();
    $("#school_reward").find(".block-append").hide();
    $("#school_reward").find(".level-info").show();
});

//社会实践添加
$("body").delegate(".js_practice_add", "click", function() {
    $("#practice_syear").val("0");
    $("#practice_smonth").val("0");
    $("#practice_eyear").val("0");
    $("#practice_emonth").val("0");
    $("#practice_remark").val("");
    $("#practice_name").val("");
    $("#practice_name").parent().next().html("<span><span>0</span>/18</span>字");
    //$('#js_reward_del').attr('data-id',"").attr('data-name',"");
    $("#practice_type").val("school_practice_create");
    $("#school_practice").prev(".profile-show").hide();
    $("#school_practice").find(".profile-edit").show();
    $("#school_practice").find(".block-append").hide();
    $("#school_practice").find(".level-info").show();
});

//点击提交证书
$(".cert_save").click(function() {
    if ($("#certForm").valid()) {
        $("#certForm").submit();
    }
});

//证书提交表单
$("#certForm").validate({
    ignore:":hidden",
    onkeyup:false,
    rules:{},
    messages:{},
    submitHandler:function(form) {
        $("#certForm").ajaxSubmit({
            url:"/ajax/updateResume",
            type:"POST",
            dataType:"json",
            beforeSubmit:function() {
                var cert = new Array();
                var cid = $(form).find('[name="cid"]').val();
                var cname = $(form).find('[name="cid"] option:selected').text();
                $(".js_cert_edit").each(function(i) {
                    cert[i] = $(this).attr("data-cid");
                });
                if ($.inArray(cid, cert) > -1 && $("#certForm").find('[name="type"]').val() != "cert_update") {
                    layer.msg("您已添加过" + cname + "了！", {
                        icon:5
                    });
                    return false;
                } else if ($(form).find('[name="courses"]').val().length == 0) {
                    layer.msg("请选择证书科目", {
                        icon:5
                    });
                    return false;
                }
                $(form).find(".save").val("提交中...").attr("disabled", true);
            },
            success:function(data) {
                if (data.status == 1) {
                    $.ajax({
                        async:false,
                        type:"POST",
                        url:"/get_resumeCert",
                        data:{
                            id:$(".js_info_box").find('[name="resume_id"]').attr("data-id")
                        },
                        dataType:"json",
                        success:function(data) {
                            if (data.status == 1) {
                                $(form).prev().html("");
                                $(form).prev().append(data.html);
                                $(form).find(".save").val("保存").removeAttr("disabled");
                                $(form).find(".profile-edit").hide();
                                $(form).prev().show();
                            } else {
                                layer.msg(data.msg, {
                                    icon:5
                                });
                            }
                        }
                    });
                } else {
                    $(form).find(".save").val("保存").removeAttr("disabled");
                }
            }
        });
    }
});

//编辑证书
$("body").delegate(".js_cert_edit", "click", function() {
    var resume_id = $(this).attr("data-resumeid");
    //简历ID
    var id = $(this).attr("data-id");
    //证书ID
    var cid = $(this).attr("data-cid");
    //证书分类ID
    $(".js_cert_type").find("option[value='" + cid + "']").attr("selected", true);
    $(".js_cert_type").attr("disabled", true);
    getCertCourses(cid);
    $.get("/ajax/getCert", {
        resume_id:resume_id,
        id:id
    }, function(data) {
        if (data.status == 1) {
            var info = data.info;
            //console.log(data.info);
            $("#certForm").find('[name="id"]').val(info.id);
            $(".js_cert_del").attr("data-id", info.id).attr("data-name", info.cert_type_name);
            $("#certForm").find('[name="type"]').val("cert_update");
            //循环选中标签
            for (var i in info.pass_courses) {
                $(".js_cert_cousers").find(".check[value=" + info.pass_courses[i] + "]").attr("checked", true);
            }
            //alert(info.is_allpass+'+'+info.is_allpass2);
            if (info.is_allpass == true || info.is_allpass2 == true) {
                if (info.is_allpass == true) {
                    $(".js_cert_cousers").find('.check[value="all"]').attr("checked", true);
                    $('input[name="courses"]').val("all");
                }
                if (info.is_allpass2 == true) {
                    $(".js_cert_cousers").find('.check[value="all2"]').attr("checked", true);
                    $('input[name="courses"]').val("all2");
                }
            } else {
                $('input[name="courses"]').val(info.pass_courses.join(","));
            }
            $(".js_cert_del").show();
            $("#certForm").prev(".profile-show").hide();
            $("#certForm").find(".profile-edit").show();
            $("#certForm").find(".block-append").hide();
            $("#certForm").find(".level-info").show();
        } else {
            layer.msg(data.msg, {
                icon:5
            });
        }
    }, "json");
});

//删除证书
$(".js_cert_del").click(function() {
    var id = $(this).attr("data-id");
    //alert(id);
    var name = $(this).attr("data-name");
    if (id == 0) {
        return false;
    }
    layer.confirm("确定删除证书： " + name + "吗", {
        btn:[ "删除", "算了" ]
    }, function() {
        layer.close(index);
        var index = layer.load(1, {
            shade:[ .1, "#fff" ]
        });
        $.post("/ajax/updateResume", {
            id:id,
            type:"cert_del"
        }, function(data) {
            if (data.status == 1) {
                layer.msg("删除成功", {
                    icon:1
                });
                explorer();
            } else {
                layer.msg(data.msg, {
                    icon:1
                });
            }
        }, "json");
    }, function() {});
});

//证书添加
$("body").delegate(".js_cert_add", "click", function() {
    $(".js_cert_type").val("0");
    $("#certForm").find('[name="courses"]').val("");
    $("#certForm").find('[name="id"]').val("");
    $("#certForm").find('[name="type"]').val("cert_create");
    $(".js_cert_type").attr("disabled", false);
    //$('#js_reward_del').attr('data-id',"").attr('data-name',"");
    $(".js_cert_cousers").html("");
    $(".js_cert_del").hide();
    $("#certForm").prev(".profile-show").hide();
    $("#certForm").find(".profile-edit").show();
    $("#certForm").find(".block-append").hide();
    $("#certForm").find(".level-info").show();
});

//实习经验添加
$("body").delegate(".js_internship_add", "click", function() {
    $("#internshipForm").find('[name="id"]').val("");
    $("#internshipForm").find('[name="company_name"]').val("");
    $("#internship_syear").val("0");
    $("#internship_smonth").val("0");
    $("#internship_eyear").val("0");
    $("#internship_emonth").val("0");
    $("#internship_nature").val("0");
    $("#internship_department").val("");
    $("#industry").val("点击选择公司所属行业");
    $("#post").val("点击选择所在职位");
    $("#internshipForm").find('input[name="work_type"]').attr("checked", false);
    $("#work_remark").val("");
    $("#work_ex").val("");
    $("#internshipForm").find('[name="company_name"]').parent().next().html("<span><span>0</span>/24</span>字");
    $("#internshipForm").find('[name="trade"]').val("");
    $("#internshipForm").find('[name="sub_trade"]').val("");
    $("#internshipForm").find('[name="function"]').val("");
    $("#internshipForm").find('[name="type"]').val("internship_create");
    $("#internshipForm").prev(".profile-show").hide();
    $("#internshipForm").find(".profile-edit").show();
    $("#internshipForm").find(".block-append").hide();
    $("#internshipForm").find(".level-info").show();
});

//实习经验取消
$(".js_internship_cancel").click(function() {
    if ($(this).attr("data-id").length > 0) {
        $(".internship_block").hide();
    } else {
        $(".internship_block").show();
    }
    $(".internship_profile_show").show();
    $(".internship_profile_edit").hide();
    $(".internship_sub").show();
});

$(".avatar-example").find(".example-title").hover(function() {
    $(this).next(".our-avatar").toggle("normal");
});

var startPicker = new Pikaday({
    field:document.getElementById("birth"),
    firstDay:1,
    minDate:new Date("1980-01-01"),
    maxDate:new Date("2000-12-31"),
    yearRange:[ 1980, 2e3 ]
});

//    profileEdit edit/show
$(".profile-show").each(function(index) {
    if ($(this).attr("data-id") == 0) {
        $(".profile-show").eq(index).hide();
        $(".profile-edit").eq(index).show();
    }
});

//表单编辑取消
$(".profile-edit").each(function(index) {
    var is_null = $(this).attr("data-id");
    //$(".js_avatar_show").html("");
    $(this).find(".cancel").click(function() {
        if (is_null == "") {
            $(".profile-show").eq(index).hide();
            $(".profile-edit").eq(index).show();
            $(".profile-edit").eq(index).find(".block-append").show();
            $(".profile-edit").eq(index).find(".level-info").hide();
        } else {
            $(".profile-show").eq(index).show();
            $(".profile-edit").eq(index).hide();
        }
    });
});

//初始化求职意向一周工作几天表单
var week_day = $('input[name="week_day"]').val();

$("#work" + week_day).attr("checked", "checked");

//添加第二专业
$(".second-specialty").click(function() {
    $(this).hide();
    $(".secmajor").show();
});

$("body").delegate(".js_get_school li", "click", function() {
    $(this).addClass("active").siblings().removeClass("active");
});

//   教育经历选择学校
//$("#school").click(function () {
$("body").delegate("#school", "click", function() {
    $("#schoolSelect").show();
});

$("body").delegate(".school li", "click", function() {
    $(this).addClass("active").siblings().removeClass("active");
    var name = $(this).text();
    var id = $(this).val();
    var provid = $(".js_get_school").children(".active").attr("value");
    $("#school input").val(name).attr("data-id", id).attr("data-provid", provid);
    $("#schoolSelect").hide();
});

//    个人标签自定义添加
$("body").delegate("#selfAdd", "click", function() {
    var labText = $(this).prev().val();
    var spans = new Array();
    var reg = /^([\u4e00-\u9fa5]|[a-zA-Z0-9_\(\)（）])*$/;
    // var reg=/^[0-9A-Za-z\u4e00-\u9fa5]$/;
    if (!reg.test(labText)) {
        layer.msg("自我描述只能是中文,英文,数字", {
            icon:5
        });
        return;
    }
    if (labText != "" && labText.length <= 8) {
        var i = new Date().getTime();
        var sum = 0;
        var check = '<div class="check-box"><input class="check stag" name="stags" id="' + i + '" value="' + labText + '" type="checkbox" checked><label for="' + i + '">' + labText + "</label></div>";
        // $('.stag').each(function(i){
        //     sum = i;
        // });
        // if(sum>=8){
        //     layer.msg('添加的标签太多啦~~！', {icon: 5});
        //     return false;
        // }
        $(".self-depict").val("");
        $(this).parent().parent().find(".self-box").append(check);
        $(".stag:checked").each(function(i) {
            spans[i] = $(this).val();
        });
        str = spans.join("|");
        $('input[name="tags"]').val(str);
    } else {
        if (labText.length > 8) {
            layer.msg("自我描述最多八个字", {
                icon:5
            });
        }
        return;
    }
});

var mytags = $("#resumebaseForm").find('[name="tags"]').val();

var mytag_arr = new Array();

var systag_arr = new Array("社交达人", "学习能力强", "自信", "宅");

var time = "";

var check = "";

mytag_arr = mytags.split("|");

if (mytags.length > 0) {
    for (var i in mytag_arr) {
        time = new Date().getTime() + 1;
        if ($.inArray(mytag_arr[i], systag_arr) == -1) {
            check = '<div class="check-box"><input class="check stag" name="stags" id="' + i + '" value="' + mytag_arr[i] + '" type="checkbox" checked><label for="' + i + '">' + mytag_arr[i] + "</label></div>";
            $("#resumebaseForm").find(".self-box").append(check);
        } else {
            $(".self-box").find('input[value="' + mytag_arr[i] + '"]').attr("checked", true);
        }
    }
}

//        profileEdit my-avatar mask show/hide
$("#avatar").hover(function() {
    $(this).find(".mask").toggle();
});

//教育经历入学年份选择月份默认9月
$("#resume_edu").find('[name="syear"]').change(function() {
    //$('#resume_edu').find('[name="smonth"]').val('9');
    if ($("#resume_edu").find('[name="smonth"]').val() > 0) {
        return;
    } else {
        $("#resume_edu").find('[name="smonth"]').val("9");
    }
});

$("#practice_remarknum").html("<span>" + $("#practice_remark").val().length + "</span>/2000");

count_text_num("#practice_remark", "#practice_remarknum");

//社会实践
count_text_num("#work_remark", ".work_remarknum");

//实习经验
count_text_num("#work_ex", ".work_exnum");

//实习项目经验
count_text_num("#scjob_remark", ".scjob_exnum");

//职务描述
var navH = $("#slideNav").offset().top;

$(window).scroll(function() {
    var scrollH = $(this).scrollTop();
    if (scrollH >= navH) {
        $("#slideNav").addClass("nav-scroll");
    } else {
        $("#slideNav").removeClass("nav-scroll");
    }
});

//教育经历毕业年份选择月份默认6月
$("#resume_edu").find('[name="eyear"]').change(function() {
    //$('#resume_edu').find('[name="smonth"]').val('9');
    if ($("#resume_edu").find('[name="emonth"]').val() > 0) {
        return;
    } else {
        $("#resume_edu").find('[name="emonth"]').val("6");
    }
});

//选择性别，默认头像随之改变
$('[name="gender"]').click(function() {
    var avatar_id = $("#avatar_id").val();
    if (avatar_id == 0) {
        $(".js_avatar_show").html("");
        if ($(this).val() == "2") {
            $(".js_avatar_show").append('<img src="__PUBLIC__/img/female.jpg">');
        } else {
            $(".js_avatar_show").append('<img src="__PUBLIC__/img/man.jpg">');
        }
    }
});

//技能雅思托福
$("body").keyup(function() {
    var ieltsscore = $('[name="ieltsscore"]').val();
    var toeflscore = $('[name="toeflscore"]').val();
    if (ieltsscore.length > 0) {
        $('[name="ielts"]').prop("checked", true);
    }
    if (toeflscore.length > 0) {
        $('[name="toefl"]').prop("checked", true);
    }
});