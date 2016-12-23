/**
 * Created by Administrator on 2016/7/4.
 */

$(document).ready(function () {

    
    $(".input-box").each(function () {
        $(this).children("input").focus(function () {
            $(this).next("label").css("display","none");
        }).blur(function () {
            if ($(this).val() == ""){
                $(this).next("label").css("display","block");
            }else {
                $(this).next("label").css("display","none");
            }
        })
    });

    $(".tab-title span").each(function (index) {
        $(this).click(function () {
            $(this).addClass("select").siblings().removeClass("select");
            $(".sign-box").eq(index).css("display","block").siblings(".sign-box").css("display","none");
        })
    });

//    recommend hove
    $(".sub-recommend").each(function () {
        $(this).hover(function () {
            $(this).find($(".hove-bg")).css("display","block");
        },function () {
            $(this).find($(".hove-bg")).css("display","none");
        })
    });

//    profile-item hove
    $(".profile-cover").each(function () {
        $(this).hover(function () {
            $(this).find(".profile-info").css("display","none");
            $(this).find(".profile-state").css("display","block");
        },function () {
            $(this).find(".profile-info").css("display","block");
            $(this).find(".profile-state").css("display","none");
        });
        
    //   profile-remove 
        $(this).find(".profile-remove").click(function () {
            $(".warn-layer").show();
        })
    });

//    profile-remove cancel
    $("#cancel").click(function () {
        $(".warn-layer").hide();
    });

//    my-nav show/hide
    $("#my").hover(function () {
        $(this).toggleClass("nav-hove");
        $(this).children("div").stop().slideToggle();
    });

//    companyProfile company-info
    $(".section-more").click(function () {
        var infoBoxH = $(".info-box").height();
        var infoH = $(".company-info").height();
        if (infoBoxH<=230){
            $(this).hide();
            $(this).parent().parent().height(infoBoxH);
            return
        }
        if (infoBoxH > infoH){
            $(this).addClass("up");
            $(this).parent().parent().height(infoBoxH+40);

        }else {
            $(this).removeClass("up");
            $(this).parent().parent().height(230);
        }
    });

//    postList more related
    $("#moreBtn").click(function () {
        $(this).toggleClass("more-down");
        $("#moreRelated").toggle();
    });

//    tips show
    $(".tips-title").hover(function () {
        $(this).next(".tips-info").toggle();
    });

//    myNotice reply-change
    $(".notice-item").each(function (index) {
        $(this).find(".reply-change").click(function () {
            $(this).hide();
            $(".reply-info").eq(index).show();
        });

        //    myNotice notice-cont show/hide
        $(this).find(".notice-title").click(function () {
            $(this).toggleClass("notice-up");
            $(this).next(".notice-cont").toggle();
        })
    });
    

    
//    newProfile level-info show
    $(".block-append").each(function () {
        $(this).click(function () {
            $(this).next(".level-info").show();
            $(this).remove();
        })
    });

    //    profileEdit edit/show
    $(".profile-show").each(function (index) {
        $(this).find(".edit").click(function () {
            $(".profile-show").eq(index).hide();
            $(".profile-edit").eq(index).show();
        });
        $(this).next(".profile-edit").find(".detail-btn a").click(function () {
            $(".profile-show").eq(index).show();
            $(".profile-edit").eq(index).hide();
        })
    });

//    myFeedback feedback-detail show/hide
    $(".feedback-item").each(function (index) {
        $(this).find(".feedback-btn").click(function () {
            $(".feedback-detail").eq(index).show();
        });
        $(this).find(".feedback-up").click(function () {
            $(".feedback-detail").eq(index).hide();
        })
    });

//    postDetail detail-favorite
    $(".detail-favorite").click(function () {
        var post_id = $(this).attr('data-id');
        if ($(".detail-favorite").hasClass("favorite-active")){
             $.post("/ajax/fav",{post_id:post_id,type:"delete"},
              function(data){
                 if (data.status==1) {
                        $(".detail-favorite").removeClass("favorite-active");
                        $("#favoriteTips").text("取消收藏");
                        setTimeout(function () {$("#favoriteTips").text("");},500)
                    } else {
                        $("#favoriteTips").text("取消收藏失败,请重试！");
                        setTimeout(function () {$("#favoriteTips").text("");},500)
                    }
                  },
              "json");

        }else {
             $.post("/ajax/fav",{post_id:post_id,type:"post"},
              function(data){
                 if (data.status==1) {
                        $(".detail-favorite").addClass("favorite-active");
                        $("#favoriteTips").text("收藏成功");
                        setTimeout(function () {$("#favoriteTips").text("");},500)
                    } else {
                        $("#favoriteTips").text("收藏失败,请重试！");
                        setTimeout(function () {$("#favoriteTips").text("");},500)
                    }
                  },
              "json");

        }
 
    });

    //    postDetail detail-favorite
    $(".detail-share").hover(function () {
        $("#shareBar").toggle();
    });

//    postDetails popup show
    $(".apply-btn").click(function () {
        var resume_id = $('#post_resume').val();
        $.post("/ajax/getIntention",{resume_id:resume_id},
              function(data){
                 if (data.status==1) {

                        alert(data.msg);
                    } else {
                        alert(data.msg);
                    }
                  },
              "json");
        $("#willPopup").show();
    });

//    newProfile sidebar is fixed
$(function () {
    var navH = $("#slideNav").offset().top;
    $(window).scroll(function () {
        var scrollH = $(this).scrollTop();
        if (scrollH>=navH){
            $("#slideNav").addClass("nav-scroll");
        }else {
            $("#slideNav").removeClass("nav-scroll");
        }
    })
});

//    picture carousel
$(function () {
    var curIndex = 0,
        imgIndex =$(".img-list").length,

        imgHeight = $(".img-list").height();

    $("#banner").height( imgHeight);
    $(".banner-img").height(imgHeight);

    function autoPlay() {
        if (curIndex < imgIndex-1){
            curIndex++;
        }else {
            curIndex = 0;
        }

        imgPlay(curIndex);
    }
    var timer = setInterval(autoPlay(),3000);


    $(".banner").hover(function () {
        clearInterval(timer);
        timer = null;
    },function () {
        clearInterval(timer);
        timer = setInterval(autoPlay(),3000);
    });

    $(".slider-pre").click(function () {

    });

    $(".slider-next").click(function () {
        curIndex = (curIndex < imgIndex-1) ? (++curIndex):0;

        imgPlay(curIndex);
    });

    function imgPlay(num) {
        var goLeft = num*100;
        $(".banner-img").animate({left:"-"+goLeft+"%"},500);
    }
});

//-----------------------------------------------分页开始--------------------------------------------------------------
$(function(){
    var total = 14;
    var perpage = 10;
    var pageCount = Math.ceil(total/perpage);

//生成分页按钮
    if(pageCount>5){
        pageIcon(1,5,0);
    }else{
        pageIcon(1,pageCount,0);
    }

    //分页按钮
    $("#pageGroup span").click(function(){
        if(pageCount > 5){
            var pageNum = parseInt($(this).html());   //获取当前页
            pageGroup(pageNum,pageCount);
        }else{
            $(this).addClass("active");
            $(this).siblings("span").removeClass("active");
        }
    });

//上一页
    $("#pageUp").click(function(){
        if(pageCount > 5){
            var pageNum = parseInt($("#pageGroup span.active").html());
            pageUp(pageNum,pageCount);
        }else{
            var index = $("#pageGroup span.active").index();     //获取当前页
            if(index > 0){
                $("#pageGroup span").removeClass("active");
                $("#pageGroup span").eq(index-1).addClass("active");
            }
        }
    });

//下一页
    $("#pageDown").click(function(){
        if(pageCount > 5){
            var pageNum = parseInt($("#pageGroup span.active").html());
            pageDown(pageNum,pageCount);
        }else{
            var index = $("#pageGroup span.active").index();
            if(index+1<pageCount){
                $("#pageGroup span").removeClass("active");
                $("#pageGroup span").eq(index+1).addClass("active");
            }
        }
    });

    //点击跳转页面
    function pageGroup(pageNum,pageCount){
        switch (pageNum){
            case 1:
                pageIcon(1,5,0);
                break;
            case 2:
                pageIcon(1,5,1);
                break;
            case pageCount-1:
                pageIcon(pageCount-4,pageCount,3);
                break;
            case pageCount:
                pageIcon(pageCount-4,pageCount,4);
                break;
            default :
                pageIcon(pageNum-2,pageNum+2,2);
                break;
        }
    }

//根据当前选中页生成页面点击按钮
    function pageIcon(page,count,eq){
        //var spanHtml = "";
        //for(var i=page;i<=count;i++){
        //    spanHtml += "<span>"+i+"</span>";
        //}
        //$("#pageGroup").html(spanHtml);
        $("#pageGroup").empty();
        for(var i=page;i<=count;i++){
            $("#pageGroup").append("<span>"+i+"</span>");
        }
        $("#pageGroup span").eq(eq).addClass("active");
        $("#pageGroup span").each(function() {
            $(this).click(function () {
                if (pageCount > 5) {
                    var pageNum = parseInt($(this).html());//获取当前页数
                    pageGroup(pageNum, pageCount);
                } else {
                    $(this).addClass("active");
                    $(this).siblings("span").removeClass("active");
                }
            });
        });
    }

//上一页
    function pageUp(pageNum,pageCount){
        switch (pageNum){
            case 1:
                break;
            case 2:
                pageIcon(1,5,0);
                break;
            case pageCount-1:
                pageIcon(pageCount-4,pageCount,2);
                break;
            case pageCount:
                pageIcon(pageCount-4,pageCount,3);
                break;
            default :
                pageIcon(pageNum-2,pageNum+2,1);
        }
    }

//下一页
    function pageDown(pageNum,pageCount){
        switch (pageNum){
            case 1:
                pageIcon(1,5,1);
                break;
            case 2:
                pageIcon(1,5,2);
                break;
            case pageCount-1:
                pageIcon(pageCount-4,pageCount,4);
                break;
            case pageCount:
                break;
            default :
                pageIcon(pageNum-2,pageNum+2,3);
                break;
        }
    }
});
//-----------------------------------------------分页结束--------------------------------------------------------------.
//
