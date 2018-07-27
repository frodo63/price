$(document).ready(function(){

    $(document).off('click.give_hist').on('click.give_hist', '#button_history', function () {
        var trade = $(event.target).attr('hist_trade');
        var byer = $(event.target).attr('hist_byer');
        $.ajax({
            url: 'mysql_history.php',
            method: 'POST',
            data: {post_byersid:byer, post_tradeid:trade},
            success: function(data){
                $('.history').html(data);
            }
        });
    });







});

