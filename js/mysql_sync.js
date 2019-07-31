$(document).ready(function(){


    //Вывод содержания файлов
    $(document).off('click.sync').on('click.sync', '' +
        '#sync_requests, #sync_ip_requests,' +
        '#sync_payments, #sync_ip_payments,' +
        '#sync_executes, #sync_ip_executes,' +
        '#sync_byers, #sync_ip_byers,' +
        '#sync_sellers, #sync_ip_sellers,' +
        '#sync_trades, #sync_ip_trades,' +
        '#sync_positions, #sync_ip_positions,' +
        '#sync_purchases, #sync_ip_purchases,' +
        '#sync_transports, #sync_ip_transports', function(event){


        $('#sync_requests, #sync_ip_requests, #sync_payments, #sync_ip_payments, #sync_executes, #sync_ip_executes,' +
            '#sync_byers, #sync_ip_byers, #sync_sellers, #sync_ip_sellers, #sync_trades, #sync_ip_trades,' +
            '#sync_positions, #sync_ip_positions, #sync_purchases, #sync_ip_purchases,' +
            '#sync_transports, #sync_ip_transports').removeClass('green');
        $(event.target).addClass('green');

        var sync_file = ($(event.target).attr("id")).substring(5);
        var db = $(event.target).attr("database");
        console.log(sync_file);
        console.log(db);
        $.ajax({
            url: 'mysql_sync.php',
            method: 'POST',
            data: {sync_file:sync_file, db:db},
            success: function (data) {
                $('#sync_info').html(data);
            }
        });
        $.ajax({
            url: 'mysql_sync.php',
            method: 'POST',
            data: {sync_html:sync_file, db:db},
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
            case 'requests':
                var theID = $(event.target).parents('li').attr('requests_id');
                break;
            case 'payments':
                var theID = $(event.target).parents('li').attr('payments_id');
                break;
        }
        console.log(theID);
        console.log(category);
        $('input.sync_add_to_base').removeClass('green');
        $(event.target).parents('.sres').siblings('input.sync_add_to_base').attr({innerid:theID,table:category}).addClass('green');

    });

    //Соотнесение по кнопке
    $(document).off('click.sync_to_base').on('click.sync_to_base', '.sync_to_base', function (event) {
        var innerid = $(event.target).siblings('input[type=button]').attr('innerid');
        var uid = $(event.target).siblings('input[type=button]').attr('uid');
        var onec_id = $(event.target).siblings('input[type=button]').attr('onec_id');
        var table = $(event.target).attr('table');

        if(typeof innerid === 'undefined' || !innerid){
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

    //Заполнение формы для добавления в базу из окна СИНХРОНИЗАЦИИ
    $(document).off('click.syncaddnew').on('click.syncaddnew', '.sync_add_to_base', function(event){
        var add_name_text = $('#sync_add_to_base input[type="text"]');
        var add_select = $('#sync_add_to_base select');
        var add_button = $('#sync_add_to_base input[type="button"]')

        if($('#sinchronize_payments').length > 0 || $('#sinchronize_ip_payments').length > 0){

            var payed = $(event.target).attr('payed');
            var number = $(event.target).attr('number');
            var onec_id = $(event.target).attr('onec_id');
            var uid = $(event.target).attr('uid');
            var sum = $(event.target).attr('sum');
            var requestid = $(event.target).attr('requestid');

            console.log(payed);
            console.log(number);
            console.log(onec_id);
            console.log(uid);
            console.log(sum);
            console.log(requestid);

            if(requestid !='none' && requestid){

                if ($('#sync_add_to_base').hasClass('up')){
                    $('#sync_add_to_base').removeClass('up');
                }

                $('#sync_add_to_base .sync_pay_payed').text(payed);
                $('#sync_add_to_base .sync_pay_num').text(number);
                $('#sync_add_to_base .sync_pay_onec_id').text(onec_id);
                $('#sync_add_to_base .sync_pay_uid').text(uid);
                $('#sync_add_to_base .sync_pay_sum').text(sum);
                $('#sync_add_to_base .sync_pay_rid').text(requestid);
                add_button.attr({
                    payed:payed,
                    number:number,
                    onec_id:onec_id,
                    uid:uid,
                    sum:sum,
                    requestid:requestid
                });

                //Тут добавить условие, что кнопка становится доступной, только если заполнен атрибут requestid

                $('#sync_add_to_base input[type="button"]').prop( "disabled", false ).focus();
            }
        }
        if($('#sinchronize_requests').length > 0 || $('#sinchronize_ip_requests').length > 0){
            if ($('#sync_add_to_base').hasClass('up')){
                $('#sync_add_to_base').removeClass('up');
            }

        var created = $(event.target).attr('created');
        var uid = $(event.target).attr('uid');
        var bid = $(event.target).attr('byersid');
        var onec_id = $(event.target).attr('onec_id');

            console.log(created);
            console.log(uid);
            console.log(bid);
            console.log(onec_id);

            $('#sync_add_to_base .sync_req_created').text(created);
            $('#sync_add_to_base .sync_req_uid').text(uid);
            $('#sync_add_to_base .sync_req_byers_id').text(bid);
            $('#sync_add_to_base .sync_req_onec_id').text(onec_id);
            add_button.attr({
                created:created,
                uid:uid,
                bid:bid,
                onec_id:onec_id
            });
            $('#sync_add_to_base input[type="button"]').prop( "disabled", false ).focus();

        }
        if($('#sinchronize_positions').length > 0 || $('#sinchronize_ip_positions').length > 0){
            if ($('#sync_add_to_base').hasClass('up')){
                $('#sync_add_to_base').removeClass('up');
            }
            var posname = $(event.target).siblings('span.pn').text();
            var requestid = $(event.target).attr('requests_id');
            var linenum = $(event.target).attr('linenum');
            var price = $(event.target).attr('price');
            var kol = $(event.target).attr('kol');
            var tradeid = $(event.target).attr('tradeid');

            $('#sync_add_to_base .sync_pos_requestid').text(requestid);
            $('#sync_add_to_base .sync_pos_pos_name').text(posname);
            $('#sync_add_to_base .sync_pos_line_num').text(linenum);
            $('#sync_add_to_base .sync_pos_price').text(price);
            $('#sync_add_to_base .sync_pos_kol').text(kol);
            $('#sync_add_to_base .sync_pos_tradeid').text(tradeid);
            add_button.attr({
                posname:posname,
                requestid:requestid,
                linenum:linenum,
                price:price,
                kol:kol,
                tradeid:tradeid
            });
            $('#sync_add_to_base input[type="button"]').prop( "disabled", false ).focus();
        }
        if($('#sinchronize_trades').length > 0){
            if ($('#sync_add_to_base').hasClass('up')){
                $('#sync_add_to_base').removeClass('up');
            }
            var name = $(event.target).siblings('.sync_add_name').text();
            var uid = $(event.target).attr('uid');
            var onec_id = $(event.target).attr('onec_id');
            var innerid = $(event.target).attr('innerid');

            console.log(name);
            console.log(uid);
            console.log(onec_id);

            var add_trade_name = $('#sync_add_to_base .add_trade_name');

            add_trade_name.val(name);
            add_trade_name.trigger('keyup.checkname');
            add_button.attr({
                'uid': uid,
                'innerid': innerid,
                'onec_id': onec_id
            }).prop("disabled", false);
            add_select.focus();


        }
        if($('#sinchronize_byers').length > 0){
            if ($('#sync_add_to_base').hasClass('up')){
                $('#sync_add_to_base').removeClass('up');
            }

            name = $(event.target).siblings('.sync_add_name').text();
            uid = $(event.target).attr('uid');
            innerid = $(event.target).attr('innerid');
            onec_id = $(event.target).attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(innerid);
            console.log(onec_id);

            var add_byer_name = $('#sync_add_to_base .add_byer_name');

            add_byer_name.val(name);
            add_byer_name.trigger('keyup.checkname');
            add_button.attr({
                'uid': uid,
                'innerid': innerid,
                'onec_id': onec_id
            }).prop("disabled", false);
            add_name_text.focus();
        }
        if($('#sinchronize_sellers').length > 0){
            if ($('#sync_add_to_base').hasClass('up')){
                $('#sync_add_to_base').removeClass('up');
            }

            name = $(event.target).siblings('.sync_add_name').text();
            uid = $(event.target).attr('uid');
            innerid = $(event.target).attr('innerid');
            onec_id = $(event.target).attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(onec_id);

            var add_seller_name = $('#sync_add_to_base .add_seller_name');

            add_seller_name.val(name);
            add_seller_name.trigger('keyup.checkname');
            add_button.attr({
                uid:uid,
                onec_id:onec_id,
                innerid:innerid
            }).prop("disabled", false);
            add_name_text.focus();
        }
        if($('#sinchronize_ip_trades').length > 0){

            name = $(event.target).siblings('.sync_add_name').text();
            uid = $(event.target).attr('uid');
            innerid = $(event.target).attr('innerid');
            onec_id = $(event.target).attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(innerid);
            console.log(onec_id);

                if ($('#sync_add_to_base').hasClass('up')){
                    $('#sync_add_to_base').removeClass('up');
                }

            add_trade_name = $('#sync_add_to_base .add_trade_name');

            add_trade_name.val(name);
            add_trade_name.trigger('keyup.checkname');
            add_button.attr({
                'uid': uid,
                'innerid': innerid,
                'onec_id': onec_id
            }).prop("disabled", false);
            add_select.focus();

        }
        if($('#sinchronize_ip_byers').length > 0){

            name = $(event.target).siblings('.sync_add_name').text();
            uid = $(event.target).attr('uid');
            onec_id = $(event.target).attr('onec_id');
            innerid = $(event.target).attr('innerid');

            console.log(name);
            console.log(uid);
            console.log(onec_id);
            console.log(innerid);

                if ($('#sync_add_to_base').hasClass('up')){
                    $('#sync_add_to_base').removeClass('up');
                }

            add_byer_name = $('#sync_add_to_base .add_byer_name');

            add_byer_name.val(name);
            add_byer_name.trigger('keyup.checkname');
            add_button.attr({
                uid:uid,
                onec_id:onec_id,
                innerid:innerid
            }).prop("disabled", false);
            add_name_text.focus();

        }
        if($('#sinchronize_ip_sellers').length > 0){

            name = $(event.target).siblings('.sync_add_name').text();
            uid = $(event.target).attr('uid');
            innerid = $(event.target).attr('innerid');
            onec_id = $(event.target).attr('onec_id');

            console.log(name);
            console.log(uid);
            console.log(innerid);
            console.log(onec_id);

            if ($('#sync_add_to_base').hasClass('up')){
                $('#sync_add_to_base').removeClass('up');
            }

            add_seller_name = $('#sync_add_to_base .add_seller_name');

            add_seller_name.val(name);
            add_seller_name.trigger('keyup.checkname');
            add_button.attr({
                uid:uid,
                onec_id:onec_id,
                innerid:innerid
            }).prop("disabled", false);
            $('#sync_add_to_base input[type="text"]');
            add_name_text.focus();
        }
    });

    //Добавление в базу расценки из окна СИНХРОНИЗАЦИИ
    $(document).off('click.syncaddpricing').on('click.syncaddpricing', '.sync_addpricing', function(event){
        //Для добавления расценки нужно:

        var requestid = $(event.target).attr('requestid');
        var positionid = $(event.target).attr('req_positionid');
        var tradeid = $(event.target).attr('tradeid');
        var kol = $(event.target).attr('kol');
        var price = $(event.target).attr('price');
        var db = $(event.target).attr('database');


        //ЗАПРОС НА ОПЦИИ
        $.ajax({//БЕРЕМ ИЗ ЗАЯВКИ
            url: 'mysql_options.php',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {req_options:requestid, db:db},
            success: function(data){
                var op = data.op;
                var tp = data.tp;
                var firstobp = data.firstobp;
                var wt = data.wt;

                $.ajax({
                    url: 'mysql_insert.php',
                    method: 'POST',
                    data: {positionid:positionid, tradeid:tradeid, kol:kol, price:price, op:op, tp:tp, firstobp:firstobp, wt:wt, db:db},
                    success: function (data) {
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                        //Тут надо обновить только изменившуюся позицию, а не весь файл
                        //$('#sync_positions').trigger("click");
                        //Поэтому мы не триггерим клик, а отправляем на mysql_sync.php requestid
                        $.ajax({
                            url: 'mysql_sync.php',
                            method: 'POST',
                            data: {synched_request:requestid, db:db},
                            success: function (data) {
                                $('li[rid='+requestid+']').html(data);
                            }
                        });
                    }
                });
            }
        });
        //ЗАКОНЧИЛСЯ ЗАПРОС НА ОПЦИИ




    });


    //Добавление номеров позиции в базу ЕДИНИЧКИ
    /*$(document).off('click.add1s').on('click.add1s', '.add1s', function (event) {
        var dothe1s = 1;

        $.ajax({
            url: 'mysql_insert.php',
            method: 'POST',
            data: {dothe1s:dothe1s},
            success: function (data) {
                $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                $('#sync_positions').trigger("click");
            }
        });
    })*/


    //Добавление в позицию данных о поступлении и в поступление - данных о позиции
    $(document).off('click.add_pur').on('click.add.pur', '.attach_pur', function (event) {
        var date_to_attach = $(event.target).attr('date');
        var pur_id_to_attach = $(event.target).attr('pur_id');
        var db = $(event.target).attr('database');
        var dbprwindow = $('#pricingwindow').attr('database');
        var sellers_id = $(event.target).attr('sellerid');
        var pur_price = $(event.target).parents('td').siblings('.pur_price').text();
        var seller_name = $(event.target).parents('td').siblings('.pur_seller_name').text();

        console.log(sellers_id);
        console.log(pur_price);
        console.log(typeof(pur_price));
        console.log(seller_name);

        //Сравнить db  с db
        if(db == dbprwindow){
            console.log('База раценки и база закупки совпадают.');


            if($('#pricingwindow').attr('positionid') == '-'){
                var position_to_attach = $('#pricingwindow').attr('preditposid');
            }else{
                var position_to_attach = $('#pricingwindow').attr('positionid');
            }

            if(date_to_attach !='' && date_to_attach && pur_id_to_attach && pur_id_to_attach !=''){
                $.ajax({
                    url: 'mysql_sync.php',
                    method: 'POST',
                    data: {attach_pur_date:date_to_attach, attach_pur_id:pur_id_to_attach, position_to_attach:position_to_attach, db:db},
                    success: function (data) {
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);

                        //Добавить Цену закупа в zak
                        //Добавить Поставщика в seller
                        //В кнопке должно быть еще и sellerid, имя поставщика и закупочная цена

                        $('#seller').attr('seller_id', sellers_id);
                        $('#seller').val(seller_name);
                        $('#zak').val(parseFloat(pur_price.replace(' ', '')));

                        //отобразить изменившиеся данные
                        var trade = $('#trade').attr('trade_id');
                        if($('#pricingwindow').attr('preditposid') == '-'){
                            var posid = $('#pricingwindow').attr('positionid');
                        }else{
                            var posid = $('#pricingwindow').attr('preditposid');
                        }
                        $.ajax({
                            url: 'mysql_history.php',
                            method: 'POST',
                            data: {post_trade_hist: trade, trade_hist_posid: posid},
                            success: function (data) {
                                $('.history_trade').html(data);
                            }
                        });

                    }
                });
            }

        }else{
            console.log('База раценки и база закупки НЕ совпадают.')
            alert('Расценка - из базы '+dbprwindow+', а закупка - из базы '+db+'. Невозможно закрепить такое.')
        }



    });

    $(document).off('click.sh').on('click.sh', '.show_hide', function (event) {
        console.log('s_h clicked');
        $('.show_payments_list').hide();
        $(event.target).next('.show_payments_list').toggle();
    })
});