$(document).ready(function(){

    // on download csv form submit get the data and send them via ajax
    $('#download-csv-form').on('submit', function(){
        MakeCSVFromBenefiterIdsAndDownloadIt($(this).attr('action'), $('#benefiters-found-ids'));
        return false;
    });

});

// gets a string with comma separated benefiter ids, makes an ajax call and receives a downloadable .csv file
function MakeCSVFromBenefiterIdsAndDownloadIt($url, $ids){
    $.ajax({
        url: $url,
        type: 'get',
        data: $ids,
        success: function($response){
            alert($response);
        }
    });
}
