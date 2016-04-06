/**
 * Created by cdimitzas on 16/2/2016.
 */
$(document).ready(function(){

    // In medication list if no option is selected then show input div. Else hide div

    // Function that starts an ajax in order to add select2 functionality to the selected variable
    function createSelect2($selectBox){
        $selectBox.select2({
            placeholder: 'Εμπορική ονομασία φαρμάκου',
            maximumSelectionSize: 1,
            allowClear: true,
            ajax: {
		url: $('body').attr('data-url') + "/benefiter/getMedicationList",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    var results =[];
                    $.each(data,function(index,item){
                        results.push({
                            id: item.id,
                            text:item.description
                        });
                    });
                    return {
                        results: results
                    };
                },
                templateResult: function (item) {
                    return item.id;//.id +" " + item.description;
                },
                templateSelection:  function (item, container) {
                    return item.id;
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3
        }).on('select2:select', function(){
            if( $selectBox.find(":selected").val() != null){
                $selectBox.parent().find('.medication_other_name').hide();
            }else{
                $selectBox.parent().find('.medication_other_name').show();
            }
        })
        .on('select2:unselect', function(){
            $selectBox.parent().find('.medication_other_name').show();
        });
    }

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
        $copy.find("select option").remove();
        $copy.find("#chronCon").val("");


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
        $copy.find('#labRes').val("");
    });
    // remove lab result element after remove button is clicked
    $("body").on("click", ".remove-lab-result", function(){
        $(this).parents(".lab-added-div").remove();
    });

    // add more diagnosis results
    $("body").on("click", ".add-diagnosis-result", function(){
        var $copy = $(".diagnosis-results").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("diagnosis-results").addClass("diagnosis-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$result_count++;
        //$copy.find("#labRes").attr("name", $copy.find("#labRes").attr("name") + $result_count);

        // append cloned element to parent
        var $parent = $("#diagnosis-result");
        $copy.appendTo($parent);
        $copy.find('#diagRes').val("");
    });
    // remove diagnosis result element after remove button is clicked
    $("body").on("click", ".remove-diagnosis-result", function(){
        $(this).parents(".diagnosis-added-div").remove();
    });

    // add more hospitalizations
    $("body").on("click", ".add-hospitalization", function(){
        var $copy = $(".hospitalization-div").clone();
        // change the class so they won't be cloned every time all of them
        $copy.removeClass("hospitalization-div").addClass("hospitalization-added-div");
        // make the add button invisible and the remove button visible
        $copy.find(".color-green").hide();
        $copy.find(".color-red").show();
        // set new name to dropdowns so that the controller can view them all
        //$result_count++;
        //$copy.find("#labRes").attr("name", $copy.find("#labRes").attr("name") + $result_count);

        // append cloned element to parent
        var $parent = $("#hospitalization");
        $copy.appendTo($parent);
        $copy.find('#hospRes').val("");
        $copy.find('.date-input').val("");
    });
    // remove hospitalization element after remove button is clicked
    $("body").on("click", ".remove-hospitalization", function(){
        $(this).parents(".hospitalization-added-div").remove();
    });

    // add more medication
    // calls two functions
    $("body").on("click", ".add-med", function(){
            // first clone the medicine row, in order to add another
            var $copy = $(".medicationList").clone();
            // change the class so they won't be cloned every time all of them
            $copy.removeClass("medicationList").addClass("med-added-div");
            // make the add button invisible and the remove button visible
            $copy.find(".color-green").hide();
            $copy.find(".color-red").show();

            //Clear copied fields
            $copy.find("input:text[name='medication_dosage[]']").val('');
            $copy.find("input:text[name='medication_new_name[]']").val('');
            $copy.find("input:text[name='medication_duration[]']").val('');
            //$copy.find($('#medicinal_name_' + $temp)).select2("val", "");

            // set new name to dropdowns so that the controller can view them all
            var $temp = $clickCount+1;
            $clickCount++;
            // append cloned element to parent
            var $parent = $("#medication");
            $copy.appendTo($parent);
            // change the select id name
            $copy.find('.js-example-basic-multiple').attr('id','medicinal_name_' + $temp);
            $copy.find(".select2.select2-container").remove();
            $copy.find("select > option").remove();

            $copy.find(".supply_from_praksis").removeAttr("checked");

            // then calls the select2 functionality
            createSelect2($('#medicinal_name_' + $temp));

            if($('#medicinal_name_' + $temp).val() != null){
                $('#medicinal_name_' + $temp).parent().siblings('.medication_other_name').hide();
            }else{
                $('#medicinal_name_' + $temp).parent().siblings('.medication_other_name').show();
            }

            $('.supply_from_praksis').change(function(){
                if($(this).is(':checked')){
                    $(this).siblings('.supply_from_praksis_hidden').val(1);
                }else {
                    $(this).siblings('.supply_from_praksis_hidden').val(0);
                }
            });
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

        // Clear copied fields+
        $copy.find('#refList').val('');
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
        // Clear copied fields+
        $copy.find('#file').val('');
        $copy.find("input:file[name='upload_file_title[]']").val('');
        $copy.find(".saved-file").hide();
        $copy.find(".new-upload-file").show();
    });

    // remove file element after remove button is clicked
    $("body").on("click", ".remove-file", function(){
        $(this).parents(".file-added-div").remove();
    });

    // hide upload option if saved found $ show if the present is removed
    $('.new-upload-file').hide();
    $('body').on('click', '.remove-uploaded-file', function(){
        $(this).parents('.padding-left-right-15').find('.new-upload-file').show();
        $(this).parents('.saved-file').hide();
    });

    // if something wrong happens with the validation, don't hide the #new-medical-visit form
    if($(".alert.alert-danger").length <= 0) {
        $('#new-medical-visit').hide();
    }

    // By clicking the new visit button the form should be slide down
    $('#new-med-visit-button').on('click', function(){
        $('#new-medical-visit').slideToggle(); // show/hide the #new-medical-visit form
        $('html, body').animate({
            scrollTop: $("#new-medical-visit").offset().top
        }, 500);
    });

    // SELECT2 option added for auto complete ICD10 medical conditions
    //$('select[id^=clinical-select-]').hide()
    $('select[id^="clinical-select-"]').select2({
        placeholder: $("#clinical-results-div").data("placeholder-name"),
        ajax: {
	    //url: $("#examajax").data("url")+"/benefiter/getIC10List",
	    url: $('body').attr('data-url') + "/benefiter/getIC10List",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // search term
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                var results =[];
                $.each(data,function(index,item){
                    results.push({
                        id: item.id,
                        text: item.code + ": " +item.description
                    });
                });
                return {
                    results: results
                };
            },
            templateResult: function (item) {
                return item.id;//.id +" " + item.description;
            },
            templateSelection:  function (item, container) {
                return item.id;
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 3
    });


    // SELECT2 option added for auto complete MEDICATION (or the initial select filed)
    createSelect2($('select[id^="medicinal_name_"]'));
    // In medication list if no option is selected then show input div. Else hide div
    if($('select[id^="medicinal_name_"]').val() != null){
        $('.medication_other_name').hide();
    }else{
        $('.medication_other_name').show();
    }

    //$('select2-selection__clear').on('click', function(){
    //    $('select[id^="medicinal_name_"]').select2("data", null);
    //});

    // Fade out success visit submit messge
    $('div.success-message').delay(5000).fadeOut(400);
    $('div.unsuccess-message').delay(5000).fadeOut(400);
    $('i.glyphicon.glyphicon-ok.updated-visit').delay(5000).fadeOut(400);

    // Change value to hidden field
    $('.supply_from_praksis').change(function(){
        if($(this).is(':checked')){
            $(this).siblings('.supply_from_praksis_hidden').val(1);
        }else {
            $(this).siblings('.supply_from_praksis_hidden').val(0);
        }
    });

    // Fetch via ajax request each medical visit in oredr to get Modal info & Edit previous visit
    $("button.medical_visit_from_history").on("click", function(){
        // get the clicked attribute->value
        var medical_visit_id = $(this).val();
        var medical_visit_url = $(this).data('url');
        $.ajax({
            //url: window.location.protocol + "//" + window.location.host + "/" + "benefiter/getEachMedicalVisit",
            url: medical_visit_url,
            type: "get",
            data: {current_medical_visit: medical_visit_id},
            //datatype: "json",
            success:
                function(data){
                    $('#medical-visit-modal-content').html(data);
                }
        });
    });

    // hide text input if a value is selected using select2 plugin
    // else show it
    $("body").on("change", ".js-example-basic-multiple", function(){
        // remove the empty element from select2 plugin
        $(this).siblings(".select2").find("li").each(function(){
            if($(this).attr("title") == ""){
                $(this).remove();
            }
        });
        if($(this).parent().find(".select2-selection").attr("aria-expanded") != "false"){
            $(this).parent().siblings(".medication_other_name").hide();
        } else {
            $(this).parent().siblings(".medication_other_name").show();
        }
    });

    // clinical results textareas will be shown only when select2 plugin input is clicked
    $("body").on("select2:open", ".js-example-basic-multiple", function(){
        $(this).siblings("textarea").show();
    });

    // clinical results textareas will be hidden when select2 plugin input is closed if there is nothing selected
    $("body").on("select2:close", ".js-example-basic-multiple", function(){
        if($(this).siblings(".select2").find("li").attr("title") === undefined) {
            $(this).siblings("textarea").hide();
        }
    });

    // do not display add sign on already added values
    $(".condition-added-div").each(function(){
        $(this).find(".color-green").hide();
    });
    $(".clinical-added-div").each(function(){
        $(this).find(".color-green").hide();
    });
    $(".lab-added-div").each(function(){
        $(this).find(".color-green").hide();
    });
    $(".ref-added-div").each(function(){
        $(this).find(".color-green").hide();
    });

    // remove empty elements from clinical results if existent (for medical visit edit)
    $(".js-example-basic-multiple").each(function(){
        $(this).siblings(".select2").find("li").each(function(){
            if($(this).attr("title") == ""){
                $(this).remove();
            }
        });
    });

    // check if all files are acceptable so that the submit will upload them
    $("form").on("submit", function(){
        if(!filesForUploadAreAcceptable()) {
            alert($("#upload_file").data("form-submit-error"));
            return false;
        }
    });
});

var $clickCount = $('#medication select').length;

function filesForUploadAreAcceptable(){
    var $files = $("input[type='file']");
    var $totalSize = 0;
    for(var $i = 0; $i < $files.length; $i++){
        try {
            $totalSize += $files[$i].files[0].size;
        } catch(err){
            // on medical visit edit there might be null files as they've been preselected
        }
    }
    if($totalSize <= 52428800){
        return true;
    } else {
      return false;
    }
}
