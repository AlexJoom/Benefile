/**
 * Created by cdimitzas on 5/2/2016.
 */

$('#register-benefiter').click(function(){
    $('#child-1').toggleClass('hide');
    $('#child-2').toggleClass('hide');
    $('button.buttonMenu.no-padding i').toggleClass('glyphicon-chevron-down');
});



//$('li#register-benefiter-list ul > li').click(function(){
//    if (!$(this).hasClass("purple-background")) {
//        $("#register-benefiter-list ul li.purple-background").removeClass("purple-background");
//        $(this).addClass("purple-background");
//    }
//});

//$('#menu ul li > ul li').click(function(){
//    if (!$(this).hasClass("purple-background")) {
//        $("li.purple-background").removeClass("purple-background");
//        $(this).addClass("purple-background");
//    }
//});

$('#menu ul li').click(function(){
    if (!$(this).hasClass("purple-background")) {
        $("li.purple-background").removeClass("purple-background");
        $(this).addClass("purple-background");
    }
});

