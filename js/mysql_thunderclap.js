$(document).ready(function() {

    //ЧТЕНИЕ Платежки и выдачи
    //Платежки
    $(document).off('click.comeeditpayment').on('click.comeeditpayment', '.editpayment', function (event) {
        var reqid = $(event.target).attr('req_id');
        var payid = $(event.target).attr('pay_id');
        $('#add_payment').toggleClass('come_here', 1000);
        console.log('Из большого скрипта');
        $('#add_payment input[name=1]').val('');//Стираем все данные
        $('#add_payment input[name=2]').val('');//Стираем все данные
        $('#add_payment input[name=3]').val('');//Стираем все данные

        $('#button_add_payment').attr('requestid',''+reqid+'');//Добавляем в кнопку
        $('#button_add_payment').attr('paymentid',''+payid+'');//Добавляем в кнопку

        //Аякс в базу для значений
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {pay_reqid:reqid,pay_id:payid},
            success: function (data) {
                $('#add_payment input[name=1]').val(data.payed);//Стираем все данные
                $('#add_payment input[name=2]').val(data.number);//Стираем все данные
                $('#add_payment input[name=3]').val(data.sum);//Стираем все данные
            }
        });

    });

    //Выдачи
    $(document).off('click.comeeditgiveaway').on('click.comeeditgiveaway', '.editgiveaway', function (event) {
        var byersid = $(event.target).attr('byersid');
        var giveid = $(event.target).attr('g_id');
        $('#add_giveaway').toggleClass('come_here', 1000);
        console.log('Из большого скрипта');
        $('#add_giveaway>input[name=1]').val('');//Стираем все данные
        $('#add_giveaway>input[name=2]').val('');//Стираем все данные
        $('#add_giveaway>input[name=3]').val('');//Стираем все данные
        $('#button_add_giveaway').attr('byersid',''+byersid+'');//Добавляем в кнопку
        $('#button_add_giveaway').attr('giveawayid',''+giveid+'');//Добавляем в кнопку

        //Аякс в базу для значений
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {byersid:byersid,give_id:giveid},
            success: function (data) {
                $('#add_giveaway input[name=1]').val(data.given_away);//Стираем все данные
                $('#add_giveaway input[name=2]').val(data.comment);//Стираем все данные
                $('#add_giveaway input[name=3]').val(data.giveaway_sum);//Стираем все данные
            }
        });
    });
});