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
        $.ajax({
            url: 'mysql_sync.php',
            method: 'POST',
            data: {sync_html:sync_file},
            success: function (data) {
                $('#sync_add_to_base').html(data);
            }
        });
    });


    //Проходы по списку:
    $(document).off('click.sync_list').on('click.sync_list', '#sync_info .sres li', function (event) {
        console.log('сработал клик на лист итеме');
        var category = $(event.target).parents('li').attr('category')+"s";
        switch (category){
            case 'byers':
                var theID = $(event.target).parents('li').attr('byers_id');
                break;
            case 'sellers':
                var theID = $(event.target).parents('li').attr('sellers_id');
                break;
            case 'trades':
                var theID = $(event.target).parents('li').attr('trades_id');
                break;
        }
        console.log(theID);
        console.log(category);
        $(event.target).parents('.sres').next('input.sync_to_base').attr({innerid:theID,table:category});
    })

    //Соотнесение по кнопке
    $(document).off('click.sync_to_base').on('click.sync_to_base', '.sync_to_base', function (event) {
        var innerid = $(event.target).attr('innerid');
        var uid = $(event.target).attr('uid');
        var onec_id = $(event.target).attr('onec_id');
        var table = $(event.target).attr('table');

        if(!innerid){
            console.log('innerid is undefined');
        }else{
            console.log(innerid);
            console.log(uid);
            console.log(onec_id);
            console.log(table);

            $.ajax({
                url: 'mysql_sync.php',
                method: 'POST',
                data: {innerid:innerid,uid:uid,table:table,onec_id:onec_id},
                success: function (data) {
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                    $('#sync_'+table).trigger("click");
                }
            });
        }
    });

/*Добавление в базу из окна СИНХРОНИЗАЦИИ*/
    $(document).off('click.syncaddnew').on('click.syncaddnew', '.sync_add_to_base', function(event){
        if ($('#sync_add_to_base').hasClass('up')){
            $('#sync_add_to_base').removeClass('up');
        };
        //$('#sync_add_to_base').toggleClass('up', 500);

        if($('#sinchronize_payments').length > 0){
            //Добавляем в форму добавления данные итема
        }

        if($('#sinchronize_trades').length > 0){
            var name = $(event.target).siblings('.sync_add_name').text();
            var uid = $(event.target).siblings('input[type="button"]').attr('uid');
            var dataver = $(event.target).siblings('input[type="button"]').attr('dataver');
            var onec_id = $(event.target).siblings('input[type="button"]').attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(dataver);
            console.log(onec_id);

            $('#sync_add_to_base .add_trade_name').val(name);
            $('#sync_add_to_base .add_trade_name').trigger('keyup.checkname');
            $('#sync_add_to_base input[type="button"]').attr('uid', uid);
            $('#sync_add_to_base input[type="button"]').attr('dataver', dataver);
            $('#sync_add_to_base input[type="button"]').attr('onec_id', onec_id);
            $('#sync_add_to_base input[type="button"]').prop( "disabled", false );
            $('#sync_add_to_base select').focus();


        }

        if($('#sinchronize_byers').length > 0){

            var name = $(event.target).siblings('.sync_add_name').text();
            var uid = $(event.target).siblings('input[type="button"]').attr('uid');
            var dataver = $(event.target).siblings('input[type="button"]').attr('dataver');
            var onec_id = $(event.target).siblings('input[type="button"]').attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(dataver);
            console.log(onec_id);

            $('#sync_add_to_base .add_byer_name').val(name);
            $('#sync_add_to_base .add_byer_name').trigger('keyup.checkname');
            $('#sync_add_to_base input[type="button"]').attr('uid', uid);
            $('#sync_add_to_base input[type="button"]').attr('dataver', dataver);
            $('#sync_add_to_base input[type="button"]').attr('onec_id', onec_id);
        }

        if($('#sinchronize_sellers').length > 0){

            var name = $(event.target).siblings('.sync_add_name').text();
            var uid = $(event.target).siblings('input[type="button"]').attr('uid');
            var dataver = $(event.target).siblings('input[type="button"]').attr('dataver');
            var onec_id = $(event.target).siblings('input[type="button"]').attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(dataver);
            console.log(onec_id);

            $('#sync_add_to_base .add_seller_name').val(name);
            $('#sync_add_to_base .add_seller_name').trigger('keyup.checkname');
            $('#sync_add_to_base input[type="button"]').attr('uid', uid);
            $('#sync_add_to_base input[type="button"]').attr('dataver', dataver);
            $('#sync_add_to_base input[type="button"]').attr('onec_id', onec_id);
        }
    });




});