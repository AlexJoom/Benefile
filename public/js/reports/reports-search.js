$(document).ready(function(){

    // on form submit get the search parameters to pass them via ajax
    $("#search-form").on("submit", function(){
        var $url = $(this).attr('action');
        var $marital_status_id = $("#marital-status-id :selected").val();
        var $age = $("input[name='age']").val();
        var $legal_status_id = $("#legal-status-id :selected").val();
        var $education_id = $("#education-id :selected").val();
        var $gender_id = $("input:radio[name='gender_id']:checked").val() == "undefined" ? "" : $("input:radio[name='gender_id']:checked").val();
        var $work_title_id = $("#work-title-id :selected").val();
        var $drug = $("input[name='drug']").val();
        var $incident_type_id = $("#incident-type-id :selected").val();
        var $location_id = $("#location-id :selected").val();
        var $doctor_name = $("input[name='doctor_name']").val();
        var $incidents_number = $("input[name='incidents_number']").val();
        var $examination_results_id = $("#examination-results-id :selected").val();
        var $insertion_date = $("input[name='insertion_date']").val();
        var $incident_from = $("input[name='incident_from']").val();
        var $incident_to = $("input[name='incident_to']").val();
        var $temp = {
            'marital_status_id': $marital_status_id,
            'age': $age,
            'legal_status_id': $legal_status_id,
            'education_id': $education_id,
            'gender_id': $gender_id,
            'work_title_id': $work_title_id,
            'drug': $drug,
            'incident_type_id': $incident_type_id,
            'location_id': $location_id,
            'doctor_name': $doctor_name,
            'incidents_number': $incidents_number,
            'examination_results_id': $examination_results_id,
            'insertion_date': $insertion_date,
            'incident_from': $incident_from,
            'incident_to': $incident_to
        };
        MakeAjaxBenefiterSearchCall($url, $temp);
        return false;
    });

});

// make the ajax call to get a response
function MakeAjaxBenefiterSearchCall($url, $values){
    $.ajax({
        url: $url,
        type: 'get',
        data: $values,
        beforeSend: function () {
            // start loader
        },
        success: function() {
            // display results
        },
        error: function() {
            // display error msg
        },
        complete: function() {
            // stop loader
        }
    });
}
