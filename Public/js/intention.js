	//初始化求职意向期望行业
    $(function(){
    	var trade_arr = new Array();
    	trade_arr = $('input[name="trade_id"]').val().split('/');
    	//console.log(trade_arr);
    	$(".js_intention_trade li").each(function (index,i) {//循环写入隐藏域
    		var trade_id = $(this).val().toString();
    		if($.inArray(trade_id,trade_arr) == -1){
    			$(this).removeClass('active');
    		}else{
    			$(this).addClass('active');
    		}
        });
    });

       //期望城市
    $('.js_intention_province li').click(function(){
        var code = $(this).val();
        var code_arr = new Array();
        code_arr = $('input[name="work_cities_id"]').val().split('/');
      $.get("/ajax/getcity",{code:code},
        function(data){
           if (data.status==1) {
              $('.js_intention_city').html("");
                  var html="";
                  $.each(data.msg,function(index,obj){
                        if($.inArray(obj.code,code_arr)==-1){
                            html+="<li value="+obj.code+">"+obj.name+"</li>";
                        }else{
                            
                            html+="<li value="+obj.code+" class=\"active\">"+obj.name+"</li>";
                        }
 
                     });
                  $('.js_intention_city').append(html);
              }
            },
        "json");
    });

    //新增期望城市
    $("body").delegate(".js_intention_city li","click",function(){ 
        var code = $(this).val();
        var name = $(this).text();
        var html = '<span class="sub-selected js_select_city" data-id='+code+'>'+name+'<i></i></span>';
        var num = $('.js_city_show .sub-selected').length+1;
        var city_id = "";
        var city_name = "";
        if (num > 3){
            return false;
        }
        if($(this).hasClass('active')){
            return false;
        }
        $(this).attr('class','active');
        $('.js_city_show').append(html);

        $(".js_select_city").each(function (index,i) {//循环写入隐藏域
            var id = $(this).attr('data-id');
            var name = $(this).text();
            city_id+= id+'/';
            city_name+= name+'/';
        });
        city_id = city_id.substring(0,city_id.length-1);
        city_name = city_name.substring(0,city_name.length-1);
        $('input[name="work_cities_id"]').val(city_id);
        $('input[name="work_cities_name"]').val(city_name);
    });

    // profileEdit sub-selected del
    $("body").delegate(".js_select_city","click",function(){
        var code = $(this).attr('data-id');
        var city_id ="";
        var city_name = "";
        $('.js_intention_city li[value='+code+']').removeClass('active');
        $(this).remove();
        $(".js_select_city").each(function (index,i) {//循环写入隐藏域
            var id = $(this).attr('data-id');
            var name = $(this).text();
            city_id+= id+'/';
            city_name+= name+'/';
        });
        city_id = city_id.substring(0,city_id.length-1);
        city_name = city_name.substring(0,city_name.length-1);
        $('input[name="work_cities_id"]').val(city_id);
        $('input[name="work_cities_name"]').val(city_name);
    });


     //新增期望行业
    $("body").delegate(".js_intention_trade li","click",function(){ 
        var id = $(this).val();
        var name = $(this).text();
        var html = '<span class="sub-selected js_select_trade" data-id='+id+'>'+name+'<i></i></span>';
        var num = $('.js_trade_show .sub-selected').length+1;
        var trade_id = "";
        var trade_name = "";
        if (num > 3){
            return false;
        }
        if($(this).hasClass('active')){
            return false;
        }
        $(this).attr('class','active');
        $('.js_trade_show').append(html);
        $(".js_select_trade").each(function (index,i) {//循环写入隐藏域
            var id = $(this).attr('data-id');
            var name = $(this).text();
            trade_id+= id+'/';
            trade_name+= name+'/';
        });
        trade_name = trade_name.substring(0,trade_name.length-1);
        trade_id = trade_id.substring(0,trade_id.length-1);
        $('input[name="trade_id"]').val(trade_id);
        $('input[name="trade_name"]').val(trade_name);
    });

    // profileEdit sub-selected del
    $("body").delegate(".js_select_trade","click",function(){
        var id = $(this).attr('data-id');
        var trade_id = "";
        var trade_name = "";
        $('.js_intention_trade li[value='+id+']').removeClass('active');
        $(this).remove();
        $(".js_select_trade").each(function (index,i) {//循环写入隐藏域
            var id = $(this).attr('data-id');
            var name = $(this).text();
            trade_id+= id+'/';
            trade_name+= name+'/';
        });
        trade_name = trade_name.substring(0,trade_name.length-1);
        trade_id = trade_id.substring(0,trade_id.length-1);
        $('input[name="trade_id"]').val(trade_id);
        $('input[name="trade_name"]').val(trade_name);
    });


    //    workDays show/hide
    $("#nature2").click(function () {
        $("#resume_workDays").show();
    });
    $("#nature1").click(function () {
        $("#resume_workDays").hide();
    });
    //连续时长不限
    $('[name="duration"]').click(function(){
      $('input[name="work_duration"]').val("0");
      //$('.js_duration_show').text("1个月");
    });

    //连续时长+
    $('.raise').click(function(){
        var num = $('input[name="work_duration"]').val();//月份
        var str ="";
      $('[name="duration"]').attr('checked',false);
        if (num >=0){
            num++;
            
        }else{
            num =2;
        }
        $('input[name="work_duration"]').val(num);
        str = num+"个月";
        $('.js_duration_show').text(str);
    });

    //连续时长-
    $('.reduce').click(function(){
        var num = $('input[name="work_duration"]').val();//月份
        var str ="";
      $('[name="duration"]').attr('checked',false);
        if (num <=1){
            return false;
        }else{
            num--;
        }
        $('input[name="work_duration"]').val(num);
        str = num+"个月";
        $('.js_duration_show').text(str);
    });

  function intention_city(){//城市初始化
    var html = "";
    var arr = $('input[name="work_cities_name"]').val().split('/');
    var arrid = $('input[name="work_cities_id"]').val().split('/');
      if ($('input[name="work_cities_name"]').val()==0){
        return false;
      }
      for(var i in arr){
       html += '<span class="sub-selected js_select_city" data-id="'+arrid[i]+'">'+arr[i]+'<i></i></span>';

      }
      $('.js_city_show').append(html);
  }


    function intention_trade(){//初始化
    var html = "";
    var arr = $('input[name="trade_name"]').val().split('/');
    var arrid = $('input[name="trade_id"]').val().split('/');
      if ($('input[name="trade_name"]').val()==0){
        return false;
      }
      for(var i in arr){
        html +='<span class="sub-selected js_select_trade" data-id="'+arrid[i]+'">'+arr[i]+'<i></i></span>';
      }
     $('.js_trade_show').append(html);
  }


    //首页简历列表求职意向
    $('#indexIntentionForm').validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent().next());
      
    // }, 
    errorLabelContainer: "#intention_error",
       // ignore: ":hidden",
        onkeyup: false,
        rules : {
            // work_cities_id:{required:true},
            // work_type:{required:true},
            // week_workdays:{required:true},
            // work_duration:{required:true},
        },
        messages : {
            // work_cities_id:{required:'请选择期望城市'},
            // work_type:{required:'请选择工作性质'},
            // week_workdays:{required:'请选择每周工作天数'},
            // work_duration:{required:'请选择连续实习时长'},
 
        },
        submitHandler:function(form) {
            $('#indexIntentionForm').ajaxSubmit({
                url:'/ajax/updateResume',
                type:'POST',
                dataType:'json',
                beforeSubmit:function(){
                  // if($(form).find('[name="work_cities_id"]').val().length == 0){
                  //   layer.msg('请选择期望的工作地点', {icon: 5});
                  // }
                  // if($(form).find('[name="trade_id"]').val().length == 0){
                  //   layer.msg('请选择期望的行业', {icon: 5});
                  // }
                  //layer.msg('保存中...', {icon: 1});
                    $(form).find('.save').val('提交中...').attr('disabled',true);
                },
                success:function(data){
                    //setTimeout(function(){ window.location.href=data.url; },50000);
                    if (data.status == 1) {
                      $(form).find('.save').val('保存成功');
                      setTimeout(function () { $('.js_index_intention').hide(); }, 1000);
                      
                    } else {
                      layer.msg(data.msg, {icon: 5});
                       // $(form).find('.save').val('保存').removeAttr('disabled');
                    }
                }
            });
        }
    });

    //点击提交简历列表求职意向
    $(".intention_resumelist_save").click(function(){
        if($("#resumelist_intention").valid()){
         $("#resumelist_intention").submit();
     }
    });

    //简历列表求职意向
    $('#resumelist_intention').validate({
    //   errorPlacement : function(error, element) { 
    //   error.appendTo(element.parent().next());
      
    // }, 
    errorLabelContainer: "#intention_error",
       // ignore: ":hidden",
        onkeyup: false,
        rules : {
            // work_cities_id:{required:true},
            // work_type:{required:true},
            // week_workdays:{required:true},
            // work_duration:{required:true},
        },
        messages : {
            // work_cities_id:{required:'请选择期望城市'},
            // work_type:{required:'请选择工作性质'},
            // week_workdays:{required:'请选择每周工作天数'},
            // work_duration:{required:'请选择连续实习时长'},
 
        },
        submitHandler:function(form) {
            $('#resumelist_intention').ajaxSubmit({
                url:'/ajax/updateResume',
                type:'POST',
                dataType:'json',
                beforeSubmit:function(){
                  // if($(form).find('[name="work_cities_id"]').val().length == 0){
                  //   layer.msg('请选择期望的工作地点', {icon: 5});
                  //   return false;
                  // }
                  // if($(form).find('[name="trade_id"]').val().length == 0){
                  //   layer.msg('请选择期望的行业', {icon: 5});
                  //   return false;
                  // }
                    $(form).find('.save').val('提交中...').attr('disabled',true);
                },
                success:function(data){
                    //setTimeout(function(){ window.location.href=data.url; },50000);
                    if (data.status == 1) {
                      $(form).find('.save').val('保存成功');
                     window.location.href=window.location.href;
                    } else {
                        layer.msg("保存失败,请重试", {icon: 5});
                        $(form).find('.save').val('保存').removeAttr('disabled');
                    }
                }
            });
        }
    });


        //编辑求职意向
    $('body').delegate('.js_intention_edit','click',function(){
          $('#resume_intention').prev('.profile-show').hide();
          $('#resume_intention').find('.profile-edit').show();
          $('#resume_intention').find('.block-append').hide();
          $('#resume_intention').find('.level-info').show();

    });