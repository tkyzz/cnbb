$(function(){
	
	
	
    //帐号注册表单验证
    $('#newregisterform').validate({
        errorPlacement:function(error,element){
            if(element.attr('name') == 'gender'){
                error.appendTo(element.parent().parent());
            }else{
                error.appendTo(element.parent());
            }
        },
        rules : {
            email : { required : true,email : true,remote : { url :'/ajax_check?op=checkemail',data:{ email : function(){ return $('#email').val();}}}},
            emailphone : { required : true, isEmailPhone: true, remote : { url :'/ajax_check?op=checkemailphone',data:{ emailphone : function(){ return $('#emailphone').val();}}
            /*
            ,success:function(data){ 
            	if(data){
            		//alert(1)
            		$('#phonebox').show();
            	} else {
            		//alert(0)
            		$('#phonebox').hide();
            	}
            	//alert(data);
            	
            } */
            
            } },
            password : { required : true,rangelength : [6,15]},
            username : { required : true,userNamecheck : true, numCheck:true,rangelength : [2,10]},
            gender : { required: true},
            cname : { required : true,userNamecheck : true, numCheck:true,rangelength : [2,30],remote : { url : '/ajax_check?op=comname',data : { name : function(){ return 	$('#cname').val();},'uid':$('#uid').val()}}},
            checkcode : { required: true, rangelength:[4,4] },
            phonecode : { required: true, rangelength:[4,4] }
        },
        messages : {
        	email : { required : '请输入邮箱',email : '请输入正确的邮箱格式',remote : '邮箱已存在'},
        	emailphone : { required : '请输入邮箱或手机号',isEmailPhone : '请填写正确的邮箱或手机号',remote:'邮箱或手机号已经存在' },
            password : { required : '请填写密码',rangelength : '{0}-{1}个字符，请使用字母、数字或符号'},
            username : { required : '请填写姓名', userNamecheck : '请不要输入非法字符', numCheck:'不能是纯数字', rangelength : $.validator.format('请输入{0}-{1}个字') },
            gender : { required : '请选择性别'},
            cname : { required : '请填写公司全称', userNamecheck : '请不要输入非法字符',numCheck:'不能是纯数字',rangelength :  $.validator.format('请输入{0}-{1}个字') ,remote : '该公司已存在'},
            checkcode : { required: '请输入图片中的验证码', rangelength:'请输入四位图片验证码' },
            phonecode : { required: '请填写动态密码', rangelength:'请输入四位动态密码'  }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                dataType:'json',
                url:'/user/register',
                beforeSubmit:function(){
                	$('button[type="submit"]').text('注册中...').attr('disabled', true);
                },
                success:function(data){
                    if (data.res==1) {
                        setTimeout(function(){ window.location.href='/user/activate?refer='+data.refer; },500);
                    } else {
                        $('.last_error').text(data.msg).show().css('color','#a94442');
                        $('button[type="submit"]').text('立即注册').attr('disabled', false);
                    }
                }
            });
        }
    });
    $("#apiLoginSub").click(function(){
        $("#userloginform").submit();
        return false;
    });
    //帐号登录验证
    $('#userloginform').validate({
        errorPlacement:function(error,element){
                error.appendTo(element.parent().parent());
        },
        rules : {
            username:{ required : true},
            password:{ required : true}
        },
        messages : {
            username:{ required : "请输入邮箱/手机号"},
            password:{ required:"密码不能为空"}
        },
        submitHandler: function(form) {
            //form.submit();
            $('#userloginform').ajaxSubmit({
                dataType:'json',
                url:'www.tp.com/index.php/Home/user/login',
                beforeSubmit:function(){
                	$('input[type="submit"]').text('登录中...');
                },
                success:function(data){
                    alert(data);
                    setTimeout(function(){ window.location.href=data.refer; },500);
                    if(data.api){
                        showDialog(data.api,'apibind');
                    }else{
                        if(data.res==1){
                            setTimeout(function(){ window.location.href=data.refer; },500);
                        }else{
                            $('span[for=logerror]').text(data.msg).show();
                            $('button[type="submit"]').text('登录');
                            return false;
                        }
                    }

                }
            });
        }
    });
    // 性别选择
    $('.gender .test').click(function() {
        $(this).addClass('test_act').siblings().removeClass('test_act');
    });
    //激活邮箱
    $("body").delegate("#resend_email","click",function(){
        $.post("/ajax_send_email", { email: $("#email").val(),'type':$('#emailtype').val()},
            function(data){
                if (data.res == 1) {
                    $("#dis_resend").html('<span id="remain">60</span><span>秒后重新发送邮件</span>');
                    setTimeout('show_time()',1000);
                }else{
                    showDialogInfo(data.msg);
                }

            },'json');
        return false;
    });

    //完善名片
    $('#cardInfo .identity').click(function(){
        var identity = $('#cardInfo .identity:checked').val();
        if(identity == 1){//学生
            $('.student').show();
            $('.worker').hide();
            $('#cardView .card_info').text('请先填写专业名称');
            $('#cardView .card_content').text('请先填写学校名称');
        }else{//已工作
            $('.student').hide();
            $('.worker').show();
            $('#cardView .card_info').text('请先填写职位名称');
            $('#cardView .card_content').text('请先填写企业真实名称');
        }
    });
    if($('#cardInfo .identity').length>0){
        $('#cardInfo .identity:checked').trigger('click');
    }
    if($('#cardInfo #name').length>0){
        $('#cardView .card_info').text('请先填写企业所属行业');
        $('#cardView .card_content').text('请先填写企业所在地址');
    }
    //预览名片信息
    $('.changeInfo').on('change',function(){
        $('#cardView  .card_info').text($(this).val());
    });
    $('.changeContent').on('blur',function(){
        if($(this).val()){
            $('#cardView  .card_content').text($(this).val());
        }
    });
    $('#address,#prov,#city').on('change',function(){
        $('#cardView  .card_content').text($('#prov option:selected').text()+' '+$('#city option:selected').text()+' '+$('#address').val());
    });
    
    $('ul[op="prov"]').click(function(){
    	$('span[for="curprov"]').hide();
    });
    $('ul[op="curcity"]').click(function(){
    	$('span[for="curcity"]').hide();
    });
    $('ul[op="position"]').click(function(){
    	$('span[for="cjobfir"]').hide();
    });
    $('input[name="tradesel"]').on('click',function(){
    	$('span[for="tradeid"]').hide();
    });
    $('#enddate').click(function(){
    	$('span[for="lyear"],span[for="lmonth"]').hide();
    });    
    //提交名片信息
    $('#updateCard').validate({
        errorPlacement:function(error,element){
            if(element.attr('name') == 'curprov' || element.attr('name') == 'curcity' || element.attr('name') == 'city' || element.attr('name') == 'prov'){
                error.appendTo(element.parent());
            }else{
                error.appendTo(element.parent());
            }
        },
        rules:{
            username:{ required:true,userNamecheck:true,numCheck:true},
            company:{ required:true,numCheck:true,rangelength:[2,30]},
            cjob:{ required:true,numCheck:true},
            cjobfir:{ required:true},
            wyear:{ required:true},
            wmonth:{ required:true},
            lyear:{ required:true,checkWorkTime:true},
            lmonth:{ required:true},
            school:{ required:true,numCheck:true},
            specialty:{ required:true,numCheck:true},
            schyear:{ required:true},
            schmonth:{ required:true},
            gradyear:{required:true,checkEduTime:true},
            gradmonth:{ required:true},
            curprov:{ required:true},
            curcity:{ required:true},
            name:{ required:true,numCheck:true,remote:{ url :'/ajax_check?op=comname',type:'post',data:{ name : function(){ return $('#name').val();},uid:$('#uid').val()}}},
            ename:{ required:true,numCheck:true,remote:{ url :'/ajax_check?op=comname',type:'post',data:{ ename : function(){ return $('#ename').val();},uid:$('#uid').val()}}},
            tradeid:{ required:true},
            prov:{ required:true},
            city:{ required:true},
            address:{ required:true,numCheck:true,rangelength:[2,30]}
        },messages:{
            username:{ required:'请输入真实姓名',userNamecheck:'输入内容含有非法字符',numCheck:'输入内容不能为纯数字'},
            company:{ required:'请输入所在公司',numCheck:'输入内容不能为纯数字',rangelength: $.validator.format('字符长度{0}-{1}')},
            cjob:{ required:'请输入职位名称',numCheck:'输入内容不能为纯数字'},
            cjobfir:{ required:'请选择职位类型'},
            wyear:{ required:'请选择入职年份'},
            wmonth:{ required:'请选择入职月份'},
            lyear:{ required:'请选择离职年份',checkWorkTime:'入职年月不能大于离职年月'},
            lmonth:{ required:'请选择离职月份'},
            school:{ required:'请输入所在学校',numCheck:'输入内容不能为纯数字'},
            specialty:{ required:'请输入所学专业',numCheck:'输入内容不能为纯数字'},
            schyear:{ required:'请选择入学年份'},
            schmonth:{ required:'请选择入学月份'},
            gradyear:{ required:'请选择毕业年份',checkEduTime:'入学年份不能大于毕业年份'},
            gradmonth:{ required:'请选择毕业月份'},
            curprov:{ required:'请选择所在省份'},
            curcity:{ required:'请选择所在城市'},
            name:{ required:'请输入企业名称',numCheck:'输入内容不能为纯数字',remote:'企业名称已存在'},
            ename:{ required:'请输入企业简称',numCheck:'输入内容不能为纯数字',remote:'企业简称已存在'},
            tradeid:{ required:'请选择行业'},
            prov:{ required:'请选择企业所在省份'},
            city:{ required:'请选择企业所在城市'},
            address:{ required:'请输入企业地址',numCheck:'输入内容不能为纯数字',rangelength: $.validator.format('字符长度{0}-{1}')}
        },submitHandler:function(form){
            $(form).ajaxSubmit({
                url:'/ajax_card',
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(data.code == 0){
                        showDialogInfo(data.msg);
                    }else{
                        window.location.href = '/user/memberfollow';
                    }
                }
            })
        }
    });
    //关注他们--推荐用户
    $('.addFollowUser').click(function(){
        var uids = [];
        $('.hiddenUid').each(function(index,obj){
            uids.push($(this).val());
        });
        $.ajax({
            url:'/ajax_operateGroup',
            type:'post',
            data:{'op':'addfollow','uid':uids},
            dataType:'json',
            success:function(data){
                window.location.href = '/user/home';
            }
        });
    });
    //推荐关注  换一换
    $("body").delegate(".changefollow","click",function(){
        var uid = $(this).attr('data');
        var page = $(this).attr('page');
        var fobj = $(this);
        $.post('/ajax_followmember',{uid:uid,page:page},function(data){
            var html = '';
            if(uid){
                $.each(data.msg,function(index,obj){
					html += '<div class="media-body">';
					html += '<div class="media-heading"><a title="'+obj.username+'" target="_blank" href="'+obj.url+'" class="f16">'+obj.username+'</a><span class="ml10 mr10">'+obj.info+'</span></div>';
					html += '<div class="pt5">'+obj.title+'</div>';
					html += '</div>';
					html += '<div class="media-right"><img class="media-object" title="'+obj.username+'" alt="'+obj.username+'" src="'+obj.logo+'"/>';
					html += '<input class="hiddenUid" type="hidden" value="'+obj.uid+'" name="uids[]">';
					html += '</div>';
					html += '<a class="close changefollow" page="'+data.page+'" data="'+obj.uid+'" title="不关注他"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>'; 
                });
                if(html.indexOf("undefined")!=-1 || html.indexOf("null")!=-1){html='已经没有了';}
                fobj.parent().html(html);
            }else{
                $.each(data.msg,function(i, item){
                    if(i%2 == 0){
                        html += '<ul class="col-md-5  pull-left">';
                    }else{
                        html += '<ul class="col-md-5  pull-right">';
                    }
                    $.each(item,function(j,obj){
                        if(i%2 == 0){
                            if(j%2 == 0){
                                html += '<li >';
                            }else{
                                html += '<li class="mr65">';
                            }
                        }else{
                            if(j%2 == 0){
                                html += '<li>';
                            }else{
                                html += '<li class="ml65">';
                            }
                        }
                        html += '<div class="media-body">';
						html += '<div class="media-heading"><a title="'+obj.username+'" target="_blank" href="'+obj.url+'" class="f16">'+obj.username+'</a><span class="ml10 mr10">'+obj.info+'</span></div>';
						html += '<div class="pt5">'+obj.title+'</div>';
						html += '</div>';
						html += '<div class="media-right"><img class="media-object" title="'+obj.username+'" alt="'+obj.username+'" src="'+obj.logo+'"/>';
						html += '<input class="hiddenUid" type="hidden" value="'+obj.uid+'" name="uids[]">';
						html += '</div>';
						html += '<a class="close changefollow" page="'+data.page+'" data="'+obj.uid+'" title="不关注他"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>'; 
	                    html += '</li>';
                    });
                    html += '</ul>';
                });
                if(!html){html='已经没有了';}
                $('.contact_boxa').html(html);
                fobj.attr('page',data.page);
            }
        },'json');
    });

    //忘记密码
    $('#forgotform').validate({
        rules : {
            email:{ required:true,email : true,remote : { url : "/ajax_check?op=forgotemail",data:{ email : function(){ return $('#email').val(); }}}}
        },
        messages:{
            email:{ required:"邮箱不能为空",email : "邮箱格式不正确",remote : "该邮箱没有注册，请重新输入"}
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    //找回密码
    $("body").delegate("#a_resend_email","click",function(){ 
        $.post("/ajax_forgot_resend_email", { email: $("#email").val()},
            function(data){
                if (data.res == 1) {
                    $("#dis_resend").html('<span id="remain">60</span><span>秒后重新发送邮件</span>');
                    setTimeout('show_time()',1000);
                }else{ showDialogInfo(data.msg);}
            },'json');
        return false;
    });
    //重置密码
    $('#resetpwd-form').validate({
        rules : {
            newpwd : { required : true,rangelength:[6,15]},
            confpwd : { required : true,equalTo : '#newpwd'}
        },
        messages : {
            newpwd : { required : '密码不能为空',rangelength: $.validator.format('密码长度{0}-{1}位')},
            confpwd : { required : '确认密码不能为空',equalTo : '两次输入的密码不一致'}
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                dataType:'json',
                beforeSubmit:function(){
                },
                success:function(data){
                    //showDialogInfo(data.msg);
                    if(data.res==1){
                        setTimeout(function(){ window.location.href='/user/login'; },500);
                    }
                }
            });
        }
    });

    $("body").delegate("input[type=radio][name=identinfo]","click",function(){ 
        $("#identity").val($(this).attr("cval"));
        $("span[for=identity]").remove();
    });
    //帐号中心基本资料修改
    $('#updatebase').validate({
        errorPlacement:function(error,element){
            var arr = ['curcity','political','marry'];
            if($.inArray(element.attr('name'), arr) >= 0){
                error.appendTo(element.parent().parent());
            }else{
                error.appendTo(element.parent());
            }
        },
        ignore: "",
        rules : {
            realname : {required:true},
            gender:{required:true,range:[1,2] },
            birth	 : {required:true},
            curcity  : {required:true},
            identity : {required:true,min:1,number:true},
            height:{digits: true,max:300,min:50},
            weight:{digits: true,max:500,min:30},
            nation:{rangelength: [0, 20]},
            marry : {range: [1, 4]},
            political : {range: [1, 4]},
            idcard : {rangelength: [18,18]}
        },
        messages : {
            realname : {required:'真实姓名不能为空'},
            gender	 : {required:'性别必选',range:'性别必选'},
            birth	 : {required:'生日不能为空'},
            curcity  : {required:'所在地不能为空'},
            identity : {required:'请选择身份',min:'请选择身份',number:'请选择身份'},
            height : {digits:'请输入有效身高',min:'请输入有效身高',max:'请输入有效身高'},
            weight : {digits:'请输入有效体重',min:'请输入有效体重',max:'请输入有效体重'},
            nation : {rangelength : '民族最多20字'},
            marry : {range:'婚姻状况必选'},
            political : {range:'政治面貌必选'},
            idcard : {rangelength : '请输入正确的身份证号'}
        },
        submitHandler: function(form) {
            $('#updatebase').ajaxSubmit({
                dataType:'json',
                url:'/user/base',
                beforeSubmit:function(){
                },
                success:function(data){
                	if (data.res == 1) {
                		$('#msg').addClass('bg-success').removeClass('bg-danger').html(data.msg).show().delay(1000).fadeOut('slow');
                	} else {
                		$('#msg').addClass('bg-danger').removeClass('bg-success').html(data.msg).show().delay(1000).fadeOut('slow');
                	}
                    
                }
            });
        }
    });
    //企业修改基本资料表单验证
    $('#compbase-form').validate({
    	errorPlacement:function(error,element){
    		var arr = ['natureid', 'provid', 'cityid', 'sizeid'];
            if($.inArray(element.attr('name'), arr) >= 0){
                error.appendTo(element.parent().parent());
            }else{
                error.appendTo(element.parent());
            }
        },
        ignore:'',
        rules : {
            name : {required :true,userNamecheck : true, numCheck:true,rangelength : [2,20],remote:{url:'/ajax_check?op=comname',data:{ name:function(){ return $('#name').val();},uid:function(){ return $('#uid').val();}}}},
            natureid : {required :true},
            tradeid : {required :true,min:1},
            sizeid:{ required:true},
			founding:{ required:true},
			financle:{ required:true},
            provid:{ required:true},
            cityid:{ required:true},
            address:{ required:true,rangelength:[2,50]},
            website:{ url:true},
            advantage:{ required:true,rangelength:[2,50]},
            content:{ required:true,minlength:10}
        },
        messages : {
            name : {required :'企业名称不能为空',userNamecheck : '请不要输入非法字符',numCheck:'不能是纯数字',rangelength :  $.validator.format('请输入{0}-{1}个字'),remote:'企业名称已存在'},
            natureid : {required :'企业类型不能为空'},
            tradeid : {required :'所属行业不能为空',min:'所属行业不能为空'},
            sizeid:{ required:'请选择企业规模'},
			founding:{ required:'请输入成立时间'},
			financle:{ required:'请选择融资阶段'},
            provid:{ required:'请选择企业所在省份'},
            cityid:{ required:'请选择企业所在城市'},
            address:{ required:'请输入企业详细地址',rangelength:'字符长度{0}-{1}'},
            website:{ url:'企业网站网址格式错误'},
            advantage:{ required:'请输入企业口号',rangelength:'字符长度{0}-{1}'},
            content:{ required:'请输入企业简介',minlength : $.validator.format('至少{0}个字')}
        },
        submitHandler: function(form) {
            //form.submit();
            $(form).ajaxSubmit({
                dataType:'json',
                beforeSubmit:function(){
                },
                success:function(data){
                    showDialogInfo(data.msg);
                    setTimeout(function(){ closedialog();},2000);
                }
            });
        }
    });
    //帐号中心修改联系方式
    $('#updatecontactform').validate({
        /*errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },*/
        rules : {
			hr : { required:true},
            telcode : { required:true,telcode:true},
            telvalue:{ required:true,isTelNo:true},
            mobile : { required:true,isMobile:true},
            email : { required:true,email:true,remote:{ url:'/ajax_check?op=changeemail',data:{ email:function(){ return $('#email').val();}}}},
            qq:{ isQQ:true},
            weixin:{ rangelength:[6,20]}
        },
        messages : {
			hr : { required:'请填写HR姓名'},
            telcode : { required:'请填写区号',telcode:'区号格式不正确'},
            telvalue:{ required:'请填写电话',isTelNo:'电话格式不正确'},
            mobile : {required:'手机号不能为空',isMobile:'手机格式不正确'},
            email : { required:'邮箱不能为空',email:'邮箱格式不正确',remote:'邮箱已被占用'},
            qq:{ isQQ:'QQ格式不正确'},
            weixin:{ rangelength:'微信长度{0}-{1}位'}
        },
        submitHandler: function(form) {
        	 $(form).ajaxSubmit({
                 dataType:'json',
                 url:'/user/contact',
                 beforeSubmit:function(){
                 },
                 success:function(data){
                     if (data.res == 1) {
                		$('#contact_msg').addClass('bg-success').removeClass('bg-danger').html(data.msg).show().delay(1000).fadeOut('slow');
                	} else {
                		$('#contact_msg').addClass('bg-danger').removeClass('bg-success').html(data.msg).show().delay(1000).fadeOut('slow');
                	}
                 }
             });
        }
    });
    //帐号中心修改登录密码
    $('#editpassword-form').validate({
        onkeyup: false,
        rules : {
            curpwd :{ required:true},
            newpwd :{ required:true,rangelength:[6,15]},
            confpwd :{ required:true,equalTo:'#newpwd'}
        },
        messages : {
            curpwd :{ required:"当前密码不能为空"},
            newpwd :{ required:"新密码不能为空",rangelength:  $.validator.format("密码长度{0}-{1}位")},
            confpwd :{ required:"确认密码不能为空",equalTo:'两次输入密码不一致'}
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                dataType:'json',
                url:'/user/password',
                beforeSubmit:function(){
                },
                success:function(data){
                    if (data.res == 1) {
                		$('#psw_msg').addClass('bg-success').removeClass('bg-danger').html(data.msg).show().delay(1000).fadeOut('slow');
                	} else {
                		$('#psw_msg').addClass('bg-danger').removeClass('bg-success').html(data.msg).show().delay(1000).fadeOut('slow');
                	}
                }
            });
        }
    });
    //屏蔽设置
    $("body").delegate("a[ctype=ignore]","click",function(){
        var id = $(this).attr('data-id');
        var op = $(this).attr('data-op');
        if(!id || !op){ return false;}
        $.post('/ajax_home',{op:op,id:id},function(data){
            if(data.res){
                if(op == 'ignore' || op == 'cancel-ignore'){
                    $('.feed_user_'+data.msg).remove();
                }else if(op == 'ignoreall'){
                    $('.feed_'+data.msg).remove();
                }
            }else{
                showDialogInfo(data.msg);
            }

        },'json');
    });

    //动态设置
    $('#feed-setting-form').validate({
        rules:{},messages:{},
        submitHandler:function(form){
            var confme = [];
            $('.confme').each(function(index,element){
                if(!$('.confme').eq(index).attr('checked')){
                    confme.push($('.confme').eq(index).val());
                }
            });
            var conf = [];
            $('.conf').each(function(index,element){
                if(!$('.conf').eq(index).attr('checked')){
                    conf.push($('.conf').eq(index).val());
                }
            });
            $('#feed-setting-form').ajaxSubmit({
                url:'/ajax_home',
                data:{op:'feed-setting',confme:confme,conf:conf},
                type:'POST',
                dataType:'json',
                success:function(data){
                    showDialogInfo(data.msg);
                    setTimeout(function(){ closedialog();},2000);
                }

            });
        }
    });
    //消息设置
    $("body").delegate("input[ctype=msgset]","click",function(){
        var id = $(this).val();
        var cid = $(this).attr('cid');
        var opt = '';
        if ($(this).is(':checked') == true){
            opt = 'add';
        }else{
            opt = 'miss';
        }
        if(!id || !cid || !opt){ return false;}
        $.post('/ajax_home',{op:'msg-setting',id:id,cid:cid,opt:opt},function(data){
        	if (data.res == 0) {
	            showDialogInfo(data.msg);
	            setTimeout(function(){ closedialog();},2000);
        	}
        },'json');
    });
    //取消全部消息
    $("body").delegate("#cancelmsg","click",function(){
        if (confirm('确定取消吗?'))
        {
            $.post('/ajax_home',{op:'cancel-msg-setting'},function(data){
                if(data.res == 1){
                    //$("span[ctype=msgspan]").removeClass('on');
                    $("input[ctype=msgset]").attr("checked",false);
                }else{
                    showDialogInfo(data.msg);
                }

            },'json');
        }
        return false;
    });
    //设置隐私
    $('#setprivacy').validate({
        onkeyup: false,
        rules : {
            viewrecord :{ required:true},
            commentrecord :{ required:true},
            seorecord :{ required:true},
            follow :{ required:true},
            notice :{ required:true}
        },
        messages : {
            viewrecord :{ required:"请选择"},
            commentrecord :{ required:"请选择"},
            seorecord :{ required:"请选择"},
            follow :{ required:"请选择"},
            notice :{ required:"请选择"}
        },
        submitHandler: function(form) {
            $.post('/ajax_home',$(form).serialize()+'&op=privacy-setting',function(data){
                showDialogInfo(data.msg);
                setTimeout(function(){ closedialog();},2000);
            },'json');
        }
    });
    //添加邮箱
    $('#emailfrom').validate({
		errorPlacement:function(error,element){
            error.appendTo(element.parent().parent());
        },
        onkeyup: false,
        rules : {
            newemail : { required:true,email:true,remote:{ url :'/ajax_check?op=changeemail',data:{ email : function(){ return $('#newemail').val();}}}}
        },
        messages : {
            newemail : { required:'新邮箱不能为空',email:'邮箱格式不正确',remote : '该邮箱已被人使用'}
        },
        submitHandler: function(form) {
            $.post('/ajax_home',{op:'addemail',email:$("#newemail").val()},function(data){
                if(data.res){
                    if (data.res == 1)
                    {
                        $("#mailul").append('<li id="email_'+data.info.id+'" class="list-group-item">'+data.info.email+'<span class="ml10 mr10 red">未验证</span><a class="test emailverify" href="javascript:void(0);" cid="'+data.info.id+'">[立即验证]</a><span class="glyphicon glyphicon-remove ml10 mt5 cursor closemail" cid="'+data.info.id+'">&nbsp;</span></li>');
                    }
                    $("#newemail").val('');
                }else{
                    showDialogInfo(data.msg);
                }

            },'json');
        }
    });
    
    $("body").delegate(".closemail","click",function(){
        if(confirm('确认删除吗?'))
        {
            var id = $(this).attr('cid');
            $.post('/ajax_home',{op:'delemail',id:id},function(data){
                if(data.res){
                    $("#email_"+id).remove();
                }else{
                    showDialogInfo(data.msg);
                }
            },'json');
        }
    });
    $("body").delegate(".delemail","click",function(){
        var id =$('input[name="email"]:checked').val();
        if (!id){return ;}
        $.post('/ajax_home',{op:'delemail',id:id},function(data){
            if(data.res){
                $("#email_"+id).remove();
                if ($("#login_email_div").find("div[id^=email_]").length<=0){
                    $("#login_email_div").remove();
                }
            }else{
                //alert(data.msg);
                //showDialogInfo(data.msg);
                $('#email-msg').addClass('bg-danger').removeClass('bg-success').html(data.msg).show().delay(1000).fadeOut('slow');
            }
        },'json');
    });
    //设置主邮箱
    $('#setloginemail').validate({
        onkeyup: false,
        rules : {
            email : { required:true}
        },
        messages : {
            email : { required:'请选择主邮箱'}
        },
        submitHandler: function(form) {
            var id =$('input[name="email"]:checked').val();
            if (!id){return ;}
            $.post('/ajax_home',{op:'setlogemail',id:id},function(data){
                if(data.res){
                	$('#email-msg').addClass('bg-success').removeClass('bg-danger').html(data.msg).show().delay(1000).fadeOut('slow');
                    $("input[name=email]").prev('span').remove();
                    $("#email_"+id).children('input').before('<span class="current">[当前主邮箱]</span>');
                }else{
                    showDialogInfo(data.msg);
                }
            },'json');
        }
    });
    $("body").delegate(".emailverify","click",function(){
        var id = $(this).attr('cid');
        if (!id) { return false; }
        $(this).text('[重发验证邮件]');
        $.post('/ajax_home', { op: 'mememail',id: id},function(data){
            showDialogInfo(data.msg);
            setTimeout(function(){ closedialog();},2000);
        },'json');
    });
    $(".nav_index_bar").click(function(){
        $(".nav_index_bar").parent().removeClass('focus');
        $(this).parent().addClass('focus');
        $("div[id^=top_nav_index_]").hide();
        $("#top_nav_index_"+$(this).attr('cid')).show();
        if ($(this).attr('cid') == 'invite'){
            if(!$("#copy-button").parent().find('.zclip').length){
                $("#copy-button").zclip({
                    path: _domain+"/media/javascript/zclip/ZeroClipboard.swf",
                    copy: $("#inviteurldis").text(),
                    afterCopy:function(){
                        showDialogInfo("链接复制成功！");
                    }
                });
            }
        }
        return false;
    });
    $(".rejump").click(function(){
        var cid = $(this).attr('cid');
        if (cid == 'workForm'){
            $("#workForm").hide();
            $("#eduForm").show();
        }else if (cid == 'eduForm'){
            $("#eduForm").hide();
            $("#workForm").show();
        }
    });
    //标签
    $("body").delegate(".bar_add_tag li","click",function(){
        var obj = $(this);
        var tid = obj.attr('data-id');
        var name = obj.attr('data-name');
        if ($(this).hasClass('bg-dad')){
            $.post('/ajax_tag', { op:'del', tid:tid },function(data){
                if (data.res) {
                    obj.removeClass('bg-dad');
                    if ($(".bar_add_tag li[class=bg-dad]").length == 0){
                        $("#tag_yes").hide();
                    }
                }
                else { showDialogInfo(data.msg); setTimeout(function(){ closedialog();},2000);}
            },'json');
        }else{
            $.post('/ajax_tag', { op:'sysadd', tid:tid },function(data){
                if (data.res) {
                    obj.addClass('bg-dad');
                    $("#tag_yes").show();
                }
                else { showDialogInfo(data.msg); }
            },'json');
        }
    });
    //形象标签
    $("body").delegate(".addtag","click",function(){
        var name = $('#tag').val();
        if ($.trim(name) == '') { $('#tag').focus(); return false; }
        $.post('/ajax_tag', { op:'selfadd', name:name },function(data){
            if (data.res) {
                var html = '<li class="bg-dad" data-id="'+data.msg+'" data-name="'+name+'"><span></span><a href="javascript:;">'+name+'</a></li>';
                $('.bar_add_tag').append(html);
                $('#tag').val('').focus();
            }
            else { showDialogInfo(data.msg); setTimeout(function(){ closedialog();},2000);}
        },'json');
    });
    $('.bar_refresh').on('click',function(){
        $.post('/ajax_tag', { op:'refresh',t:'bar'},function(data){
            var html = '';
            $.each(data.msg, function(i, obj){
                html += '<li data-name="'+obj.name+'" data-id="'+obj.id+'"><span></span><a href="javascript:;">'+obj.name+'</a></li>'
            });
            $.each(data.self, function(i, obj){
                html += '<li class="bg-dad" data-name="'+obj.name+'" data-id="'+obj.id+'"><span></span><a href="javascript:;">'+obj.name+'</a></li>'
            });
            $(".bar_add_tag").html(html);

        },'json');
    });
    //微博好友
    $(".apiuser").on('click',function(){
        var type = $(this).attr('cid');
        $(".apiuser").removeClass('on');
        $(this).addClass('on');
        var name = '';
        if (type == 1){
            $("#sina_api_user").hide();
            $("#qq_api_user").show();
            name = 'qq_';
            if ($("#qq_api_user").children("ul").hasClass('listyes')){
                return false;
            }
        }else if(type==2){
            $("#sina_api_user").show();
            $("#qq_api_user").hide();
            name = 'sina_';
            if ($("#sina_api_user").children("ul").hasClass('listyes')){
                return false;
            }
        }
        $("#"+name+"api_user div:eq(0)").show();
        $.post('/ajax_getapiuser', { type:type},function(data){
            $.each(data.msg, function(i, obj){
                $("#"+name+i).children("a").attr({'href':obj.url,'target':'_blank','title':obj.username+' '+obj.sjname+' '+obj.scname});
                $("#"+name+i).find("img").attr('src',obj.logourl);
                $("#"+name+i).parent().removeClass().addClass('listyes');
                $("#"+name+i).show();
            });
            $("#"+name+"api_user div:eq(0)").hide();
            $("#"+name+"api_user div:eq(1)").show();
        },'json');
    });

    //账号绑定管理
    $('a[ctype=apibind]').on('click',function(){
        var obj = $(this);
        var dtype = obj.attr('data');
        var op = obj.attr('data-op');
        var id = $(this).attr('data-id');
        if(!op){ showDialogInfo('参数错误');}
        $.post('/ajax_bind',{dtype:dtype,op:op,id:id},function(data){
            if(data.res == 1 && op == 'unbind'){
                obj.removeClass('cr-048').addClass('btn').attr('data-op','bind').text('立即绑定');
                obj.parent().find('.nick').remove();
            }
            if(data.res == 1 && (op == 'bind' ||  op == 'changebind' )){
                window.location.href = data.msg;
            }
            if(data.res==0){
                showDialogInfo(data.msg);
            }
        },'json');
    });
    //发布信息选择第三方
    $(".selapi").click(function(){
        $("#apitype").val($(this).attr('cid'));
        $(".selapi").children("i").removeClass('on');
        $(this).children("i").addClass('on');
        return false;
    });
    //测评图片
    $('.je-img img').toggle(function(){
        $(this).attr('width','auto');
    },function(){
        $(this).attr('width','143px');
    });
    //message
	$('.message_add').click(function(){
		var touid = $('#touid').val();
		if (touid == '') { $('#tousername').focus(); return false; }
		var content = $.trim($('#messagetext').val());
		if (content == '' || content.length >1000) { $('#messagetext').focus(); return false; }
		$.post("/ajax_message", { content:content, touid:touid, 'do':'add'}, function(data){
            if (data.res == 1) {
            	$('#messagetext').val('');
            	window.location.reload();
            }else{
                showDialogInfo(data.msg);
            }
		},'json');
	});
	$("#tousername").on('keydown.autocomplete', function(){
        $(this).autocomplete({
            source: "/ajax_search_username",
            minLength: 1,
            autoFocus: false,
            select: function( event, ui ) {
            	$('#touid').val(ui.item.id);
            	$('#tousername').attr('readonly',true).val(' ');
            	$('#tousername').after('<div class="popesbox"><a href="javascript:;" class="cr-048">'+ui.item.label+'</a><span class="delete"></span></div>');
            	return false;
            }
        });
    });
	$('.popesbox').on('hover',function(event){
		if (event.type == 'mouseenter') {
			 $(this).addClass("bge1f");
		} else {
			$(this).removeClass("bge1f");
		}
	});
	$('.popesbox .delete').on('click',function(){
		$(this).parents('.popesbox').remove();
		$('#touid').val('');
		$('#tousername').attr('readonly',false)
	});
	
	$('.msgdelete').on('click',function(){
		var obj = $(this);
		var mid = obj.attr('data-id');
		$.post("/ajax_message", { mid:mid, 'do':'delete'}, function(data){
            if (data.res == 1) {
            	obj.parents('li').remove();            	
            }else{
                showDialogInfo(data.msg);
            }
		},'json');
	});
	
	$('.msgdeleteall').on('click', function(){
		var mid = '';
		$('.con-review li').each(function(i, o){			
			if ($(o).attr('data-id')) {
				mid += $(o).attr('data-id') + ',';
			}
		});
		if (mid == '') { return false; }
		$.post("/ajax_message", { mid:mid, 'do':'delete'}, function(data){
            if (data.res == 1) {
            	window.location.reload();           	
            }else{
                showDialogInfo(data.msg);
            }
		},'json');
	});
	$('.msgreadall').on('click', function(){
		var mid = '';		
		var ck = $('.msgchk:checked');
		$.each(ck, function(i, n){
			mid += n['value']+',';
		});
		if (mid == '') { return false; }
		$.post("/ajax_message", { mid:mid, 'do':'read'}, function(data){
            if (data.res == 1) {
            	window.location.reload();           	
            }else{
                showDialogInfo(data.msg);
            }
		},'json');
	});
	
	$('.msgchkall').on('click', function(){
		if ($(this).is(':checked')) {			
			$('input.msgchk').prop('checked', true);
		} else {
			$('.msgchk').prop('checked', false);
		}
	});    
	
