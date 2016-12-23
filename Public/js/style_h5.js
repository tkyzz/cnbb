/**
 * Created by Administrator on 2016/12/7.
 */
$(function () {
    $("#my").click(function () {
        $(".my-cont").slideToggle(500);
    });
    $("#my-cont").click(function (e) {
        if (e.target==this){
            $(".my-cont").slideUp(500);
        }
    });
});

$(function () {
    $("#share").click(function () {
        $("#sharePopup").show();
    });
    $("#sharePopup").find(".cancel-btn").click(function () {
        $("#sharePopup").hide();
    })
});

$(function () {
    var navL = $(".term-select").find(".select-item").length,
        contL = $(".post-filter").find(".filter-info").length;
    if (navL != contL){
        return true;
    }
    $(".select-item").each(function (index) {
        $(this).click(function () {
            $('.jobsea').each(function(){
                $(this).removeClass('active');//清空条件
            });
            spkey("trade");
            spsingekey("work_type");
            spsingekey('week_day');
            spsingekey('work_day');
            if ($(this).hasClass("active")){
                $(this).removeClass("active");
                $(".post-filter").find(".filter-info").hide();
                $(".footer").show();
                $(".post-list").show();
            }else {
                $(this).addClass("active").siblings().removeClass("active");
                $(".post-filter").find(".filter-info").hide().eq(index).show();
                $(".footer").hide();
                $(".post-list").hide();
            }
        });

        $(this).parent().parent().mouseleave(function () {

            $(".select-item").removeClass("active");
            $(".filter-info").hide();
            $(".footer").show();
            $(".post-list").show();
        })
    })
});
