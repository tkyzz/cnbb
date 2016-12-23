$(".js_deliver_show").click(function() {
    var post_id = $(this).attr("data-id");
    var org_id = $(this).attr("data-orgid");
    var is_resume = $("#is_resume").val();
    var area = $(this).attr("data-area");
    var type = $(this).attr("data-worktype");
    var worktime = $(this).attr("data-worktime");
    var sedate = $(this).attr("data-sedate");
    $(".js_setime_zone").show();
    //alert(worktime);
    $(".js_area").text(area);
    $(".js_worktype").text(type);
    $(".js_worktime").text(worktime);
    $(".js_deliver_check").attr("data-id", post_id);
    $(".js_deliver_check").attr("data-orgid", org_id);
    if ($(this).attr("data-sdate") == 0) {
        $(".js_setime_zone").hide();
    } else {
        $(".js_setime").text(sedate);
    }
    if (is_resume == 0) {
        $(".noResumePopup").show();
        return false;
    }
    $("#choosePopup").show();
});

$(".js_deliver_check").click(function() {
    $("#choosePopup").hide();
    $("#surePopup").show();
});

$(".js_fav_deliver").click(function() {
    var org_id = $(".js_deliver_check").attr("data-orgid");
    var post_id = $(".js_deliver_check").attr("data-id");
    var resume_id = $('[name="choose"]:checked').val();
    var resume_baseid = $('[name="choose"]:checked').attr("data-baseid");
    var is_deliver = $('[name="choose"]:checked').attr("data-id");
    if (is_deliver == 1) {
        $.post("/ajax/deliver", {
            resume_id:resume_id,
            post_id:post_id
        }, function(data) {
            if (data.status == 1) {
                window.location.href = "/post/" + org_id + "/deliver.html";
                layer.msg(data.msg, {icon: 1});
            } else {
                layer.msg(data.msg, {icon: 5});
                $("#choosePopup").hide();
                $("#noProfilePopup").hide();
                $("#surePopup").hide();
            }
        }, "json");
    } else {
        $(".js_wsjl_tc").attr("href", "/resume/detail/" + resume_baseid + ".html");
        $("#choosePopup").hide();
        $("#noProfilePopup").show();
    }
});

$(".js_deliver").click(function() {
    $.post("/ajax/deliver", {
        resume_id:resume_id,
        post_id:post_id
    }, function(data) {
        if (data.status == 1) {
            layer.msg(data.msg, {icon: 1});
        } else {
            layer.msg(data.msg, {icon: 5});
        }
    }, "json");
});

//我的收藏页面取消收藏
$("body").delegate(".js_qxsc", "click", function() {
    var post_id = $(this).attr("data-id");
    if (post_id.length == 0) {
        return false;
    }
    $.post("/ajax/fav", {
        post_id:post_id,
        type:"delete"
    }, function(data) {
        if (data.status == 1) {
            $(".js_qxsc[data-id=" + post_id + "]").text("已取消");
            $(".js_qxsc[data-id=" + post_id + "]").addClass("js_cxsc");
            $(".js_qxsc[data-id=" + post_id + "]").removeClass("js_qxsc");
            setTimeout(function() {
                $(".js_cxsc[data-id=" + post_id + "]").text("重新收藏");
            }, 1e3);
        } else {
            layer.msg("取消收藏失败,请重试！", {icon: 5});
        }
    }, "json");
});

//我的收藏页面取消收藏
$("body").delegate(".js_cxsc", "click", function() {
    var post_id = $(this).attr("data-id");
    if (post_id.length == 0) {
        return false;
    }
    $.post("/ajax/fav", {
        post_id:post_id,
        type:"post"
    }, function(data) {
        if (data.status == 1) {
            $(".js_cxsc[data-id=" + post_id + "]").text("已收藏");
            $(".js_cxsc[data-id=" + post_id + "]").addClass("js_qxsc");
            $(".js_cxsc[data-id=" + post_id + "]").removeClass("js_cxsc");
            setTimeout(function() {
                $(".js_qxsc[data-id=" + post_id + "]").text("取消收藏");
            }, 1e3);
        } else {
            layer.msg("重新收藏失败,请重试！", {icon: 5});
        }
    }, "json");
});


$('.js_del_resume_show').click(function () {
    var name = $(this).attr('data-name');
    var id = $(this).attr('data-id');
    var text = "是否确定删除名称为<span>"+name+"</span>的简历";
    $('.warn-info').html(text);
    $('.js_del_resume').attr('data-id',id);
    $(".warn-layer").show();
})
//删除简历
    $('.js_del_resume').click(function(){
        var id = $('.js_del_resume').attr('data-id');
        if (id.length == 0){
            layer.msg('未知错误', {icon: 5});
            return false;
        }
        $.post("/ajax/createUpdateResume",{id:id,type:'del'},
          function(data){
             if (data.status==1) {
                    var id = data.info.result;
                    $('.js_del_resume').val('删除成功');
                    window.location.reload();
                } else {
                     layer.msg(data.msg, {icon: 5});
                }
              },
          "json");
    });

 //创建简历
    $('.sub_new_resume').click(function(){
        var name = $('#new_resume_name').val();
        var open_level = $('input[name="open"]:checked').attr('data-id');
        if (name.length == 0 ){
            layer.msg('请输入简历名称', {icon: 5});
            return false;
        }
        if(open_level.length == 0){
            layer.msg('请设置简历的公开程度', {icon: 5});
            return false;
        }
        $('.sub_new_resume').attr('disabled','disabled');
        $.post("/ajax/createUpdateResume",{name:name,open_level:open_level,type:'create'},
          function(data){
             if (data.status==1) {
                    $('.sub_new_resume').val('创建成功');
                    var id = data.info.result;
                    window.location.href = "/resume/detail/"+id+'.html';
                } else {
                    $('.sub_new_resume').removeAttr('disabled');
                    layer.msg(data.msg, {icon: 5});
                }
              },
          "json");
    });

    $('.ws_resume_tip').click(function(){
        layer.msg("请先完善此简历的个人信息", {icon: 5});
    });
