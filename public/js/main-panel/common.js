/**
 * Created by cdimitzas on 5/2/2016.
 */
$('#menu ul > li').click(function(){
    if (!$(this).hasClass("purple-background")) {
        $("li.purple-background").removeClass("purple-background");
        $(this).addClass("purple-background");
    }
});

//$('li#register-benefiter-list ul li').click(function(){
//    if (!$(this).hasClass("purple-background")) {
//        $("li.purple-background").removeClass("purple-background");
//        $(this).addClass("purple-background");
//    }
//});

$('#register-benefiter').click(function(){
    $('#register-benefiter-list').toggleClass('hide');
    $('li#register-benefiter-list').css('height','85px');
});