$(document).ready(function(){

    $(document).off('click.give_hist').on('click.give_hist', '#button_history', function (event) {
        console.log('ujuj');
        var trade = $(event.target).attr('hist_trade');
        var byer = $(event.target).attr('hist_byer');
        var prid = $('#pricingwindow').attr('pricingid');
        console.log('trade: '+trade+', byer: '+byer+', pricing: '+prid)
        $.ajax({
            url: 'mysql_history.php',
            method: 'POST',
            data: {post_byersid:byer, post_tradeid:trade},
            success: function(data){
                $('.history').html(data);
            },complete:function () {
                $('.hystory-list tr[post_prid='+prid+']').addClass('current_pricing');
                $('.history').toggle();

            }
        });
    });







});

