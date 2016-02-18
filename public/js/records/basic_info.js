$(document).ready(function(){
    // at startup check if "yes" is checked and then display the working legally div
    if ($("#show_work_legally:checked").val())
        $("#working_legally_div").show();
    else
        $("#working_legally_div").hide();

    // listeners that decide if working legally div should be displayed
    $("body").on("change", "#show_work_legally", function(){
        $("#working_legally_div").show();
    });
    $("body").on("change", "#hide_work_legally", function(){
        $("#working_legally_div").hide();
    });

    // add more languages
    $("body").on("click", ".add-lang", function(){
        var $copy = $(".language-div").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("language-div").addClass("added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        $langs_count++;
        $copy.find(".language-selection").attr("name", $copy.find(".language-selection").attr("name") + $langs_count);
        $copy.find(".level-selection").attr("name", $copy.find(".level-selection").attr("name") + $langs_count);
        // append cloned element to parent
        var $parent = $("#language-wrapper");
        $copy.appendTo($parent);
    });

    // remove lang element after remove button is clicked
    $("body").on("click", ".remove-lang", function(){
        $(this).parents(".added-div").remove();
    });

    // make added-div languages display remove and not add button
    $(".added-div").each(function(){
        $(this).find(".color-green").hide();
        $(this).find(".color-red").show();
    });

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

var $langs_count = 0;
