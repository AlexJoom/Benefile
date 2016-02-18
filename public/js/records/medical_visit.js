/**
 * Created by cdimitzas on 16/2/2016.
 */
$(document).ready(function(){
        // add more chronic conditions
    $("body").on("click", ".add-condition", function(){
        var $copy = $(".chronicConditions").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("chronicConditions").addClass("condition-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$condition_count++;
        //$copy.find("#chronCon").attr("name", $copy.find("#chronCon").attr("name") + $condition_count);

        // append cloned element to parent
        var $parent = $("#chronic-cond");
        $copy.appendTo($parent);
    });
    // remove chronic condition element after remove button is clicked
    $("body").on("click", ".remove-condition", function(){
        $(this).parents(".condition-added-div").remove();
    });

    // add more laboratory results
    $("body").on("click", ".add-lab-result", function(){
        var $copy = $(".lab-results").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("lab-results").addClass("lab-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$result_count++;
        //$copy.find("#labRes").attr("name", $copy.find("#labRes").attr("name") + $result_count);

        // append cloned element to parent
        var $parent = $("#lab-result");
        $copy.appendTo($parent);
    });
    // remove lab result element after remove button is clicked
    $("body").on("click", ".remove-lab-result", function(){
        $(this).parents(".lab-added-div").remove();
    });

    // add more medication
    $("body").on("click", ".add-med", function(){
        var $copy = $(".medicationList").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("medicationList").addClass("med-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$meds_count++;
        //$copy.find("#medList").attr("name", $copy.find("#medList").attr("name") + $meds_count);

        // append cloned element to parent
        var $parent = $("#medication");
        $copy.appendTo($parent);
    });
    // remove medication element after remove button is clicked
    $("body").on("click", ".remove-med", function(){
        $(this).parents(".med-added-div").remove();
    });

    // add more referrals
    $("body").on("click", ".add-ref", function(){
        var $copy = $(".referral").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("referral").addClass("ref-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$refs_count++;
        //$copy.find("#refList").attr("name", $copy.find("#refList").attr("name") + $refs_count);

        // append cloned element to parent
        var $parent = $("#referrals");
        $copy.appendTo($parent);
    });
    // remove referral element after remove button is clicked
    $("body").on("click", ".remove-ref", function(){
        $(this).parents(".ref-added-div").remove();
    });

    // add more files
    $("body").on("click", ".add-file", function(){
        var $copy = $(".uploadFile").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("uploadFile").addClass("file-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$file_count++;
        //$copy.find("#file").attr("name", $copy.find("#file").attr("name") + $file_count);

        // append cloned element to parent
        var $parent = $("#upload_file");
        $copy.appendTo($parent);
    });
    // remove file element after remove button is clicked
    $("body").on("click", ".remove-file", function(){
        $(this).parents(".file-added-div").remove();
    });
});

//var $condition_count = 0;
//var $result_count = 0;
//var $meds_count = 0;
//var $refs_count = 0;
//var $file_count = 0;