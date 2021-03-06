/**
 * Created by cdimitzas on 10/3/2016.
 */
$(document).ready(function() {
    $('div.success-message').hide();
    $('div.unsuccess-message').hide();

    Dropzone.options.dropzone = {
        acceptedFiles: ".csv",
        maxFiles: 1,
        maxFilesize: 50, // in MB
        sending: function(){
            // spinner start
            $loader = $('#main-window').faLoadingAdd('fa-circle-o-notch');
        },
        success: function(file, data) {
            html = "";
            for($i = 0; $i < data.length; $i++) {
                html = html + "<li>" + data[$i] + "</li>";
            }
            if(html != "") {
                $("#error-list").html(html);
                $("#error-list").parents("div:first").addClass("alert alert-danger");
            } else {
                $('div.success-message').show();
                $('div.success-message').delay(7000).fadeOut(400);
            }
	    },
        canceled: function (response) {
            $('div.unsuccess-message').show();
            $('div.unsuccess-message').delay(7000).fadeOut(400);
        },
        complete: function(){
            $loader.remove(); //stop the loading screen
        }
    };


    $("#elem").progressbar("option", {
        value: 100,
        disabled: true
    });
});

var $loader;

function refreshPage() {
    location.reload();
}
