$(document).ready(function(){
    if($("#backToTop").length <= 0){
        var backToTOP = "<div id=\"backToTop\" class=\"backToTop\"><i class='fa fa-chevron-up'></i></div>"
        $("body").append(backToTOP);
    }else{
        $("#backToTop").remove();
    }
    $(window).scroll( function() {
        var top = $(window).scrollTop();
        if(top > 300){
            $("#backToTop").fadeIn(300).css({
                bottom: 20
            });
        }
        if(top < 300){
            $("#backToTop").fadeOut(200);
        }
    });
    $('#backToTop').click(function(){
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });
});
