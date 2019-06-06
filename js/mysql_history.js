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
                    $('.history').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    $('#button_history_tzrkpok, #button_history_tzrknam, #button_history, #button_history_trade, #button_history_seller').removeClass('pushed');
                    $('.history_kpok, .history_knam, .history, .history_trade, .history_seller').hide();
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
                    $('.history_knam').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    $('#button_history_tzrkpok, #button_history_tzrknam, #button_history, #button_history_trade, #button_history_seller').removeClass('pushed');
                    $('.history_kpok, .history_knam, .history, .history_trade, .history_seller').hide();
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
                    $('.history_kpok').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    $('#button_history_tzrkpok, #button_history_tzrknam, #button_history, #button_history_trade, #button_history_seller').removeClass('pushed');
                    $('.history_kpok, .history_knam, .history, .history_trade, .history_seller').hide();
                    $('.history_kpok').toggle();
                    $(event.target).toggleClass('pushed');
                }
            }
        });
    });

    //Показываем базе товар, чтобы посмотреть, от кого и почем возили
    $(document).off('click.give_hist_trade').on('click.give_hist_trade', '#button_history_trade', function (event) {
        var trade = $('#trade').attr('trade_id');
        $.ajax({
            url: 'mysql_history.php',
            method: 'POST',
            data: {post_trade_hist:trade},
            success: function(data){
                $('.history_trade').html(data);
            },complete:function () {
                if($('.history_trade:visible').length > 0){
                    $('.history_trade').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    $('#button_history_tzrkpok, #button_history_tzrknam, #button_history, #button_history_trade, #button_history_seller').removeClass('pushed');
                    $('.history_kpok, .history_knam, .history, .history_trade, .history_seller').hide();
                    $('.history_trade').toggle();
                    $(event.target).toggleClass('pushed');
                }
            }
        });
    });
    //Показываем базе поставщика, чтобы посмотреть, что от него вообще возили
    $(document).off('click.give_hist_seller').on('click.give_hist_seller', '#button_history_seller', function (event) {
        var seller = $('#seller').attr('seller_id');
        $.ajax({
            url: 'mysql_history.php',
            method: 'POST',
            data: {post_seller_hist:seller},
            success: function(data){
                $('.history_seller').html(data);
            },complete:function () {
                if($('.history_seller:visible').length > 0){
                    $('.history_seller').hide();
                    $(event.target).toggleClass('pushed');
                }else{
                    $('#button_history_tzrkpok, #button_history_tzrknam, #button_history, #button_history_trade, #button_history_seller').removeClass('pushed');
                    $('.history_kpok, .history_knam, .history, .history_trade, .history_seller').hide();
                    $('.history_seller').toggle();
                    $(event.target).toggleClass('pushed');
                }
            }
        });
    });


    $(document).off('click.enlarge').on('click.enlarge', '.button_enlarge', function (event) {
        $(event.target).parent('[class*="history"]').toggleClass('enlarged');
    })








});

