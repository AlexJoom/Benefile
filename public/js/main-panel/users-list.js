/**
 * Created by cdimitzas on 9/2/2016.
 */


// USERS BUTTON ON SIDEBAR
//$('#users-list a').click(function() {
//    $.ajax({
//        url: $(this).attr("href"),
//        type: 'GET'
//    })
//        .done(function( data ) {
//            console.log( data );
//            $("#main-window").html(data);

            // Changes background color to menu buttons on click
            $(function(){
                if (!$('#users-list').hasClass("purple-background")) {
                    $("li.purple-background").removeClass("purple-background");
                    $('#users-list').addClass("purple-background");
                }
            });

            // ACTION TABS
            $('.col-md-4.userStatus div').click(function(){
                if(!$(this).hasClass('pink-border-bottom white bold')){
                    $('.col-md-4.userStatus div').removeClass('pink-border-bottom white bold');
                    $(this).addClass('pink-border-bottom white bold');
                }
            });

            // Apply dataTable
            $(function() {
                $('#usersTable-to-activate').DataTable( {
                    "lengthMenu": [ [-1], ["All"] ]
                } );

                $('#usersTable-active').DataTable( {
                    "lengthMenu": [ [-1], ["All"] ]
                } );

                $('#usersTable-deactivated').DataTable( {
                    "lengthMenu": [ [-1], ["All"] ]
                } );
            });

            $('#results-to-activate').show();
            $('#results-active').hide();
            $('#results-deactiveted').hide();

            $('div#to-activate').click(function(){
                if(!$(this).hasClass('active')){
                    $('.col-md-4.userStatus div').removeClass('active');
                    $(this).addClass('active');
                    $('#results-to-activate').show();
                    $('#results-active').hide();
                    $('#results-deactiveted').hide();
                }
            });

            $('div#active').click(function(){
                if(!$(this).hasClass('active')){
                    $('.col-md-4.userStatus div').removeClass('active');
                    $(this).addClass('active');
                    $('#results-to-activate').hide();
                    $('#results-active').show();
                    $('#results-deactiveted').hide();
                }
            });

            $('div#inactive').click(function(){
                if(!$(this).hasClass('active')){
                    $('.col-md-4.userStatus div').removeClass('active');
                    $(this).addClass('active');
                    $('#results-to-activate').hide();
                    $('#results-active').hide();
                    $('#results-deactiveted').show();
                }
            });
//        });
//    return false;
//});


