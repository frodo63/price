$(document).ready(function(){

    //Показываем базе покупателя и товар, чтобы посмотреть старые цены
    $(document).off('click.give_hist_price').on('click.give_hist_price', '#button_history', function (event) {
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

    //Показываем базе поставщика и тару, чтобы посмотреть, почем возили к себе
    $(document).off('click.give_hist_knam').on('click.give_hist_knam', '#button_history_tzrknam', function (event) {
        var tare = $('#trade').attr('tare');
        var sellerid = $('#seller').attr('seller_id');
        console.log("tare: "+tare+" / seller: "+sellerid);
        $.ajax({
            url: 'mysql_history.php',
            method: 'POST',
            data: {post_seller:sellerid, post_tare:tare},
            success: function(data){
                $('.history_knam').html(data);
            },complete:function () {
                $('.history_knam').toggle();
            }
        });
    });

    //Показываем базе покупателя и тару, чтобы посмотреть, почем возили к покупателю
    $(document).off('click.give_hist_kpok').on('click.give_hist_kpok', '#button_history_tzrkpok', function (event) {
        var tare = $('#trade').attr('tare');
        var byerid = $('#pricingwindow').attr('byerid');
        console.log("tare: "+tare+" / byer: "+byerid);
        $.ajax({
            url: 'mysql_history.php',
            method: 'POST',
            data: {post_byer:byerid, post_tare:tare},
            success: function(data){
                $('.history_kpok').html(data);
            },complete:function () {
                $('.history_kpok').toggle();
            }
        });
    });







});

