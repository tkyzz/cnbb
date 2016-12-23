//检测表单是否操作
function formIsDirty(form) {
  for (var i = 0; i < form.elements.length; i++) {
    var element = form.elements[i];
    var type = element.type;
    if (type == "checkbox" || type == "radio") {
      if (element.checked != element.defaultChecked) {
        return true;
      }
    }
    else if (type == "hidden" || type == "password" || type == "text" || type == "textarea") {
      if (element.value != element.defaultValue) {
        return true;
      }
    }
    else if (type == "select-one" || type == "select-multiple") {
      for (var j = 0; j < element.options.length; j++) {
        if (element.options[j].selected != element.options[j].defaultSelected) {
          return true;
        }
      }
    }
  }
  return false;
}


//设置地址
function setCity(obj,type){

	var prov_code = obj.attr('data-prov');
	var city_code = obj.attr('data-city');
	if(prov_code){
		//$('.prov_zone').children('li["data='+prov_code+'"]').addClass('active');
		$('.prov_zone li').each(function(i){
			if ( $(this).attr('data') ==  prov_code){
				//alert($(this).attr('data'));
				$(this).addClass('active').click();
				//$('[name="post[province_id]"]').val($(this).attr('data'));
			}
		});
	}
	if(city_code){
		$('.prov_zone').attr('data-nowcode',city_code);
	}
	$('.city_zone').attr('data-type',type);
	$('.js_back_btn').attr('data',1);
	$('.title').html('选择城市');
	$('.select_city').show();

}
//点击返回按钮
$('.js_back_btn').click(function(){
	var type = $(this).attr('data');
	var title = $('.title').attr('data');
	var formname = $('form').attr('id');
	//alert(formname);
	if ( type == 1 ){
		$('.js_back_btn').attr('data',0);
		$('.title').html(title);
		$('.resume-popup').hide();
	}else {
		if (formIsDirty(document.forms[formname])) {
			$('.exit_tixing').show();
		}else {
			window.location.href='/m/myResume.html';
		}
		
	}
});

//选择学校
function setSchool(obj){
	// var prov_code = obj.attr('data-prov');
	// var city_code = obj.attr('data-city');
	// if(prov_code){
	// 	$('.prov_zone["data='+prov_code+'"]').addClass('active');
	// }
	// if(city_code){
	// 	$('prov_zone').attr('data-nowcode',city_code);
	// }
	// $('.city_zone').attr('data-type',type);
	$('.title').html('选择学校');
	$('.js_back_btn').attr('data',1);
	$('.select_school').show();

}
//获取城市
function getCity(code,nowcode){
    var html = "";
    $.get("/ajax/getcity", {
        code:code
    }, function(data) {
        if (data.status == 1) {
            $.each(data.msg, function(index, obj) {
                if (nowcode == obj.code) {
                    html += '<li class="info-block active" data="'+obj.code+'">'+obj.name+'</li>';
                } else {
                	html += '<li class="info-block" data="'+obj.code+'">'+obj.name+'</li>';
                }
            });
            $('.city_zone').html("");
            $('.city_zone').append(html);
        }
    }, "json");
}

//获取学校
function getSchool(code,nowcode){
    var html = "";
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
                html += '<li class="info-block" data="'+obj.id+'">'+obj.name+'</li>';
            });
            $('.school_zone').html("");
            $('.school_zone').append(html);
        }
    }, "json");
}

//点击省份选择城市
$('.prov_zone li').click(function(){
	var code = $(this).attr('data');
	var nowcode = $(this).attr('data-nowcode');
	//alert(nowcode);
	getCity(code,nowcode);
	$(this).addClass('active').siblings().removeClass("active");
});


//点击省份选择学校
$('.scprov_zone li').click(function(){
	var code = $(this).attr('data');
	var nowcode = $(this).attr('data-nowcode');
	getSchool(code,nowcode);
	$(this).addClass('active').siblings().removeClass("active");
});

// $('.city_zone li').click(function(){
// 	alert(1);
// });
//点击城市
//$(".city_zone li").bind("click",function(){
$(".city_zone ").delegate("li","click",function(){
	var name = $(this).text();
	var code = $(this).attr('data');
	var type = $('.city_zone').attr('data-type');
	
	$('.title').html($('.title').attr('data'));
	if( type == 'sx' ) {
		$('.js_sx_val').text(name);
		$('[name="post[city_id]"]').val(code);
		$('.prov_zone li').each(function(i){
			if ( $(this).hasClass('active') ){
				$('[name="post[province_id]"]').val($(this).attr('data'));
			}
		});
	} else if( type == 'hk' ) {
		$('.js_hk_val').text(name);
		$('[name="post[hk_city_id]"]').val(code);
		$('.prov_zone li').each(function(i){
			if ( $(this).hasClass('active') ){
				$('[name="post[hk_province_id]"]').val($(this).attr('data'));
			}
		});
	}
	$('.select_city').hide();

});


//点击学校
$(".school_zone").delegate("li","click",function(){
	var name = $(this).text();
	var code = $(this).attr('data');
	var type = $('.city_zone').attr('data-type');
	$('.title').html($('.title').attr('data'));
	$('.js_school_val').text(name);
	$('[name="post[school_id]"]').val(code);
	$('.scprov_zone li').each(function(i){
		if ( $(this).hasClass('active') ){
			$('[name="post[school_province_code]"]').val($(this).attr('data'));
		}
	});
	$('.select_school').hide();

});
//ata-prompt-position="inline"
	$.validationEngine.defaults.scroll = false;
    $("#resumeBaseForm").validationEngine({
        showOneMessage:true,
        promptPosition:"inline",
        ajaxFormValidation:true,
        ajaxFormValidationMethod:"post",
        onBeforeAjaxFormValidation:function(form, options){
        	$('.edit-save').attr('disabled',true);
            $("#resumeBaseForm").ajaxSubmit({
                url:"/m/resumeBase",
                type:"post",
                dataType:"json",
                async:false,
                success:function(data){
                    if( data.status == 1 ){
                    	layer.msg("提交成功",{icon:1});
                    	window.location.href = '/m/resumeEdu.html'
                    }else{
                    	$('.edit-save').removeAttr('disabled');
                    	layer.msg(data.msg,{icon:2});
                    }
                },
                error:function(msg){
                	$('.edit-save').removeAttr('disabled');
                    layer.alert("出错了,请重试");
                }
            });
            return false;
        },
        onAjaxFormComplete:function(status, form, json, options){
            
        }
    });


    $("#resumeEduForm").validationEngine({
        showOneMessage:true,
        promptPosition:"inline",
        ajaxFormValidation:true,
        ajaxFormValidationMethod:"post",
        onBeforeAjaxFormValidation:function(form, options){
        	$('.edit-save').attr('disabled',true);
            $("#resumeEduForm").ajaxSubmit({
                url:"/m/resumeEdu",
                type:"post",
                dataType:"json",
                async:false,
                success:function(data){
                    if( data.status == "1" ){
                    	layer.msg("提交成功",{icon:1});
                        var return_url = $('#return_url').val();
                        if(return_url){
                            window.location.href = return_url;
                        }else{
                            window.location.href = '/m/myResume.html';
                        }
                    	
                    }else{
                    	$('.edit-save').removeAttr('disabled');
                    	layer.msg(data.msg,{icon:2});
                    }
                },
                error:function(msg){
                	$('.edit-save').removeAttr('disabled');
                    layer.alert("出错了,请重试");
                }
            });
            return false;
        },
        onAjaxFormComplete:function(status, form, json, options){
            
        }
    });
