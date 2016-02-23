$(document).ready(function(){
    // make field a datepicker
    $(".date-input").datepicker({
        format: 'dd-mm-yyyy'
    });

    // make datepicker fields not editable but clickable
    $(".date-input").attr("readonly", "");

    // clear date value
    $(".clear-date").on("click", function(){
        $(this).parents('div:first').find(".date-input").val("");
    });
});
