$(document).ready(function(){

    // on form submit, change the form action url so it includes the search parameters
    $("#search-form").on("submit", function(){
        var $url = $(this).attr('action');
        var $folder_number = $("input[name='folder_number']").val();
        var $lastname = $("input[name='lastname']").val();
        var $name = $("input[name='name']").val();
        var $fathers_name = $("input[name='fathers_name']").val();
        var $gender_id = $("input:radio[name='gender_id']:checked").val() == "undefined" ? "" : $("input:radio[name='gender_id']:checked").val();
        var $telephone = $("input[name='telephone']").val();
        var $birth_date = $("input[name='birth_date']").val();
        var $origin_country = $("input[name='origin_country']").val();
        var $medical_location_id = $("select:first").val();
        var $temp = {'folder_number': $folder_number,
                'lastname': $lastname,
                'fname': $name,
                'fathers_name': $fathers_name,
                'gender_id': $gender_id,
                'telephone': $telephone,
                'birth_date': $birth_date,
                'origin_country': $origin_country,
                'medical_location_id': $medical_location_id
            };
        //var $queryUrl = $(this).attr('action') + '?folder_number=' + $("input[name='folder_number']").val() +
        //    '&lastname=' + $("input[name='lastname']").val() + '&name=' + $("input[name='name']").val() +
        //    '&fathers_name=' + $("input[name='fathers_name']").val() + '&gender_id=' +
        //    $("input:radio[name='gender_id']:checked").val() == "undefined" ?  + '&telephone=' +
        //    $("input[name='telephone']").val() + '&birth_date=' + $("input[name='birth_date']").val() +
        //    '&origin_country=' + $("input[name='origin_country']").val() + '&medical_location_id=' +
        //    $("select:first").val();
        //window.history.pushState("", document.title, $queryUrl);
        MakeAjaxSearchCall($url, $temp);
        return false;
    });

    // initialize DataTable
    $('#results').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        bInfo: false
    });

    // if folder_number is already put, then auto submit form to get results
    if($('input[name="folder_number"]').val().length != 0) {
        $('#search-form').trigger('submit');
    }
});

// make the ajax call to get a response
function MakeAjaxSearchCall($url, $values){
    var $loader;
    $.ajax({
        url: $url,
        type: 'get',
        data: {'folder_number': $values.folder_number,
                'lastname': $values.lastname,
                'name': $values.fname,
                'fathers_name': $values.fathers_name,
                'gender_id': $values.gender_id,
                'telephone': $values.telephone,
                'birth_date': $values.birth_date,
                'origin_country': $values.origin_country,
                'medical_location_id': $values.medical_location_id
            },
        beforeSend: function () {
            // remove the bottom margin
            $('.benefiters-search').removeClass('margin-bottom-300px');
            // shows the results div and the loading state section, hiding all others
            $('#search-results').show();
            $('.state').hide();
            $('.state-loading').show();
            // spinner start
            $loader = $('.state-loading').faLoadingAdd('fa-circle-o-notch');
        },
        success: function ($response) {
            // remove all rows from results table
            $("#results > tbody > tr").remove();
            // display results returned
            DisplayResults($response);
        },
        error: function ($response) {
            $('.state-error').show();
        },
        complete: function () {
            $loader.remove(); //stop the loading screen
            // hide loading section
            $('.state-loading').hide();
        }
    });
}

// show the results returned from the ajax call
function DisplayResults($response){
    // if nothing is returned, display "No results found" message
    if($response == ''){
        $('.state-no-results').show();
    } else { // else display results returned
        $view_folders = $('#search-results').data('view-folders');
        for (var i in $response) {
            $anchor = $('#search-results').data('url').replace('-1', $response[i].id);
            $row = "<tr><td>" + $response[i].folder_number + "</td><td>" + $response[i].name + "</td><td>" + $response[i].lastname + "</td><td>" + $response[i].telephone + "</td><td><a href=\"" + $anchor + "\" class=\"simple-button\" target=\"_blank\">" + $view_folders + "</a></td></tr>";
            $("#results > tbody").append($row);
        }
        $('.state-results').show();
    }
}
