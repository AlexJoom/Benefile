$(document).ready(function(){
    // slide toggle to add a new session
    $(".new-session").hide();
    $("#add-new-session").on("click", function(){
        $(".new-session").slideToggle("slow");
    });

    // slide toggle to edit a session
    $(".edit-session-div").hide();
    $(".edit-session").on("click", function(){
        $(this).parents(".div-table-row:first").next().slideToggle("slow");
    });

    // display modal asking for session deletion confirmation
    $(".delete-session").on("click", function(){
        $("#delete-session-modal").modal('show');
        $(".delete-session-form").attr("action", $(".delete-session-path").attr("value") + "/" + $(this).attr("name"));
    });
});
