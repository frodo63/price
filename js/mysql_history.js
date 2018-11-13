$(document).ready(function(){

    //Показываем базе покупателя и товар, чтобы посмотреть старые цены
    $(document).off('click.give_hist_price').on('click.give_hist_price', '#button_history', function (event) {
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
                if($('.history:visible').length > 0){
                    console.log(1);
                    $('.history').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    console.log(2);
                    $('.history_kpok, .history_knam').hide();
                    $('.history').show();
                    $(event.target).toggleClass('pushed');
                }
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
                if($('.history_knam:visible').length > 0){
                    console.log(1);
                    $('.history_knam').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    console.log(2);
                    $('.history_kpok, .history').hide();
                    $('.history_knam').show();
                    $(event.target).toggleClass('pushed');
                }
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
                if($('.history_kpok:visible').length > 0){
                    console.log(1);
                    $('.history_kpok').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    console.log(2);
                    $('.history_kpok, .history_knam, .history').hide();
                    $('.history_kpok').toggle();
                    $(event.target).toggleClass('pushed');
                }
            }
        });
    });







});

