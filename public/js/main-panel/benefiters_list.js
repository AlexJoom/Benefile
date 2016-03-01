$(document).ready(function(){
    // display modal asking for benefiter deletion confirmation
    $(".delete-benefiter").on("click", function(e){
        $("#delete-benefiter-modal").modal('show');
        $(".delete-benefiter-form").attr("action", $(this).data("url"));
    });
});
