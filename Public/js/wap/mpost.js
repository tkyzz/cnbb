function getJobUrl(type) {
    if(type){
        var url = "/m/getJobList.html";
    }else{
       var url = "/m/postList.html"; 
    }
    
    var paramarr = new Array();
    if ($("#city").val()) {
        paramarr.push("city=" + $("#city").val());
    }
    if ($("#trade").val()) {
        paramarr.push("trade=" + $("#trade").val());
    }
    if ($("#work_type").val()) {
        paramarr.push("work_type=" + $("#work_type").val());
    }
    if ($("#week_day").val()) {
        paramarr.push("week_day=" + $("#week_day").val());
    }
    if ($("#work_day").val()) {
        paramarr.push("work_day=" + $("#work_day").val());
    }
    if ($("#page").val() > 1) {
        paramarr.push("page=" + $("#page").val());
    }
    if (paramarr.length > 0) {
        //url = url+'?'+paramarr.join('&')+'#result';
        url += "?" + paramarr.join("&");
    }
    return url;
}

function spkey(id) {
    //初始化搜索条件多个
    //arr = arr;
    var str = $("#" + id).val();
    if (str.length == 0) {
        return false;
    } else {
        var arr = str.split(",");
    }
    //$("." + id).eq(0).removeClass("active");
    for (var i in arr) {
        //alert(arr[i]);
        $("." + id + "[data-id=" + arr[i] + "]").addClass("active").attr("data-type", "cancel");
    }
}

function spsingekey(id) {
    //初始化搜索条件单个
    //alert(1);
    var str = $("#" + id).val();
    if ($("#" + id).val().length == 0) {
        return false;
    }
    if (id == 'work_type'){
        if ( str == 2 ){
            $('.work_day_area').show();
        }else {
            $("#work_day").val("");
            $('.work_day_area').hide();
        }  
    }
    $("." + id + "[data-id=" + str + "]").addClass("active").attr("data-type", "cancel");

    // if (id == "work_day") {
    //     $('[data-op="work_day"]').eq(0).removeClass("active");
    // } else {
    //     $("." + id).eq(0).removeClass("active");
    //     $("." + id + "[data-id=" + str + "]").addClass("active").attr("data-type", "cancel");
    // }
}

//得到岗位列表
function GetJobList(){
                var index = layer.load(1, {
                  shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    type: 'post',
                    url: getJobUrl(),
                    dataType: 'json',
                    success: function(data){
                        if( data.status == 1 ){
                            //$('#page').val(parseInt(page)+1); 
                            $('.post-list').html('');
                            $('.post-list').append(data.html);
                            $(".select-item").removeClass("active");
                            $(".filter-info").hide();
                            $(".footer").show();
                            $(".post-list").show();

                        }else{
                            $('.post-list').html('');
                            $(".select-item").removeClass("active");
                            $(".filter-info").hide();
                            $(".footer").show();
                            $(".post-list").show();
                            layer.msg(data.msg,{icon:2});
                        }
                        layer.closeAll('loading'); //关闭加载层
                    },
                    error: function(xhr, type){
                        $(".select-item").removeClass("active");
                        $(".filter-info").hide();
                        $(".footer").show();
                        $(".post-list").show();
                        layer.closeAll('loading'); //关闭加载层
                        layer.msg('网络异常，请重试',{icon:2});
                        //layer.alert('');
                    }
                });

}
$(function(){




    $(".jobsea").click(function() {
        //alert(1);
        var id = $(this).attr("data-id");
        var op = $(this).attr("data-op");
        var str = $("#" + op).val();
        if (str.length != 0) {
            var arr = str.split(",");
        } else {
            var arr = "";
        }
        if (id == "0") {
           $('.post-select').show();
            $(this).addClass("active").siblings().removeClass("active");
            if (op == "work_day") {
                //$(".duration_show").text("0个月");
                $("#" + op).val("0");
                //$("#" + op).attr('data-v',"0");
            } else {
                //$("#" + op).attr('data-v',"");
                $("#" + op).val("");
            }
            //ajax_jobs();
            //window.location.href = getJobUrl();
            return false;
        } else if ($(this).hasClass("active")) {
            // alert(1);
            $(this).removeClass("active");
            //$(this).removeAttr('data-type');
            arr.splice($.inArray(id, arr), 1);
            $("#" + op).val(arr.join(","));
            //$("#" + op).attr('data-v',arr.join(","));
            //ajax_jobs();
            // if ($("#" + op).val() == "") {
            //     $("." + op).eq(0).addClass("active");
            // }
            // window.location.href = getJobUrl();
            return false;
        }
        //不能超过三个
        if (arr.length > 2) {
            return false;
        }
        if (str.length == 0) {
            //$("#" + op).attr('data-v',id);
            $("#" + op).val(id);
        } else {
            //$("#" + op).attr('data-v',str + "," + id);
            $("#" + op).val(str + "," + id);
        }
        if (op == "week_day" || op == "degrees" || op == "sort" || op == "work_day") {
            $(this).addClass("active").siblings().removeClass("active");
            //console.log("$('.'+op+'[data-id='+id+']').addClass('active')");
            //$("#" + op).attr('data-v',id);
            $("#" + op).val(id);
        }
        if ( op == "sort") {
            $(this).addClass("active").siblings().removeClass("active");
            //console.log("$('.'+op+'[data-id='+id+']').addClass('active')");
            //$("#" + op).attr('data-v',id);
            $("#" + op).val(id);
            if(id == -1){
              $('.post-select').hide();
            }else{
               $('.post-select').show();
            }
        }
        if (op == "work_type") {
            if (id == 2) {
                $(".work_day_area").show();
            } else {
                $("#work_day").val("");
                //$("#work_day").attr('data-v',"");
                $(".work_day_area").hide();
            }
            $(this).addClass("active").siblings().removeClass("active");
            $("#" + op).val(id);
            //$("#" + op).attr('data-v',id);
        }
        $("." + op + "[data-id=" + id + "]").addClass("active");
        //$("." + op).eq(0).removeClass("active");
        //$(this).attr('data-type','cancel');
        $("#page").val("1");
         
        // me.dropReload();
        // $('.element').dropload({
        //     scrollArea : window,
        //     loadDownFn : function(me){
        //         var sum = 0;
        //         var page = $('#page').val(); 
        //         $('.post-item').each(function(){
        //             sum ++;
        //         });
        //         if(sum < 10 && page <=2){
        //             return false;
        //         }
                
        //         $.ajax({
        //             type: 'post',
        //             url: getJobUrl(),
        //             dataType: 'json',
        //             success: function(data){
        //                 if( data.status == 1 ){
        //                     $('#page').val(parseInt(page)+1); 
        //                     $('.post-list').append(data.html);
        //                     // 每次数据加载完，必须重置
        //                     me.resetload();
        //                 }else{
        //                     layer.msg(data.msg,{icon:2});
        //                     // 每次数据加载完，必须重置
        //                     me.resetload();
        //                 }

        //             },
        //             error: function(xhr, type){
        //                 alert('请求失败，请重试');
        //                 // 即使加载出错，也得重置
        //                 me.resetload();
        //             }
        //         });
        //     }
        // });
        //dropReload();
        return false;
    });


$('.sec_sub').click(function(){
    // var trade = $('#trade').val();
    // var work_type = $('#work_type').val();
    // var week_day = $('#week_day').val();
    // var work_day = $('#work_day').val();
    // $('#trade').val(trade);
    // $('#work_type').val(work_type);
    // $('#week_day').val(week_day);
    // $('#work_day').val(work_day);
    window.location.href = getJobUrl();
});
})