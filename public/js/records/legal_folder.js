$(document).ready(function(){
    // at startup check if "asylum" is checked then display the asylum request div
    if ($("#asylum:checked").val()){
        $(".asylum-request").removeClass("hide");
    }
    else{
        $(".no-legal").removeClass("hide");
    }

    // listeners that decide whether asylum or no-legal form should be displayed
    $("body").on("change", "#asylum", function(){
        $(".asylum-request").removeClass("hide");
        $(".no-legal").addClass("hide");
    });
    $("body").on("change", "#no-legal", function(){
        $(".asylum-request").addClass("hide");
        $(".no-legal").removeClass("hide");
    });

    // at startup check if "action refusal" is checked then display the results div
    if ($("#action-refusal:checked").val()){
        $(".results").removeClass("hide");
    }

    // listeners that decide whether results div should be displayed
    $("body").on("change", "#action-none", function(){
        $(".results").addClass("hide");
    });
    $("body").on("change", "#action-refusal", function(){
        $(".results").removeClass("hide");
    });

    // at startup check if "procedure new" is checked then display the request status div
    if ($("#procedure-new:checked").val()){
        $(".request-status").removeClass("hide");
    }

    // listeners that decide whether request status div should be displayed
    $("body").on("change", "#procedure-old", function(){
        $(".request-status").addClass("hide");
    });
    $("body").on("change", "#procedure-new", function(){
        $(".request-status").removeClass("hide");
    });

    // at startup check if "penalty yes" is checked then display the request status div
    if ($("#penalty-yes:checked").val()){
        $(".penalty-text").removeClass("hide");
    }

    // listeners that decide whether penalty text area should be displayed
    $("body").on("change", "#penalty-no", function(){
        $(".penalty-text").addClass("hide");
    });
    $("body").on("change", "#penalty-yes", function(){
        $(".penalty-text").removeClass("hide");
    });
});