/*
	$('.people-iam-pay-atten dd').click(function(){
			var obj = $(this);
			$('.people-iam-pay-atten dd').removeClass('on');
			obj.addClass('on');
			$('.perdefbox').hide();
			$('.realbox').show();
			$('#fnote').val('');
	
			$.post("/ajax_followinfo", { type: obj.attr('data-type'), uid: obj.attr('data-uid'), cid: obj.attr('data-cid'), pid: obj.attr('data-pid')}, function(data){
	
				if (data.res == 0) { showDialogInfo(data.msg); return false; }			
				$('.people-more-info .realboxupdae').html(data.msg);
				$('.groupspan').text(obj.attr('data-group'));
				$('.editUserGroup').attr({ 'data': obj.attr('data-uid'), 'data-text': obj.attr('data-realname'), 'gid': obj.attr('data-gid') });
				//$('.delfollow').attr({ 'data': obj.attr('data-uid'), 'data-text': obj.attr('data-realname') });			
				var url = obj.attr('data-type') == 0 ? '/person/'+obj.attr('data-pid') : '/company/'+obj.attr('data-cid');
				var urlmsg = '/message/terminal?contractuid='+obj.attr('data-uid');
	
				$('.acase').attr('href', url);
				$('.amessage').attr('href', urlmsg);
				var status = obj.attr('data-status');
				if (status == 1) {
					$('.pxfollow').show();
					$('.addfans').hide();
				} else {
					$('.addfans').show().attr({ 'data': obj.attr('data-uid') });
					$('.pxfollow').hide();
				}
				var note = obj.attr('data-note');
				if (note == '') {
					$('.addpnote').show();
					$('.editpnote,.textpnote').hide();
					$('#fnote').attr('data-gmid',obj.attr('data-gmid') );				
				} else {
					$('.editpnote').show().find('span').text(note);
					$('.addpnote,.textpnote').hide();
					$('#fnote').val(note).attr('data-gmid',obj.attr('data-gmid') );
				}
			   
			},'json');		
		});
	
		$('.editnote,.addnote').on('click', function(){
			$('.editpnote').hide();
			$('.textpnote').show();
		});
	
		$('.textpnote a').on('click', function(){
			var note = $.trim($('#fnote').val());
			if (note == '') { $('#fnote').focus(); return false; }
			if (note.length > 30) { $('#fnote').focus(); showDialogInfo('备注最多30字'); return false; }
	
			$.post("/ajax_followinfonote", { note:note,gmid:$('#fnote').attr('data-gmid') }, function(data){
				if (data.res == 0) { showDialogInfo(data.msg); return false; }
				$('.textpnote,.addpnote').hide();
				$('.editpnote').show().find('span').text(note);
				$('.cur_main_l li.on').attr('data-note',note);
			},'json');	
		});
		$('#ascdiv').mouseleave(function(){
			$(this).hide();
		});
		$('.ascbtn').click(function(){
			var html = '';
			var asc = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
			var style = '';
			for(var i=0; i<asc.length; i++) {
				style = ($.inArray(asc[i], ascselect) >=0) ? "background-color:#bde8ff" : '';
				html += '<li style="'+style+'"><a href="/relation?type=follow&asc='+asc[i]+'">'+asc[i]+'</a></li>';
			}
			$('#ascdiv').show().find('ul').html(html);
		});
		$("#ascdiv li a").on('mouseenter', function() {  
			$(this).addClass('on');
		}).on('mouseleave', function() {  
			$(this).removeClass('on');
		});
		*/
	$('.people-iam-pay-atten dd').click(function(){
		var obj = $(this);
		$('.people-iam-pay-atten dd').removeClass('on');
		obj.addClass('on');
		$('.perdefbox').hide();
		$('.realbox').show();
		$('#fnote').val('');

		$.post("/ajax_friendinfo", {  type: obj.attr('data-type'), uid: obj.attr('data-fuid') }, function(data){
			if (data.res == 0) { showDialogInfo(data.msg); return false; }			
			$('.people-more-info .realboxupdae').html(data.msg);
			$('.groupspan').text(obj.attr('data-group'));
			$('.editUserGroup').attr({ 'data': obj.attr('data-fuid'), 'data-text': obj.attr('data-fusername'), 'gid': obj.attr('data-gid') });
			//$('.delfollow').attr({ 'data': obj.attr('data-uid'), 'data-text': obj.attr('data-realname') });			
			var url = obj.attr('data-url');
			var urlmsg = '/message/terminal?contractuid='+obj.attr('data-fuid');

			$('.acase').attr('href', url);
			$('.amessage').attr('href', urlmsg);		
			var note = obj.attr('data-note');
			if (note == '') {
				$('.addpnote').show();
				$('.editpnote,.textpnote').hide();
				$('#fnote').attr('data-fid',obj.attr('data-fid') );				
			} else {
				$('.editpnote').show().find('span').text(note);
				$('.addpnote,.textpnote').hide();
				$('#fnote').val(note).attr('data-fid',obj.attr('data-fid') );
			}		   
		},'json');		
	});
	$('.editnote,.addnote').on('click', function(){
		$('.editpnote').hide();
		$('.textpnote').show();
	});

	$('.textpnote a').on('click', function(){
		var note = $.trim($('#fnote').val());
		if (note == '') { $('#fnote').focus(); return false; }
		if (note.length > 30) { $('#fnote').focus(); showDialogInfo('备注最多30字'); return false; }

		$.post("/ajax_friendinfonote", { note:note,fid:$('#fnote').attr('data-fid') }, function(data){
			if (data.res == 0) { showDialogInfo(data.msg); return false; }
			$('.textpnote,.addpnote').hide();
			$('.editpnote').show().find('span').text(note);
			$('.cur_main_l li.on').attr('data-note',note);
		},'json');	
	});
	$('#ascdiv').mouseleave(function(){
		$(this).hide();
	});
	$('.ascbtn').click(function(){
		var html = '';
		var asc = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
		var style = '';
		for(var i=0; i<asc.length; i++) {
			style = ($.inArray(asc[i], ascselect) >=0) ? "background-color:#bde8ff" : '';
			html += '<li style="'+style+'"><a href="/relation?asc='+asc[i]+'">'+asc[i]+'</a></li>';
		}
		$('#ascdiv').show().find('ul').html(html);
	});
	$("#ascdiv li a").on('mouseenter', function() {  
		$(this).addClass('on');
	}).on('mouseleave', function() {  
		$(this).removeClass('on');
	});
	
	$('.addFriendRequestBatch').on('click', function(){
		var uidstr = '';
		$('input[name="uids[]"]:checked').each(function(i, n){
			uidstr += n['value']+',';
		});
		if (uidstr == '') { return false; }
		$.post('/ajax_friend', { fuid: uidstr, op: 'request' },function(data){
			showDialogInfo(data.msg);
		},'json');
	});
	
	
	
		//人脉邀请
		$('.pminvitebtn').on('click', function(){
			var obj = $(this);		
			var pmid = obj.attr('data-id');
			var type = obj.attr('data-type');
			var fuid = obj.attr('data-uid');
			var fid = obj.attr('data-fid');
			if (pmid == '') { return; }
			$.post('/ajax_result_pm', { pmid: pmid, type: type,op:type, fuid: fuid , fid: fid },function(data){
				setTimeout(function(){ 
					showDialogInfo(data.msg);
					if (data.res) {	obj.parents('li').remove(); }
				},500);
				/*
				if (data.res) {				
					obj.parents('li').remove()
				} else {
					showDialogInfo(data.msg);
				}*/			
			},'json');
		});
		$('.del-info').on('click', function(){
			var obj = $(this);		
			var pmid = obj.attr('data-id');
			if (pmid == '') { return; }
			$.post('/ajax_del_pm', { pmid: pmid },function(data){
				if (data.res) {				
					obj.parents('li').remove()
				} else {
					showDialogInfo(data.msg);
				}				
			},'json');
		});
		$('.allreturn').click(function(){		
			var ids = '';
			$('input[name="pmid[]"]').each(function(i){
				  ids += $(this).val()+',';
			 });		 
			if (ids=='') { return; }
			$.post('/ajax_result_pm', { pmid: ids, type:'return' },function(data){
				if (data.res) {				
					window.location.reload();
				} else {
					showDialogInfo(data.msg);
				}				
			},'json');
		});
		//通知评论
		 $('.eva-item h4 span').on('click', function(e){
			var obj = $(this);
			var objul = obj.parent().next('ul');
			if (objul.is(':hidden')) {
				objul.show();
				obj.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down').attr('title','收起');			
			} else {
				objul.hide();
				obj.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up').attr('title','展开');
			}		
		});
		$('.pagemorepm').click(function(){
			var obj = $(this);
			var page = obj.attr('data-page');
			
			var href = $('.pagination .current').next('a').attr('href')
			if (typeof(href) == "undefined") { return ;}
			window.location.href = href;
		});
		$('.pmalldel').click(function(){		
			var ids = '';
			$('input[name="pmid[]"]').each(function(i){
				  ids += $(this).val()+',';
			 });
			if (ids=='') { return; }
			$.post('/ajax_del_pm', { pmid: ids },function(data){
				if (data.res) {				
					window.location.reload();
				} else {
					showDialogInfo(data.msg);
				}				
			},'json');
		});	
		$('.pmdatesearch').click(function(){
			window.location.href = window.location.pathname+"?date="+$('#sdate').val();
		});
        $("body").delegate(".bindphone","click",function(){
            $(".showphone").show();
            return false;
        });

    var sendcodesub = true;
    $("body").delegate("#bindphoneform #sendcode","click",function(){
        if (!$("#phone").val()){
            $("#bindphoneform").children().removeClass('has-success').addClass('has-error');
            $("span[for=phone]").html('请输入手机号').show();
            return false;
        }
        var reg=/^1\d{10}$/;
        if (!reg.test($("#phone").val())) {
            $("#bindphoneform").children().removeClass('has-success').addClass('has-error');
            $("span[for=phone]").html('请输入正确的手机号').show();
            return false;
        }
        if (!$("#checkcode").val()){
            $("#bindphoneform").children().removeClass('has-success').addClass('has-error');
            $("span[for=checkcode]").html('请输入验证码').show();
            return false;
        }else{
            $("span[for=checkcode]").html('').hide();
        }
        var phonehas = false;
        $.ajax({
            type : "get",
            url : "/ajax_check?op=checkemailphone",
            data : "emailphone=" + $("#phone").val(),
            async : false,
            success : function(data){
                if (data=='false') {
                    $("#bindphoneform").children().removeClass('has-success').addClass('has-error');
                    $("span[for=phone]").html('手机已经存在').show();
                    phonehas = true;
                }
            }
        });
        if (phonehas){
           return false;
        }
        $("#bindphoneform").children().removeClass('has-error');
        $("span[for=phone]").remove();
        $("span[for=phonecode]").html('').hide();
        if (sendcodesub == true){
            $('#sendcode').text('发送中...').attr('disabled','true');
            sendcodesub == false;
            $.post("/ajax_getPhoneCode", { phone: $("#phone").val(), 'checkcode':$('#checkcode').val()},
                function(data){
                    if (data.res == 1) {
                        $("span[for=phonecode]").html('').hide();
                        $('#sendcode').text('60秒后重新发送');
                        $('#sendcodetime').val(60);
                        setTimeout('show_time()',1000);
                    }else{
                        $("#bindphoneform").children().removeClass('has-success').addClass('has-error');
                        $("span[for=phonecode]").html(data.msg).show();
                        sendcodesub == true;
                        $('#sendcode').text('发送验证码').removeAttr('disabled');
                    }
                },'json');
        }
        return false;
    });
    var bindphoneformsub = true;
    //绑定手机表单验证
    $('#bindphoneform').validate({
        ignore:'',
        rules : {
            phone : { required : true,isMobile: true, remote : { url :'/ajax_check?op=checkemailphone',data:{ emailphone : function(){ return $('#phone').val();}}}},
            phonecode : { required: true}
        },
        messages : {
            phone : { required : '请输入手机号',isMobile : '请输入正确的手机格式',remote:'手机已经存在'},
            phonecode : { required: '请输入验证码'}
        },
        submitHandler: function(form) {
            if(bindphoneformsub==true)
            {
                bindphoneformsub==false;
                $(form).ajaxSubmit({
                    dataType:'json',
                    url:'/ajax_bind_phone',
                    beforeSubmit:function(){
                        $('#bindphoneform').find('button[type="submit"]').text('提交中...').attr('disabled','true');
                    },
                    success:function(data){
                        if (data.code==1) {
                            setTimeout(function(){ window.location.href='/user/email'; },500);
                        } else {
                            bindphoneformsub==true;
                            $('#bindphoneform').find('button[type="submit"]').text('完 成').removeAttr('disabled');
                            $("#bindphoneform").children().removeClass('has-success').addClass('has-error');
                            $('span[for=phonecode]').text(data.msg).show();
                            return false;
                        }
                    }
                });
            }
        }
    });
    //忘记密码
    $('#newforgotform').validate({
        rules : {        	
            emailphone : { required : true, isEmailPhone: true, remote : { url :'/ajax_check?op=checkemailphone&t=forgot',data:{ emailphone : function(){ return $('#emailphone').val();}}}},
            checkcode : { required: true, rangelength:[4,4] }
        },
        messages:{
            emailphone:{ required:"邮箱或手机号不能为空",isEmailPhone : "邮箱或手机号格式不正确",remote : "该邮箱或手机号没有注册，请重新输入"},
        	checkcode : { required: '请输入图片验证码', rangelength:'输入四位图片验证码' }
        },
        submitHandler: function(form) {
            var reg=/^1\d{10}$/;
            if (!reg.test($("#emailphone").val())) {
                $("#forgot_type").val('email');
            }else{
                $("#forgot_type").val('phone');
            }
            if ($("#forgot_type").val() == 'email'){
                form.submit();
            }else if($("#forgot_type").val() == 'phone'){
                $("#phone").val($("#emailphone").val());
                var nextbtn = true;
                $.ajax({
                    url:'/ajax_getPhoneCode',
                    type:'post',
                    data:{'phone':$("#emailphone").val(), 'checkcode':$('#checkcode').val()},
                    async : false,
                    dataType:'json',
                    success:function(data){
                        if (data.res == 1 || data.vaid == 1) {
                            $('#sendcode').text('60秒后重新发送');
                            $('#sendcodetime').val(60);
                            setTimeout('show_time()',1000);
                        }else{
                            nextbtn = false;
                            $("#newforgotform").find("div").removeClass('has-success').addClass('has-error');
                            $("span[for=sendphonecode]").html(data.msg).show();
                        }
                    }
                });
                if (!nextbtn){
                    return false;
                }
                $("#forgotfirst").hide();
                $("#sendcodediv").show();
                $("#phonedis").html($("#emailphone").val());
            }

        }
    });
    //找回密码重新发送
    var forgotsendcodesub = true;
    $("body").delegate("#sendcodediv #sendcode","click",function(){
        if (!$("#emailphone").val()){
            if ($("#phonecode").parent().find("span[for=phonecode]").length>0){
                $("#phonecode").parent().find("span[for=phonecode]").html('手机号错误').show();
            }else{
                $("#phonecode").after('<span for="phonecode" class="text-danger">手机号错误</span>');
            }
        }
        var phonehas = false;
        $.ajax({
            type : "get",
            url : "/ajax_check?op=checkemailphone&t=forgot",
            data : "emailphone=" + $("#emailphone").val(),
            async : false,
            success : function(data){
                if (data=='false') {
                    if ($("#phone").parent().find("span[for=phonecode]").length>0){
                        $("#phone").parent().find("span[for=phonecode]").html('手机不存在').show();
                    }else{
                        $("#phone").after('<span for="phonecode" class="text-danger">手机不存在</span>');
                    }
                    phonehas = true;
                }
            }
        });
        if (phonehas){
            return false;
        }
        if (sendcodesub == true){
            $('#sendcode').text('发送中...').attr('disabled','true');
            sendcodesub == false;
            $.post("/ajax_getPhoneCode", { phone: $("#emailphone").val()},
                function(data){
                    if (data.res == 1) {
                        $("span[for=phonecode]").html('').hide();
                        $('#sendcode').text('60秒后重新发送');
                        $('#sendcodetime').val(60);
                        setTimeout('show_time()',1000);
                    }else{
                        $("span[for=phonecode]").html(data.msg).show();
                        sendcodesub == true;
                        $('#sendcode').text('发送验证码').removeAttr('disabled');
                    }
                },'json');
        }
        return false;
    });
    //找回密码验证码验证
    var forgotcodesub = true;
    $('#forgotcodeform').validate({
        ignore:'',
        rules : {
            phonecode : { required: true}
        },
        messages : {
            phonecode : { required: '请输入验证码'}
        },
        submitHandler: function(form) {
            if(forgotcodesub==true)
            {
                forgotcodesub==false;
                $(form).ajaxSubmit({
                    dataType:'json',
                    url:'/ajax_checkcode_phone',
                    beforeSubmit:function(){
                        $('#forgotcodeform').find('button[type="submit"]').text('提交中...').attr('disabled','true');
                    },
                    success:function(data){
                        if (data.code==1) {
                            setTimeout(function(){ window.location.href='/user/resetpassword?sid='+data.sid+'&time='+data.time; },500);
                        } else {
                            $("span[for=phonecode]").html(data.msg).show();
                            forgotcodesub = true;
                            $('#forgotcodeform').find('button[type="submit"]').text('下一步').removeAttr('disabled');
                        }
                    }
                });
            }
        }
    });
    $('#relateForm').validate({
        rules : {
            password : { required : true,rangelength : [6,15]},
            emailphone : { required : true, isEmailPhone: true, remote : { url :'/ajax_check?op=checkemailphone&t=relate',async:false,data:{ emailphone : function(){ return $('#emailphone').val();}}}},
            phonecode : { required: true, rangelength:[4,4] },
            emailcode : { required: true, rangelength:[6,6] }
        },
        messages : {
            password : { required : '请填写密码',rangelength : '{0}-{1}个字符，请使用字母、数字或符号'},
            emailphone : { required : '请输入邮箱或手机号',isEmailPhone : '请填写正确的邮箱或手机号',remote:'邮箱或手机号不存在或已被绑定' },
            phonecode : { required: '请填写动态密码', rangelength:'动态密码{1}位'},
            emailcode : { required: '请填写动态密码', rangelength:'动态密码{1}位'}
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                dataType:'json',
                url:'/ajax_relate',
                beforeSubmit:function(){
                },
                success:function(data){
                    if (data.code==1) {
                        $(".js_relate_succ").show();
                        //var accout = data.uinfo.email ? data.uinfo.email :  data.uinfo.mobile;
                        var accout = (data.uinfo.email ? data.uinfo.email : '')+(data.uinfo.email && data.uinfo.mobile ? ',' : '') + (data.uinfo.mobile ? ' '+data.uinfo.mobile : '');
                        $("#relate_info_div").html('<div class="media-left"> <a href="'+data.uinfo.url+'" target="_blank"><img class="media-object item-logo img-circle"  src="'+data.uinfo.logourl+'"></a> </div> ' +
                        '<div class="media-body"> <h4 class="media-heading"><span class="item-name">'+data.uinfo.username+'</span><span class="otem-mailbox">（'+accout+'）</span></h4> <p class="item-position">'+data.uinfo.sjname+'</p> ' +
                        '<p class="item-company"><span class="item-comp">'+data.uinfo.scname+'</span><span class="item-time">'+data.uinfo.worktime+'</span></p> </div>');
                        $("#relate_conf_div").show();
                        $("#relate_form_div").hide();
                        $("#reluid").val(data.uid);
                        $("#codeid").val(data.id);
                        $("#codetype").val(data.type);
                        $('.confirm-msg').html('验证通过，HR的个人信息如下，点击确认关联：');
                    } else {
                        $("span[for=code]").html(data.msg).show();
                    }
                }
            });
        }
    });
    var relatecodesub = true;
    $("body").delegate("#relateForm .sendcode","click",function(){
        var relatephonehas = false;
        $.ajax({
            type : "get",
            url : "/ajax_check?op=checkemailphone&t=relate",
            data : "emailphone=" + $("#emailphone").val(),
            async : false,
            success : function(data){
                if (data=='false') {
                    $("#relateForm").children().removeClass('has-success').addClass('has-error');
                    $("span[for=emailphone]").html('邮箱或手机号不存在').show();
                    relatephonehas = true;
                }
            }
        });
        if (relatephonehas){
            return false;
        }
        $("#relateForm").children().removeClass('has-error');
        $("span[for=emailphone]").remove();
        if (relatecodesub == true){
            $('.sendcode').text('发送中...').attr('disabled','true');
            relatecodesub == false;
            var val = $("#emailphone").val();
            var reg = /^1\d{10}$/;
            if (reg.test(val)) {
                $.post("/ajax_getPhoneCode", { phone: val,t:'relate'},
                    function(data){
                        if (data.res == 1) {
                            $("span[for=code]").html('').hide();
                            $('.sendcode').text('60秒后重新发送');
                            $('#sendcodetime').val(60);
                            setTimeout('show_time()',1000);
                        }else{
                            $("#relateForm").children().removeClass('has-success').addClass('has-error');
                            $("span[for=code]").html(data.msg).show();
                            relatecodesub == true;
                            $('.sendcode').text('发送验证码').removeAttr('disabled');
                        }
                    },'json');
            } else {
                $.post("/ajax_getEmailCode", { email: val,t:'relate'},
                    function(data){
                        if (data.res == 1) {
                            $("span[for=code]").html('').hide();
                            $('.sendcode').text('60秒后重新发送');
                            $('#sendcodetime').val(60);
                            setTimeout('show_time()',1000);
                        }else{
                            $("#relateForm").children().removeClass('has-success').addClass('has-error');
                            $("span[for=code]").html(data.msg).show();
                            relatecodesub == true;
                            $('.sendcode').text('发送验证码').removeAttr('disabled');
                        }
                    },'json');
            }
        }
        return false;
    });
    $("body").delegate(".js_relate_cancel","click",function(){
        $("#relate_conf_div").hide();
        $("#relate_form_div").show();
        $('.js_relate_succ').hide();
        $('.confirm-msg').html('为了确保企业与HR真实，避免信息泄露，需要验证账号密码：');
        return false;
    });
    $('#relateSubForm').validate({
        rules:{},messages:{},
        submitHandler:function(form){
            $('#relateSubForm').ajaxSubmit({
                url:'/ajax_relate_op',
                data:{op:'conf'},
                type:'POST',
                dataType:'json',
                beforeSubmit:function(){
                    $('#relateSubForm').find('input[type="submit"]').val('提交中...').attr('disabled', true);
                },
                success:function(data){
                    $('#relateSubForm').find('input[type="submit"]').val('确认关联').removeAttr('disabled');
                    if (data.code == 1){
                        window.location.reload();
                    }else{
                        showDialogInfo(data.msg);
                        setTimeout(function(){ closedialog();},2000);
                    }
                }
            });
        }
    });
    $("body").delegate(".js_relate_del","click",function(){
        if (!$.cookie('_widoli')){
            showDialog(1, 'login');
            return false;
        }
        $.post("/ajax_relate_op", { op: 'del'},
            function(data){
                if (data.code == 1) {
                    window.location.reload();
                }else{
                    showDialogInfo(data.msg);
                    setTimeout(function(){closedialog();},2000);
                }

            },'json');
        return false;
    });
});
