<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>编辑教育经历</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
    <script type="text/javascript">
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7a83b9c99272e7eb80fa5055220a4ef0";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/resume.css">
    <link rel="stylesheet" href="/Public/js/validationEngine/validationEngine.jquery.css">
    <script src="/Public/js/validationEngine/jquery.validationEngine.js"></script>
    <script src="/Public/js/validationEngine/jquery.validationEngine-zh_CN.js"></script>
    <script src="/Public/js/validate/lib/jquery.form.js"></script>
</head>
<body>
    <header class="header">
        <a class="back js_back_btn" href="JavaScript:;"><i></i></a>
        <span class="title" data="编辑教育经历">编辑教育经历</span>
    </header>
    <div class="footer">
        <div class="logo"><img src="/Public/img/wap/logo.png"/></div>
        <div class="slogan"><img src="/Public/img/wap/slogan.png"/></div>
        <div class="app-download">
            <div class="cartoon"><img src="/Public/img/wap/cartoon.png"/></div>
            <a class="download" href=""><img src="/Public/img/wap/download_btn.png"/></a>
        </div>
    </div>
    <div class="content">
    <form action="/m/resumeEdu.html" method="post" enctype="multipart/form-data" id="resumeEduForm">
        <div class="resume-edit">
            <div class="edit-item right">
                <span class="field-name">学校</span>
                <span class="field-input js_school_val" onclick="setSchool($(this))"><?php echo ($res["school_name"]); ?></span>
                <input type="hidden" name="post[school_province_code]" value="<?php echo ($res["province_code"]); ?>">
                <input type="text" class="validate[required]" name="post[school_id]" value="<?php echo ($res["school_id"]); ?>" style="height:0.5px;width:0px;padding:0px;margin:0px;">
            </div>
            <div class="edit-item">
                <span class="field-name">院系</span>
                <input class="field-input" type="text" name="post[faculty]" value="<?php echo ($res["faculty"]); ?>"/>
            </div>
            <div class="edit-item">
                <span class="field-name">专业分类</span>
                <select class="field-input validate[required]" name="post[major_cid]">
                    <option value="">请选择</option>
                    <?php if(is_array($major_list)): foreach($major_list as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if($res['major_category_id'] == $v[id]): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                </select>
            </div>
            <div class="edit-item">
                <span class="field-name">专业</span>
                <input class="field-input validate[required]" type="text" name="post[major]" value="<?php echo ($res["major"]); ?>" maxlength="10" />
            </div>
            <div class="edit-item down">
                <span class="field-name">入校时间</span>
                <input class="field-input validate[required]" type="month" name="post[sdate]" value="<?php echo (substr($res["sdate"],0,4)); ?>-<?php echo (substr($res["sdate"],4,2)); ?>"/>
            </div>
            <div class="edit-item down">
                <span class="field-name">毕业时间</span>
                <input class="field-input validate[required]" type="month" name="post[edate]" value="<?php echo (substr($res["edate"],0,4)); ?>-<?php echo (substr($res["edate"],4,2)); ?>"/>
            </div>
            <div class="edit-item">
                <span class="field-name">学历</span>
                <select class="field-input validate[required]" name="post[degree]">
                    <option value="1" <?php if($res['degree'] == 1): ?>selected<?php endif; ?>>大专</option>
                    <option value="2" <?php if($res['degree'] == 2): ?>selected<?php endif; ?>>本科</option>
                    <option value="3" <?php if($res['degree'] == 3): ?>selected<?php endif; ?>>硕士</option>
                    <option value="4" <?php if($res['degree'] == 4): ?>selected<?php endif; ?>>博士</option>
                </select>
            </div>
            <?php if($res['id']): ?><input type="hidden" name="post[type]" value="update">
            <input type="hidden" name="post[edu_id]" value="<?php echo ($res['id']); ?>">
            <?php else: ?>
            <input type="hidden" name="post[type]" value="create">
            <input type="hidden" name="post[resume_id]" value="<?php echo ($res['resume_id']); ?>"><?php endif; ?>
            <input class="edit-save edit-over" type="button" onclick="$('#resumeEduForm').submit();" value="完成">
        </div>
    </form>
    </div>
<!--实习居住地、户口所在地、学校选择弹层-->
<div class="resume-popup select_school">
    <div class="popup-info">
        <ul class="left-info scprov_zone">
        <?php if(is_array($prov)): foreach($prov as $key=>$v): ?><li class="info-block" data="<?php echo ($v["code"]); ?>"><?php echo ($v["name"]); ?></li><?php endforeach; endif; ?>
        </ul>
        <ul class="right-info school_zone">
        </ul>
    </div>
</div>


<!--简历信息填写不全返回提示层-->
<div class="popup exit_tixing" style="display:none;">
    <div class="popup-info">
        <a class="popup-close" href="javascript:" onclick="$('.exit_tixing').hide()"><i></i></a>
        <div class="popup-img"><img src="/Public/img/wap/warn.png"/></div>
        <div class="popup-text">
            现在退出简历编写，<br>
            之前所填写内容无法保存哦
        </div>
        <div class="popup-btn">
            <input class="sub-btn" type="button" onclick="$('.exit_tixing').hide()" value="继续填写"/>
            <input class="sub-btn return" type="button" onclick="window.location.href='/m/myResume.html'" value="确认返回"/>
        </div>
    </div>
</div>
<input type="hidden" id="return_url" value="<?php echo (cookie('return')); ?>">
</body>
<script src="/Public/js/wap/mresume.js"></script>
</html>