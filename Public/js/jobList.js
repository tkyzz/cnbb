function getJobUrl(type) {
    if(type){ 
        var url = "/get_postList.html";
    }else{
        var url = "/postList.html";
    }
    //var url = '';
    var paramarr = new Array();
    if ($("#area").val()) {
        paramarr.push("area=" + $("#area").val());
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
    if ($("#natures").val()) {
        paramarr.push("natures=" + $("#natures").val());
    }
    if ($("#degrees").val()) {
        paramarr.push("degrees=" + $("#degrees").val());
    }
    if ($("#sort").val()) {
        paramarr.push("sort=" + $("#sort").val());
    }
    if ($("#keyword_by").val()) {
        paramarr.push("keyword_by=" + $("#keyword_by").val());
    }
    if ($("#keyword").val()) {
        paramarr.push("keyword=" + encodeURIComponent($("#keyword").val()));
    }else{
        $("#keyword_by").val('');
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
    $("." + id).eq(0).removeClass("active");
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
    if (id == "work_day") {
        $('[data-op="work_day"]').eq(0).removeClass("active");
    }else if(id == "work_type"){
        if (str == 2){
            $("#partTimeSelection").show();
        }else{
                $("#work_day").val("");
                $("#partTimeSelection").hide();
        }
        $("." + id).eq(0).removeClass("active");
        $("." + id + "[data-id=" + str + "]").addClass("active").attr("data-type", "cancel");
    }else {
        $("." + id).eq(0).removeClass("active");
        $("." + id + "[data-id=" + str + "]").addClass("active").attr("data-type", "cancel");
    }
}

    function ajax_jobs() {
        var url = getJobUrl();
        console.log(url);
        $.ajax({
            async:false,
            type:"get",
            url:url,
            dataType:"json",
            contentType:"application/x-www-form-urlencoded; charset=utf-8",
            success:function(data) {
                if (data.status == 1) {
                    $(".post-list-box").html("");
                    $(".post-list-box").append(data.html);
                    //alert(data.param.keyword);
                    if (data.is_val) {
                        $(".search-count").show().html("共找到<span>" + data.count + "</span>个岗位");
                    } else {
                        $(".search-count").hide();
                    }
                    //var sc=$(window).scrollTop();
                    // $('body,html').animate({scrollTop:430},600);
                    if (data.page > 1) {
                        $(".tcdPageCode").remove("");
                        $(".post-related").append('<div class="tcdPageCode"></div>');
                        $(".tcdPageCode").createPage({
                            pageCount:data.page,
                            current:1,
                            backFn:function(p) {
                                //window.location.reload();
                                $("#page").val(p);
                                var url = getJobUrl() + "&ispage=1";
                                $.get(url, function(data) {
                                    if (data.status == 1 && data.html.length > 10) {
                                        $(".post-list-box").html("");
                                        $(".post-list-box").append(data.html);
                                        //var sc=$(window).scrollTop();
                                        $("body,html").animate({
                                            scrollTop:430
                                        }, 600);
                                    }
                                }, "json");
                            }
                        });
                        // console.log(ms);
                        $(".tcdPageCode").show();
                    } else {
                        $(".tcdPageCode").hide();
                    }
                }
            }
        });
      }

      function ajax_searchhint(){
          var str = $('#search').val();
          var lkey = $('#search').attr('data');
          var keyword_by = $('#search').attr('data-type');

            if(str){
              //搜索预查
                
             $.get('/ajax/post/searchhint',{keyword:str,keyword_by:keyword_by},function(data){
             if (data.status==1) {
                $('#search').attr('data',str);
                //var keyword = $('#search').val();
               // $('.js_searchhint_res').html('');
                $('.js_searchhint_res').html(data.info);
                $('.js_searchhint_res').attr('data-count',data.count).attr('data-now',-1);
                $('.js_searchhint_res').attr('data-show',1);
                $('.js_searchhint_res').show();
                //console.log(data.info);
                } else {
                    //alert("失败了");
                }
              },
          "json"); 
             
            }else{
                $('.js_searchhint_res').hide();
                return;
            }

      }
// document.onmousedown=rightKey;  
// function rightKey(){  
//     if(event.button==0){  
//         event.returnValue=false;  
//         alert("禁用鼠标右键");  
//     }  
// }  
    if ($(".jzsx").hasClass("active")) {
        $("#partTimeSelection").show();
    }
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
                $(".duration_show").text("0个月");
                $("#" + op).val("0");
            } else {
                $("#" + op).val("");
            }
            window.location.href = getJobUrl();
            //window.location.href = getJobUrl();
            return false;
        } else if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            //$(this).removeAttr('data-type');
            arr.splice($.inArray(id, arr), 1);
            $("#" + op).val(arr.join(","));
           window.location.href = getJobUrl();
            if ($("#" + op).val() == "") {
                $("." + op).eq(0).addClass("active");
            }
            // window.location.href = getJobUrl();
            return false;
        }
        if (arr.length > 2) {
            return false;
        }
        if (str.length == 0) {
            $("#" + op).val(id);
        } else {
            $("#" + op).val(str + "," + id);
        }
        if (op == "week_day" || op == "degrees" || op == "sort") {
            $(this).addClass("active").siblings().removeClass("active");
            //console.log("$('.'+op+'[data-id='+id+']').addClass('active')");
            $("#" + op).val(id);
        }
        if ( op == "sort") {
            $(this).addClass("active").siblings().removeClass("active");
            //console.log("$('.'+op+'[data-id='+id+']').addClass('active')");
            $("#" + op).val(id);
        }
        if (op == "work_type") {
            if (id == 1) {
                $("#work_day").val("");
                $("#partTimeSelection").hide();
            } else {
                $("#partTimeSelection").show();
            }
            $(this).addClass("active").siblings().removeClass("active");
            $("#" + op).val(id);
        }
        $("." + op + "[data-id=" + id + "]").addClass("active");
        $("." + op).eq(0).removeClass("active");
        //$(this).attr('data-type','cancel');
        $("#page").val("");
        var index = layer.load(0, {
            shade:false
        });
        window.location.href = getJobUrl();
        layer.close(index);
        return false;
    });
    $("body").delegate(".relation-item", "click", function() {
        var search = $(this).attr("data-kw");
        var keyword_by = $(this).attr("data-type");
        $("#keyword_by").val(keyword_by);
        $("#keyword").val(search);
        $("#page").val("1");
        var index = layer.load(0, {
            shade:false
        });
        window.location.href = getJobUrl();
        layer.close(index);
        $("#search").attr("data", "").val(search);
        $(".js_searchhint_res").hide();
        return false;
    });
    $(".keyword").click(function() {
        var search = $("#search").val();
        var keyword_by = $("#searchClass").find(".checked").attr("data");
        //alert(1);
        if ( !search ){
            keyword_by = '';
        }
        // if( search.length == 0 && keyword_by.length == 0){
        //     return false;
        // }
        $("#keyword_by").val(keyword_by);
        $("#keyword").val(search);
        $("#page").val("1");
        window.location.href = getJobUrl();
        return false;
    });

    //加天数a
    $(".raise").click(function() {
        $(".duration_show").html("");
        var num = $("#work_day").val();
        num++;
        $(this).attr("data-id", num);
        //alert(num);
        $("#work_day").val(num);
        $("#work_type").val(2);
        $(".duration_show").html(num + "个月");
        window.location.href = getJobUrl();
    });
    //减天数a
    $(".reduce").click(function() {
        var num = $("#work_day").val();
        num--;
        if (num <= 0) {
            return false;
        }
        //$(this).attr('data-id',num);
        $("#work_day").val(num);
        $("#work_type").val(2);
        $(".duration_show").html("");
        $(".duration_show").html(num + "个月");
        window.location.href = getJobUrl();
    });
    //    postList more-addr show
    $("#moreAddr").click(function () {
        var boxH = $(this).parent().find(".selection-box").height();
        if (boxH > "30"){
            $(this).parent().find(".selection-box").height("30px");
            $(this).removeClass("active");
        }else {
            $(this).parent().find(".selection-box").height("auto");
            $(this).addClass("active");
        }
    });
      $(document).ready(function(){ 
        $('#searchClass').mouseleave(function(){
            $(".class-info").height("44");
        });
        $("#searchClass").click(function () {
            var ulH = $(".class-info").height();
            if (ulH == 44){
                ulH = $(".class-info").height("auto");
                $(this).find(".class-item").click(function () {
                    $('#search').attr('placeholder','搜索'+$(this).text()).attr('data-type',$(this).attr('data'));
                    $(this).parent().prepend($(this));
                    $(this).addClass("checked").siblings().removeClass("checked");
                })
            }else {
                ulH = $(".class-info").height("44");
            }
        })

$(function(){
    spkey("trade");
    spkey("area");
    spsingekey("work_type");
    spkey("natures");
    spsingekey("degrees");
    spsingekey('sort');
    spsingekey('week_day');
    spsingekey('work_day');

})


//搜索框失去焦点
$('.post-search').mouseleave(function(){
    $('.js_searchhint_res').hide();
    $('.js_searchhint_res').attr('data-show',-1);
});
 //$('.').eq(0).addClass('active');
$("body").delegate(".relation-item","mouseover",function(){
//$('.relation-item').mouseover(function(){
   // alert(1);
   $(this).addClass('active');
  //$('.relation-item').eq(1).addClass('active');
    //if($(this).hasClass('active')){
       // $(this).addClass('active');
    //}
});

$("body").delegate(".relation-item","mouseleave",function(){

    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }
});
$('#search').focus(function(){
$('#search').unbind('keyup');
    $("#search").keyup(function (e) {
        //alert(1);
        //console.log(e);
        lastTime = e.timeStamp;
        var curKey = e.which; 

        var isshow = $('.js_searchhint_res').attr('data-show');
        //alert(curKey);
        //按回车键
        if(curKey == 13 && $('#search').val()){ 
            // alert(curKey);
            $(".keyword").click(); 
            $('.js_searchhint_res').hide();
            return false; 
        }
        //按上下键
        if(curKey >= 37 && curKey <= 40){
            var index = $('.js_searchhint_res').attr('data-count')-1;
            var now = $('.js_searchhint_res').attr('data-now');
              if(e.keyCode == 38){ 
                //alert(now);
                now-- ;
                if(now < 0){
                    now = index;
                }
                $('.js_searchhint_res').attr('data-now',now);
                
                $('.relation-item').each(function(i){
                    if($(this).hasClass('active')){
                        $('.relation-item').eq(i).removeClass('active');
                    }
                });
                $('.relation-item').eq(now).addClass('active');
              }else if (e.keyCode == 40){ 
                //console.log(now);
                now++;
                if(now > index){
                    now = 0;
                }
                $('.js_searchhint_res').attr('data-now',now);
                $('.relation-item').each(function(i){
                    if($(this).hasClass('active')){
                        $('.relation-item').eq(i).removeClass('active');
                    }
                });
                //alert($('.relation-item').eq(now).attr('data-kw'));
                $('.relation-item').eq(now).addClass('active');
              }else{
               // alert(1);
              }   
              if($('.relation-item').eq(now).attr('data-kw') && isshow != -1){
                //$('#keyword_by').val($('.relation-item').eq(now).attr('data-type'));
                $('#search').attr('data','').val($('.relation-item').eq(now).attr('data-kw'));
              }

              return;
        }
        //alert(e.timeStamp);
        //console.log(lastTime);
        var explorer =navigator.userAgent ;
        //兼容IE
      if (explorer.indexOf("MSIE") >= 0) {
          ajax_searchhint();
          return;
      }else{
        setTimeout(function () {
        if (lastTime - e.timeStamp == 0) {
            //console.log(lastTime+'\n'+e.timeStamp);
            ajax_searchhint();
            lastTime = 0;

            
        }
        }, 300);
    }
    });
 });
    }); 
      //   $("body").keydown(function(e){ 

      // }); 
