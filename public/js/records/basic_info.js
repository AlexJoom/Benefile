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
});
