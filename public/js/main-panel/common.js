/**
 * Created by cdimitzas on 5/2/2016.
 */

$('#register-benefiter').click(function(){
    $('#new-benefiter').toggleClass('hide');
    $('#import-file').toggleClass('hide');
    if($(this).find("div i").hasClass('glyphicon-chevron-right')) {
        $(this).find("div i").removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
    } else {
        $(this).find("div i").removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
    }
});


$('#menu ul li').click(function(){
    if (!$(this).hasClass("purple-background")) {
        $("li.purple-background").removeClass("purple-background");
        $(this).addClass("purple-background");
    }
});


