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
        var $medical_location_id = $("#medical-location-id :selected").val();
        var $marital_status_id = $("#marital-status-id :selected").val();
        var $age = $("input[name='age']").val();
        var $legal_status_id = $("#legal-status-id :selected").val();
        var $education_id = $("#education-id :selected").val();
        var $work_title_id = $("#work-title-id :selected").val();
        var $drug = $("input[name='drug']").val();
        var $incident_type_id = $("#incident-type-id :selected").val();
        var $doctor_name = $("input[name='doctor_name']").val();
        var $incidents_number = $("input[name='incidents_number']").val();
        var $examination_results_id = $("#examination-results-id :selected").val();
        var $insertion_date = $("input[name='insertion_date']").val();
        var $incident_from = $("input[name='incident_from']").val();
        var $incident_to = $("input[name='incident_to']").val();
        var $temp = {'folder_number': $folder_number,
                'lastname': $lastname,
                'fname': $name,
                'fathers_name': $fathers_name,
                'gender_id': $gender_id,
                'telephone': $telephone,
                'birth_date': $birth_date,
                'origin_country': $origin_country,
                'medical_location_id': $medical_location_id,
                'marital_status_id': $marital_status_id,
                'age': $.trim($age),
                'legal_status_id': $legal_status_id,
                'education_id': $education_id,
                'work_title_id': $work_title_id,
                'drug': $.trim($drug),
                'incident_type_id': $incident_type_id,
                'doctor_name': $.trim($doctor_name),
                'incidents_number': $.trim($incidents_number),
                'examination_results_id': $examination_results_id,
                'insertion_date': $insertion_date,
                'incident_from': $incident_from,
                'incident_to': $incident_to
            };
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

    $('#download-link').on("click", function(){
        var csv = '';
        var $table = $("#results");
        $table.find('thead > tr > th.printable').each(function (i, row) {
            csv += '"' + $(row).text().trim().replace(/\s+/g, ' ') + '"' + '\t';
        });
        csv = csv.substring(0, csv.length - 1) + "\n";

        var $rows = $table.find('tr'),
        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0),
        // actual delimiter characters for CSV format
            colDelim = '\t',
            rowDelim = '\r\n';
        // Grab text from table into CSV formatted string
        csv += $rows.map(function (i, row) {
            var $row = $(row),
                $cols = $row.find('td.printable');

            return $cols.map(function (j, col) {
                var $col = $(col),
                    text = $col.text();
                text = text.replace(/\s+/g, ' ');
                return '"' + text.replace('"', ' ') + '"'; // escape double quotes
            }).get().join(tmpColDelim);
        }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim);// + '"';


        if (window.GetIEVersion() > 0) {
            var oWin = window.open();
            oWin.document.write(csv);
            oWin.document.close();
            oWin.document.execCommand('SaveAs', true, "export.csv");
            oWin.close();
            return false;
        }
        else {
            // Data URI
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

            // get date and time in nice format for file naming
            $today = GetCurrentDateNicelyFormattedForCSVFileNaming();

            $(this)
                .attr({
                    'download': $today + "_Benefile_export.csv",
                    'href': csvData,
                    'target': '_blank'
                });
        }
    });
});

// make the ajax call to get a response
function MakeAjaxSearchCall($url, $values){
    var $loader;
    $.ajax({
        url: $url,
        type: 'get',
        data: $values,
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

var $no = $(".benefiters-search").data("no-lang");
var $yes = $(".benefiters-search").data("yes-lang");

// show the results returned from the ajax call
function DisplayResults($response){
    // if nothing is returned, display "No results found" message
    if($response == ''){
        $('.state-no-results').show();
    } else { // else display results returned
        $view_folders = $('#search-results').data('view-folders');
        for (var i in $response) {
            $anchor = $('#search-results').data('url').replace('-1', $response[i].id);
            $response[i].language_interpreter_needed = GetYesOrNoTextFromId($response[i].language_interpreter_needed);
            $response[i].is_benefiter_working = GetYesOrNoTextFromId($response[i].is_benefiter_working);
            $row = "<tr><td class=\"printable\">" + $response[i].folder_number + "</td><td class=\"printable\">" + GetEmptyStringIfValueIsNull($response[i].name) + "</td><td class=\"printable\">" + GetEmptyStringIfValueIsNull($response[i].lastname) + "</td><td class=\"printable\">" + GetEmptyStringIfValueIsNull($response[i].telephone) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].fathers_name) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].mothers_name) + "</td><td class=\"hide printable\">" + FormatDateCorrectly($response[i].birth_date) + "</td><td class=\"hide printable\">" + FormatDateCorrectly($response[i].arrival_date) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].address) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].number_of_children) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].relatives_residence) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].language_interpreter_needed) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].is_benefiter_working) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].country_abandon_reason) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].travel_route) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].travel_duration) + "</td><td class=\"hide printable\">" + FormatDateCorrectly($response[i].detention_date) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].origin_country) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].nationality_country) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].ethnic_group) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].social_history) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].marital_status_title) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].education_title) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].legal_working_status) + "</td><td class=\"hide printable\">" + GetEmptyStringIfValueIsNull($response[i].work_title) + "</td><td><a href=\"" + $anchor + "\" class=\"simple-button\" target=\"_blank\">" + $view_folders + "</a></td></tr>";
            $("#results > tbody").append($row);
        }
        $('.state-results').show();
    }
}

// gets binary and returns yes or no
function GetYesOrNoTextFromId($binary){
    if ($binary == "0"){
        return $no;
    } else {
        return $yes;
    }
}

function GetIEVersion(){
    var sAgent = window.navigator.userAgent;
    var Idx = sAgent.indexOf("MSIE");

    // If IE, return version number.
    if (Idx > 0)
        return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));

    // If IE 11 then look for Updated user agent string.
    else if (!!navigator.userAgent.match(/Trident\/7\./))
        return 11;

    else
        return 0; //It is not IE
}

// do not display the word null in csv, just show empty string
function GetEmptyStringIfValueIsNull($str){
    if(!$str){
        return '';
    } else {
        return $str;
    }
}

// change date format from yyyy/mm/dd to dd/mm/yyyy
function FormatDateCorrectly($date){
    if($date == "0000-00-00" || !$date){
        return '';
    } else {
        $tmp = $date.split("-");
        return $tmp[2] + "-" + $tmp[1] + "-" + $tmp[0];
    }
}

// gets date in nice format for csv file name
function GetCurrentDateNicelyFormattedForCSVFileNaming(){
    var $today = new Date();
    var $day = $today.getDate();
    if ($day < 10){
        $day = '0' + $day;
    }
    var $month = $today.getMonth();
    if ($month < 10){
        $month = '0' + $month;
    }
    var $year = $today.getFullYear();
    var $hours = $today.getHours();
    var $minutes = $today.getMinutes();
    var $seconds = $today.getSeconds();
    return $year + "-" + $month + "-" + $day + "_" + $hours + "_" + $minutes + "_" + $seconds;
}
