<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>编辑个人信息</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/resume.css">
    <link rel="stylesheet" href="/Public/js/validationEngine/validationEngine.jquery.css">
    <script src="/Public/js/validationEngine/jquery.validationEngine.js"></script>
    <script src="/Public/js/validationEngine/jquery.validationEngine-zh_CN.js"></script>
    <script src="/Public/js/validate/lib/jquery.form.js"></script>
</head>
<body>
    <header class="header">
        <a class="back js_back_btn" href="JavaScript:;" data="0"><i></i></a>
        <span class="title" data="编辑个人信息">编辑个人信息</span>
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
    <form action="/m/resumeBase.html" method="post" enctype="multipart/form-data" id="resumeBaseForm">
        <div class="resume-edit">
            <div class="edit-item">
                <span class="field-name">姓名</span>
                <input class="field-input validate[required]" name="post[full_name]" type="text" value="<?php echo ($res["fullname"]); ?>"/>
            </div>
            <div class="edit-item">
                <span class="field-name">性别</span>
                <select class="field-input validate[required]" name="post[gender]">
                    <option value="">请选择</option>
                    <option value="1" <?php if($res['gender'] == 1): ?>selected<?php endif; ?>>男</option>
                    <option value="2" <?php if($res['gender'] == 2): ?>selected<?php endif; ?>>女</option>
                </select>
            </div>
            <div class="edit-item">
                <span class="field-name">手机号码</span>
                <input class="field-input validate[required,custom[phone]]" type="text" value="<?php echo ($res["phone"]); ?>" name="post[mobile]"/>
            </div>
            <div class="edit-item">
                <span class="field-name">Email</span>
                <input class="field-input validate[required,custom[email]]" type="email" value="<?php echo ($res["email"]); ?>" name="post[email]"/>
            </div>
            <div class="edit-item down">
                <span class="field-name">出生日期</span>
                <input class="field-input validate[required]" type="date" name="post[birthday]" value="<?php if(!empty($res['birthday'])): echo (substr($res["birthday"],0,4)); ?>-<?php echo (substr($res["birthday"],4,2)); ?>-<?php echo (substr($res["birthday"],6,2)); endif; ?>"/>
            </div>
            <div class="edit-item right">
                <span class="field-name">实习居住地</span>
                <span class="field-input js_sx_val" data-prov="<?php echo ($res["province_code"]); ?>" data-city="<?php echo ($res["city_code"]); ?>" onclick="setCity($(this),'sx')"><?php echo ($res["city_name"]); ?></span>
                <input class="field-detail validate[required]" type="text" name="post[address]" placeholder="详细街道信息" value="<?php echo ($res["address"]); ?>" data-prompt-position="inline"/>
                <input type="hidden" name="post[province_id]" value="<?php echo ($res["province_code"]); ?>">
                <input class="validate[required]" type="text" name="post[city_id]" value="<?php echo ($res["city_code"]); ?>" style="height:0.5px;width:0px;padding:0px;margin:0px;">
            </div>
            <div class="edit-item right">
                <span class="field-name">户口所在地</span>
                <span class="field-input js_hk_val" data-prov="<?php echo ($res["hk_province_code"]); ?>" data-city="<?php echo ($res["hk_city_code"]); ?>" onclick="setCity($(this),'hk')"><?php echo ($res["hk_city_name"]); ?></span>
                <input type="hidden" name="post[hk_province_id]" value="<?php echo ($res["hk_province_code"]); ?>">
                <input type="text" class="validate[required]" name="post[hk_city_id]" value="<?php echo ($res["hk_city_code"]); ?>" style="height:0.5px;width:0px;padding:0px;margin:0px;">
            </div>
            <div class="edit-item">
                <span class="field-name">身份证号码</span>
                <input class="field-input validate[custom[chinaId]]" type="text" name="post[card_no]" value="<?php echo ($res["card_no"]); ?>"/>
            </div>
            <div class="edit-item">
                <span class="field-name">户口类型</span>
                <select class="field-input validate[required]" name="post[hk_type]">
                    <option value="">请选择</option>
                    <option value="0" <?php if($res['gender'] == 0): ?>selected<?php endif; ?>>城镇户口</option>
                    <option value="1" <?php if($res['gender'] == 1): ?>selected<?php endif; ?>>农村户口</option>
                    <option value="2" <?php if($res['gender'] == 2): ?>selected<?php endif; ?>>集体户口</option>
                </select>
            </div>
            <input type="hidden" name="post[avatar_id]" value="<?php echo ((isset($res["avatar_id"]) && ($res["avatar_id"] !== ""))?($res["avatar_id"]):0); ?>">
            <input type="hidden" name="post[card_type]" value="1">
            <?php if($res['id']): ?><input type="hidden" name="post[type]" value="update">
            <input type="hidden" name="post[id]" value="<?php echo ($res['id']); ?>">
            <?php else: ?>
            <input type="hidden" name="post[type]" value="create">
            <input type="hidden" name="post[resume_id]" value="<?php echo ($res['resume_id']); ?>"><?php endif; ?>
            <input class="edit-save" type="button" onclick="$('#resumeBaseForm').submit();" value="下一步：教育经历">
        </div>
        </form>
    </div>
    <!--实习居住地、户口所在地、学校选择弹层-->
<div class="resume-popup select_city">
    <div class="popup-info">
        <ul class="left-info prov_zone">
        <?php if(is_array($prov)): foreach($prov as $key=>$v): ?><li class="info-block" data="<?php echo ($v["code"]); ?>"><?php echo ($v["name"]); ?></li><?php endforeach; endif; ?>
        </ul>
        <ul class="right-info city_zone">
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
</body>
<script src="/Public/js/wap/mresume.js"></script>
</html>