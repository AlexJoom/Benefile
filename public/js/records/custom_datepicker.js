$(document).ready(function(){
    // make field a datepicker
    $(".date-input").datepicker({
        format: 'dd-mm-yyyy'
    });

    // make datepicker fields not editable but clickable
    $(".date-input").attr("readonly", "");

    // if datepicker value is "0000-00-00" display nothing
    $(".date-input").each(function(){
        if($(this).val() == "0000-00-00"){
            $(this).val("");
        } else {
            if($(this).val() != "") {
                var $data;
                if ($(this).val().length > 10) {
                    $data = $(this).val().slice(0, -9);
                } else {
                    $data = $(this).val();
                }
                var $tmp = $data.split('-');
                $data = $tmp[2] + '-' + $tmp[1] + '-' + $tmp[0];
                $(this).val($data);
            }
        }
    });

    // clear date value
    $(".clear-date").on("click", function(){
        $(this).parents('div:first').find(".date-input").val("");
    });
});
