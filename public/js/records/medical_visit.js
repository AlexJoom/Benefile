/**
 * Created by cdimitzas on 16/2/2016.
 */
$(document).ready(function(){

    // In medication list if no option is selected then show input div. Else hide div

    // Function that starts an ajax in order to add select2 functionality to the selected variable
    function createSelect2($selectBox){
        $selectBox.select2({
            placeholder: 'Εμπορική ονομασία φαρμάκου',
            allowClear: true,
            ajax: {
                url: "http://localhost/benefile/index.php/benefiter/getMedicationList",
                //url: "/benefiter/getMedicationList",
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
            if($selectBox.find(":selected").val() == 0 || typeof $selectBox.find(":selected").val() === 'undefined'){
                $selectBox.parent().find('.medication_other_name').show();
            }else{
                $selectBox.parent().find('.medication_other_name').hide();
            }
        }).on('select2:unselect', function(){
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

    // add more medication
    // calls two functions
    $("body").on("click", ".add-med",
        // first clone the medicine row, in order to add another
        function(){
            var $copy = $(".medicationList").clone();
            // change the class so they won't be cloned every time all of them
            $copy.removeClass("medicationList").addClass("med-added-div");
            // make the add button invisible and the remove button visible
            $copy.find(".color-green").hide();
            $copy.find(".color-red").show();
            // set new name to dropdowns so that the controller can view them all
            var $temp = $clickCount;
            $clickCount++;
            // append cloned element to parent
            var $parent = $("#medication");
            $copy.appendTo($parent);
            // change the select id name
            $copy.find('.js-example-basic-multiple').attr('id','medicinal_name_' + $temp);
            $copy.find(".select2.select2-container").remove();

            //Clear copied fields
            $copy.find("input:text[name='medication_dosage[]']").val('');
            $copy.find("textarea[name='medication_new_name[]']").val('');
            $copy.find("input:text[name='medication_duration[]']").val('');
            $copy.find("input:checkbox[name='supply_from_praksis[]']").attr('checked', false);

            $('.supply_from_praksis').change(function(){
                console.log('hell');
                if($(this).is(':checked')){
                    $(this).siblings('.supply_from_praksis_hidden').val(1);
                }else {
                    $(this).siblings('.supply_from_praksis_hidden').val(0);
                }
            });


            // then calls the select2 functionality
            createSelect2($('#medicinal_name_' + $temp));
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
    });
    // remove file element after remove button is clicked
    $("body").on("click", ".remove-file", function(){
        $(this).parents(".file-added-div").remove();
    });

    // By clicking the new visit button the form should be slide down
    $('#new-medical-visit').hide();
    $('#new-med-visit-button').on('click', function(){
        $('#new-medical-visit').slideToggle();
        $('html, body').animate({
            scrollTop: $("#new-medical-visit").offset().top
        }, 500);
    });

    // SELECT2 option added for auto complete ICD10 medical conditions
    //$('select[id^=clinical-select-]').hide()
    $('select[id^="clinical-select-"]').select2({
        placeholder: 'Πάθηση',
        ajax: {
            url: "http://localhost/benefile/index.php/benefiter/getIC10List",
            //url: "/benefiter/getIC10List",
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
    createSelect2($('#medicinal_name_1'));
    // In medication list if no option is selected then show input div. Else hide div
    if($('select[id^="medicinal_name_"]').find(":selected").val() == 0 || typeof $('select[id^="medicinal_name_"]').find(":selected").val() === 'undefined'){
        $('.medication_other_name').show();
    }else{
        $('.medication_other_name').hide();
    }

    // Fade out success visit submit messge
    $('div.success-message').delay(5000).fadeOut(400);
    $('div.unsuccess-message').delay(5000).fadeOut(400);

    // Change value to hidden field
    $('.supply_from_praksis').change(function(){
        console.log('hell');
        if($(this).is(':checked')){
            $(this).siblings('.supply_from_praksis_hidden').val(1);
        }else {
            $(this).siblings('.supply_from_praksis_hidden').val(0);
        }
    });
});


//var $condition_count = 0;
//var $result_count = 0;
//var $meds_count = 0;
//var $refs_count = 0;
//var $file_count = 0;
var $clickCount =2;