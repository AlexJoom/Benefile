/**
 * Created by cdimitzas on 5/2/2016.
 */

$('#register-benefiter').click(function(){
    $('#new-benefiter').toggleClass('hide');
    $('#import-file').toggleClass('hide');
    $('button.buttonMenu.no-padding i').toggleClass('glyphicon-chevron-down');
});


$('#menu ul li').click(function(){
    if (!$(this).hasClass("purple-background")) {
        $("li.purple-background").removeClass("purple-background");
        $(this).addClass("purple-background");
    }
});


