$(document).ready(function(){
    // at startup check if "yes" is checked and then display the working legally div
    if ($("#show_work_legally:checked").val())
        $("#working_legally_div").show();
    else
        $("#working_legally_div").hide();

    // listeners that decide if working legally div should be displayed
    $("#show_work_legally").on("change", function(){
        $("#working_legally_div").show();
    });
    $("#hide_work_legally").on("change", function(){
        $("#working_legally_div").hide();
    });

    // add more languages
    $("a.color-green").on("click", function(){
        var $copy = $(".language-div").clone();
        $copy.removeClass("language-div").addClass("added-div");
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        $copy.appendTo($parent);
        //$langs_count++;
    });

    $("body").on("click", ".color-red", function(){
        $(this).parents(".added-div").hide();
        //$langs_count--;
    });
});

//var $langs_count = 1;
var $parent = $(".language-div").parent();
