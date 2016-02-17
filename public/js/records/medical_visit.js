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
        $condition_count++;
        $copy.find("#chronCon").attr("name", $copy.find("#chronCon").attr("name") + $condition_count);

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
        $result_count++;
        $copy.find("#labRes").attr("name", $copy.find("#labRes").attr("name") + $result_count);

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
        $meds_count++;
        $copy.find("#medList").attr("name", $copy.find("#medList").attr("name") + $meds_count);

        // append cloned element to parent
        var $parent = $("#medication");
        $copy.appendTo($parent);
    });
    // remove medication element after remove button is clicked
    $("body").on("click", ".remove-med", function(){
        $(this).parents(".med-added-div").remove();
    });

    // DROPZONE
    Dropzone.autoDiscover = false;
    Dropzone.options.medical_file_dropzone = {
        //url: 'dashboard/add/products',
        uploadMultiple: true,
        maxFiles: 10,
        //acceptedFiles: '.jpg, .jpeg',
        autoProcessQueue: false, // myDropzone.processQueue() to upload dropped files
        addRemoveLinks: true,
        dictRemoveFile: "Remove file"
    };
});

var $condition_count = 0;
var $result_count = 0;
var $meds_count = 0;