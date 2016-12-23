<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"><title>我的简历</title><link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /><link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css"><script src="/Public/js/jquery.min.js"></script><script src="/Public/js/layer/layer.js"></script><link rel="stylesheet" type="text/css" href="/Public/css/h5/resume.css"></head><body><div class="page"><header class="header"><a class="back" href="/mpostList.html"><i></i></a><span class="title">我的简历</span></header><div class="footer"><div class="logo"><img src="/Public/img/wap/logo.png"/></div><div class="slogan"><img src="/Public/img/wap/slogan.png"/></div><div class="app-download"><div class="cartoon"><img src="/Public/img/wap/cartoon.png"/></div><a class="download" href="<?php echo ($download_url); ?>"><img src="/Public/img/wap/download_btn.png"/></a></div></div><div class="content"><form id="avatarform" name="avatarform" method="post" ><div class="resume-block"><p class="block-title">添加头像</p><div class="block-info"><div class="my-avatar"><div class="avatar-img"><?php if(!empty($res["avatar_url"])): ?><img class="js_avatar_show" src="<?php echo ($res["avatar_url"]); ?>"><?php else: if($res['gender'] == 2): ?><img class="js_avatar_show" src="/Public/img/female.jpg"><?php else: ?><img class="js_avatar_show" src="/Public/img/man.jpg"><?php endif; endif; ?></div><div class="avatar-edit"><i></i></div><input class="avatar-upload" name="avatar_file" id="avatar_file" type="file"></div><p class="upload-text">点击更换</p><p class="upload-tips">上传正方形照片，展示最佳效果！</p></div></div></form><div class="resume-block"><p class="block-title">基本信息</p><div class="block-info"><a class="resume-edit" href="/mresumeBase.html"><i></i>编辑</a><div class="field-bar my-name"><span class="field-name">姓名</span><span class="field-cont"><?php echo ($res["fullname"]); ?></span></div><div class="field-bar"><span class="field-name">性别</span><span class="field-cont"><?php echo (smartGender($res["gender"])); ?></span></div><div class="field-bar"><span class="field-name">手机号码</span><span class="field-cont"><?php echo ($res["phone"]); ?></span></div><div class="field-bar"><span class="field-name">身高</span><span class="field-cont"><?php echo ($res["height"]); ?></span></div><div class="field-bar"><span class="field-name">Email</span><span class="field-cont"><?php echo ($res["email"]); ?></span></div><div class="field-bar"><span class="field-name">出生日期</span><span class="field-cont"><?php echo (substr($res["birthday"],0,4)); ?>年<?php echo (substr($res["birthday"],4,2)); ?>月<?php echo (substr($res["birthday"],6,2)); ?>日</span></div><div class="field-bar"><span class="field-name">实习居住地</span><span class="field-cont"><?php echo ($res["province_name"]); echo ($res["city_name"]); echo ($res["address"]); ?></span></div><div class="field-bar"><span class="field-name">户口所在地</span><span class="field-cont"><?php echo ($res["hk_province_name"]); echo ($res["hk_city_name"]); ?></span></div><div class="field-bar"><span class="field-name">户口类型</span><span class="field-cont"><?php echo (smartResumeDict(hktype,$res["hk_type"])); ?></span></div><div class="field-bar"><span class="field-name">身份证号码</span><span class="field-cont"><?php echo ($res["card_no"]); ?></span></div><div class="field-bar"><span class="field-name">政治面貌</span><span class="field-cont"><?php echo (smartResumeDict(politics,$res["politics"])); ?></span></div><div class="field-bar"><span class="field-name">自我描述</span><span class="field-cont"><?php echo (implode(；,$res["tags"])); ?></span></div></div></div><?php if(!empty($edu["id"])): ?><div class="resume-block"><p class="block-title">教育经历</p><div class="block-info"><a class="resume-edit" href="/mresumeEdu.html"><i></i>编辑</a><?php if(!empty($edu["school_name"])): ?><div class="field-bar my-name"><span class="field-name">学校</span><span class="field-cont"><?php echo ($edu["school_name"]); ?></span></div><?php endif; if(!empty($edu["faculty"])): ?><div class="field-bar"><span class="field-name">院系</span><span class="field-cont"><?php echo ($edu["faculty"]); ?></span></div><?php endif; if(!empty($edu['major_category_name'])): ?><div class="field-bar"><span class="field-name">专业分类</span><span class="field-cont"><?php echo ($edu['major_category_name']); ?></span></div><?php endif; if(!empty($edu["major"])): ?><div class="field-bar"><span class="field-name">专业</span><span class="field-cont"><?php echo ($edu["major"]); ?></span></div><?php endif; if(!empty($edu["sdate"])): ?><div class="field-bar"><span class="field-name">入校时间</span><span class="field-cont"><?php echo (substr($edu["sdate"],0,4)); ?>-<?php echo (substr($edu["sdate"],4,2)); ?></span></div><?php endif; if(!empty($edu["edate"])): ?><div class="field-bar"><span class="field-name">毕业时间</span><span class="field-cont"><?php echo (substr($edu["edate"],0,4)); ?>-<?php echo (substr($edu["edate"],4,2)); ?></span></div><?php endif; if(!empty($edu["degree"])): ?><div class="field-bar"><span class="field-name">学历</span><span class="field-cont"><?php echo (smartDegree($edu["degree"])); ?></span></div><?php endif; ?></div></div><?php endif; ?></div></div><input type="hidden" id="id" value="<?php echo ($res["id"]); ?>"></body><script src="/Public/js/validate/lib/jquery.form.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/jquery.validate.js?<?php echo date("Ymd");?>"></script><script src="/Public/js/validate/dist/localization/messages_zh.js?<?php echo date("Ymd");?>"></script><script type="text/javascript">      //图片上传
    $("#avatar_file").change(function(){
      var fname = $('#avatar_file').val();
        if (fname){
            if (/\.(jpg|jpeg|png)$/i.test(fname)){
                $('#avatarform').submit();
            }else{
                $('#avatar_file').val("");
                 layer.msg('上传格式不正确', {icon: 2});
            }
        }return ;
    });
    $('#avatarform').validate({
        rules : {},
        messages : {},
        submitHandler:function(form) {
            $('#avatarform').ajaxSubmit({
                dataType:'json',
                url:'/picUpload',
                data:{name:'avatar_file'},
                beforeSubmit:function(){},
                success:function(data){
                     $('#avatar_file').val("");
                    if (data.status == 1) {
                        var path = data.path;
                        $.post("/updateAvatar",{avatar_id:data.file_id,id:$('#id').val()},
                          function(data){
                             if (data.status==1) {
                                $(".js_avatar_show").attr('src',path);
                                } else {

                                    layer.msg(data.msg, {icon: 5});
                                }
                              },
                          "json");
                        
                        //$('.avatar_id').val(data.file_id);
                    } else {
                        ///showDialogInfo(data.msg);
                        //$("#avatar_file").val('');
                        //$('.mask').show();
                         layer.msg(data.msg, {icon: 5});
                    }
                }
            });
        }
    });
</script></html>