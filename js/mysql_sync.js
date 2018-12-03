$(document).ready(function(){


    //ЗАказы
    $(document).off('click.sync').on('click.sync', '#sync_requests, #sync_payments, #sync_byers, #sync_sellers, #sync_trades', function(event){
        var sync_file = ($(event.target).attr("id")).substring(5);
        console.log(sync_file);
        $.ajax({
            url: 'mysql_sync.php',
            method: 'POST',
            data: {sync_file:sync_file},
            success: function (data) {
                $('#sync_info').html(data);
            }
        });
    });




});