/**
 * Created by cdimitzas on 5/2/2016.
 */

$('div#sidebar').css({'height':($('.table-row.height-100per').height())+'px'});

$('#register-benefiter').click(function(){
    $('#new-benefiter').toggleClass('hide');
    $('#import-file').toggleClass('hide');
    $('button.buttonMenu.no-padding i').toggleClass('glyphicon-chevron-down');
});


$('#menu ul li').click(function(){
    if (!$(this).hasClass("purple-background")) {
        $("li.purple-background").removeClass("purple-background");
        $(this).addClass("purple-background");
    }
});


//------------------  AJAX VIEWS  ----------------------------------//

// USERS
$('#users-list a').click(function() {
    $.ajax({
        url: $(this).attr("href"),
        type: 'GET'
    })
        .done(function( data ) {
            console.log( data );
            $("#main-window").html(data);
            // Changes background color to menu buttons on click
            $(function(){
                if (!$('#users-list').hasClass("purple-background")) {
                    $("li.purple-background").removeClass("purple-background");
                    $('#users-list').addClass("purple-background");
                }
            });
            // Apply dataTable
            $(function() {
                $('#usersTable').DataTable( {
                    "lengthMenu": [ [-1], ["All"] ]
                } );
            });

            // Adjusts the height of the sidebar accordingly to the biggest screen height
            $(function(){
                var bodyHeight = $('body#main-layout').height() - $('div#header').height();
                var windowHeight = $('div#results-list').height() + $('div#actions').height();
                if(bodyHeight > windowHeight){
                    $('div#sidebar').css({'height': bodyHeight +'px'});
                }else{
                    $('div#sidebar').css({'height': windowHeight +'px'})
                }
            });

            $('.col-md-4.userStatus div').click(function(){
                if(!$(this).hasClass('pink-border-bottom')){
                    $('.col-md-4.userStatus div').removeClass('pink-border-bottom');
                    $(this).addClass('pink-border-bottom');
                }

            });


        });
    return false;
});



//------------------  END AJAX VIEWS  ----------------------------------//