//设置默认简历
    $('.js_set_default').click(function(){
        var id = $(this).val();
        $.post("/ajax/setDefault",{id:id},
          function(data){
             if (data.status==1) {
                 layer.msg(data.msg, {icon: 1});
                 window.location.href = window.location.href ;
                } else {
                  layer.msg(data.msg, {icon: 5});
                }
              },
          "json");
    });

//关闭弹框
$('.js_close_intention_tip').click(function(){
    $('#intention_tip').hide();
   $.get("/ajax/setclose",{name:'intention_tip'},
      function(data){

          },
  "json"); 
});

    //获取选中的岗位
    function getseljob(obj,op){
        var id = '';
        var sum = 0;
        $('[name="jobcheck"]').each(function(i){
            if(op == 'sc'){
                if($('[name="jobcheck"]').eq(i).attr('checked') == "checked"){
                    sum ++;
                    id += $('[name="jobcheck"]').eq(i).attr('data-id')+',';
                }
            }else if(op=='td'){
                if($('[name="jobcheck"]').eq(i).attr('checked') == "checked"){
                    sum ++;
                    id += $('[name="jobcheck"]').eq(i).attr('data-postid')+',';
                }              
            }
            
        });
        $(obj).attr('data-id',id);
        return sum;
    }

    //批量选择
    $('.js_pl_op').click(function(){
       // alert($(this).hasClass('active'));
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('[name="jobcheck"]').removeAttr('checked');
            $(this).find("label").removeClass("active");
            // $('.js_pl_deliver').attr('disabled',true);
            // $('.js_pl_del').attr('disabled',true);
        }else{
            $('[name="jobcheck"]').attr('checked','true');
            $(this).addClass('active');
            $(this).find("label").addClass("active");
            // $('.js_pl_del').removeAttr('disabled');
            // $('.js_pl_deliver').removeAttr('disabled');
            
        }
        
    });

//批量投递
$('.js_pl_deliver').click(function(){
    
    var sum = getseljob('.js_qdtd','td');
    if(sum == 0){
        return ;
    }
    $('#js_deliver_tip').show();
    $('.js_qdtd').attr('data-op','td');
});
//批量删除
$('.js_pl_del').click(function(){
    var sum = getseljob('.js_qddel','sc');
    if(sum == 0){
        return ;
    }
    $('#js_del_tip').show();  
});
//确定投递

//确定删除
$('.js_qddel').click(function(){
    id = $(this).attr('data-id');
    if(id.length > 0){
        $('#js_del_tip').hide(); 
        $.post("/ajax/msgcenterop",{id:id,op:'sc'},
                  function(data){
                     if (data.status==1) {
                            layer.msg(data.msg, {icon: 1});
                            window.location.href = '/messages.html';
                        } else {
                            layer.msg(data.msg, {icon: 5});
                            
                        }
                      },
                  "json").error(function(){
                    layer.msg('抱歉，系统出错，请待会再试~', {icon: 5});
                  });
    }else{
         layer.msg("操作错误", {icon: 5});
    }

});

//确定投递
$('.js_qdtd').click(function(){
    var id = $(this).attr('data-id');
    var default_id = $('[name="default_id"]').val();
    var op = $(this).attr('data-op');
    if(id.length > 0 && default_id > 0){
        layer.msg('请稍候……', {icon: 6});
        if(op == 'singletd'){
            $.post("/ajax/deliver",{resume_id:default_id,post_id:id},
                      function(data){
                         if (data.status==1) {
                                layer.msg(data.msg, {icon: 1});
                                window.location.href = '/messages.html';
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                          },
                      "json").error(function(){
                    layer.msg('抱歉，系统出错，请待会再试~', {icon: 5});
                  });
        }else if(op == 'td'){
            $.post("/ajax/msgcenterop",{resume_id:default_id,post_ids:id,op:'td'},
                      function(data){
                         if (data.status==1) {
                                window.location.reload();
                                layer.msg(data.msg, {icon: 1});
                                window.location.href = '/messages.html';
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                          },
                      "json").error(function(){
                    layer.msg('抱歉，系统出错，请待会再试~', {icon: 5});
                  });
        }else{
            return;
        }
        $('#js_deliver_tip').hide();

    }else{
         layer.msg("操作错误", {icon: 5});
    }

});

//投递单个
$('.js_singletd').click(function(){
    var id = $(this).attr('data-id');
    //var default_id = $('.default_id').val();
    $('.js_qdtd').attr('data-id',id);
    $('.js_qdtd').attr('data-op','singletd');
    $('#js_deliver_tip').show();
});
//删除一个
$('.js_singledel').click(function(){
    var id=$(this).attr('data-id');
    $('.js_qddel').attr('data-id',id);
    $('#js_del_tip').show();
    //$('.js_list_'+id).find('[name="jobcheck"]').attr('checked',true);
    //$('.js_list_'+id).remove();
});