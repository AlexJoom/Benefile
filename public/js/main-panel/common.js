/**
 * Created by cdimitzas on 5/2/2016.
 */

$('div#sidebar').css({'height':($('.table-row.height-100per').height())+'px'});

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

/* START OF "NEW RECORD" AJAX CALL */
// when "new record" is clicked in panel make an ajax call to display that page
$("#new-benefiter a").on("click", function(){
    $.ajax({
        url: $(this).attr("href"),
        type: "get",
        success: function(data){
            DisplayNewBenefiterFormAndSetUrl(data, this.url);
        }
    });
    return false;
});

// display new benefiter form and set appropriate url
function DisplayNewBenefiterFormAndSetUrl(data, url){
    var $content = data.substring(data.indexOf('<div class="no-margin light-green-background'), data.indexOf('<!-- JavaScripts -->'));
    $("#main-window").html($content);
    window.history.pushState("", document.title, url); // change the url of the browser
};
/* END OF "NEW RECORD" AJAX CALL */


