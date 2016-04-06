$(document).ready(function(){
    // at startup check if "yes" is checked and then display the working legally div
    if ($("#show_work_legally:checked").val()){
        $("#working_legally_div").show();
        $("#working_title_div").show();
    }
    else{
        $("#working_legally_div").hide();
        $("#working_title_div").hide();
    }

    // listeners that decide if working legally div and working title div should be displayed
    $("body").on("change", "#show_work_legally", function(){
        $("#working_legally_div").show();
        $("#working_title_div").show();
    });
    $("body").on("change", "#hide_work_legally", function(){
        $("#working_legally_div").hide();
        $("#working_title_div").hide();
        $("#working_title").val("");
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

    // display modal asking for session deletion confirmation
    $(".delete-session").on("click", function(e){
        $("#delete-session-modal").modal('show');
        var delSessionPath = $(".delete-session-path").attr("value") + "/";
        $(".delete-session-form").attr("action", delSessionPath);
    });

    // make added-div languages display remove and not add button
    $(".added-div").each(function(){
        $(this).find(".color-green").hide();
        $(this).find(".color-red").show();
    });

    // add more referrals in basic info
    $("body").on("click", ".add-ref", function(){
        var $copy = $(".basic_info_referral").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("basic_info_referral").addClass("ref-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        $copy.find("input").val('');
        // set new name to dropdowns so that the controller can view them all
        //$refs_count++;
        //$copy.find("#refList").attr("name", $copy.find("#refList").attr("name") + $refs_count);

        // append cloned element to parent
        var $parent = $("#basic_info_referrals");
        $copy.appendTo($parent);
    });

    // remove referral element after remove button is clicked
    $("body").on("click", ".remove-ref", function(){
        $(this).parents(".ref-added-div").remove();
    });

    // on document ready display the months passed from duration date
    displayMonthsPassed($("#detention-date").val());

    // on detention date change get the correct amount of months passed
    $("#detention-date").on("changeDate focusout", function(){
        displayMonthsPassed($(this).val());
    });

    // Apply dataTable to benefiter referrals history
    $(function() {
        $('#benefiter_referrals_history').DataTable( {
            //"lengthMenu": [ [-1], ["All"] ]
        });
    });
});

var $langs_count = $(".added-div").length;

function displayMonthsPassed($selected_date){
    if($selected_date != null) {
        // used only for document ready, if no date is selected
        if ($selected_date == "") {
            $("#months-passed").text("");
            return;
        }
        var $det_date = new Date($selected_date.substring(6, 10), $selected_date.substring(3, 5) - 1, $selected_date.substring(0, 2));
        var $now = $.now();
        var $diff = new Date($now - $det_date);
        if ($diff >= 0) {
            var $array = ($diff / 1000 / 60 / 60 / 24 / 30).toString().split(".");
            var $result = $array[0];
            if ($result == 1) {
                $result = $result + " " + $("#months-passed").data("month");
            } else {
                $result = $result + " " + $("#months-passed").data("months");
            }
            $("#months-passed").text("(" + $result + ")");
        } else {
            $("#months-passed").text("");
        }
    }
}
