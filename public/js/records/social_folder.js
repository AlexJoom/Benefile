$(document).ready(function(){
    // when input of type text is focused, change the color of the label
    $("body").on("focus", "input", function(){
        if($(this).attr("type") == "text") {
            var $labelParent = $(this).parents(".form-group").first();
            var $label = $labelParent.find("label").first();
            $label.addClass("focused")
        }
    });

    // when input is blurred change to normal color
    $("body").on("blur", "input", function(){
        $(this).parents(".form-group").first().find("label").removeClass("focused");
    });

    // when input of type textarea is focused, change the color of the label
    $("body").on("focus", "textarea", function(){
        var $labelParent = $(this).parents(".form-group").first();
        var $label = $labelParent.find("label").first();
        $label.addClass("focused")
    });

    // when input is blurred change to normal color
    $("body").on("blur", "textarea", function(){
        $(this).parents(".form-group").first().find("label").removeClass("focused");
    });

    // slide toggle to add a new session
    $(".new-session").hide();
    $("#add-new-session").on("click", function(){
        $(".new-session").slideToggle("slow");
    });

    // slide toggle to edit a session
    $(".edit-session-div").hide();
    $(".edit-session").on("click", function(){
        $(this).parents(".div-table-row:first").next().slideToggle("slow");
    });
});
