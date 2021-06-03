$(document).ready(function() {

    $(".social button").click(function(event){
        var screenWidth = $(window).width();
        if (screenWidth > 980){
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).text()).select();
            document.execCommand("copy");
            $temp.remove();
            $('.social').append('<div class="alert_number">НОМЕР СКОПИРОВАН</div>');
            $('.alert_number').delay( 2000 ).fadeOut( 400 );
        }else{
            switch($(event.target).attr('app')) {
                case 'viber':
                    $('.social').append('<div class="alert_number"><a href="viber://chat?number=+79090768993">Viber</a></div>');
                    break;

                case 'whatsapp':
                    $('.social').append('<div class="alert_number"><a href="whatsapp://send?phone=+79090768993">WhatsApp</a></div>');
                    break;
            }
        }
    });

    /*СКРЫВАНИЕ ДИВА creates по нажатию на плюсик*/
    $(document).off('click.addnew').on('click.addnew', '.addnew', function (event) {
        $(event.target).next('.creates').toggle().toggleClass('add_ramk');
    });

    /*СКРЫВАНИЕ дива дополнения позиции*/
    $(document).off('click.add_pos_ramk').on('click.add_pos_ramk', '.add_pos', function (event) {
        $(event.target).next('.add-pos-inputs').toggle().toggleClass('add_ramk');
        $(event.target).next('.add_ramk').children('input[type="text"]').focus();

    });
    /**/

//Удаление строки из таблицы. id строки берется из атрибута ('name') input'a/////////////////////////////////////
//Имя талицы берется из атрибута id родителя нажатого инпута с тегом id//////////////////////////////////////////
    $(document).off('click.itemdel').on('click.itemdel', '.delete', function (event) {
        var delid = $(event.target).attr("name");
        var deltable = $(event.target).parents("div").attr("class").slice(0, -5);
        var deltablenameid = deltable+'_nameid';
        if (confirm("Удалить саму запись из базы данных ? Может, вы хотите просто переименовать? Тогда кликайте \"Отмена\".")) {
            $.ajax({
                url: 'mysql_delete.php',
                method: 'POST',
                data: {delid:delid, deltable:deltable, deltablenameid:deltablenameid},
                success: function(){
                    $('#editmsg').css("display", "block"). delay(100).slideUp(100).html("Запись "+ delid +" из таблицы " + deltable + " удалена.");
                },
                complete: function() {
                    $("a[href = \"#" + deltable + "\"]").trigger("click");
                }
            });
        } else { alert("Аккуратнее, блин! Чуть не удалил... Понадобится еще.") }
        return true;
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Удаление заявки из таблицы requests. id заявки берется из
    $(document).off('click.reqdel').on('click.reqdel', '.reqdelete', function (event) {
        /*$('.reqdelete').off().click(function () {*/
        var delrequestid = $(event.target).attr("requestid"); //id заявки
        var delnameid = $(event.target).attr("nameid"); //nameid заявки
        var db = $(event.target).parents('tr[database]').attr('database');

        if (confirm("Удалить саму запись из базы данных ? Может, вы хотите просто переименовать? Тогда кликайте \"Отмена\".")) {
            console.log(delrequestid);
            console.log(delnameid);
            //Значит в allnames ничего нет, надо прост удалить запись из requests
            if(typeof delnameid === 'undefined'){
                $.ajax({
                    url: 'mysql_delete.php',
                    method: 'POST',
                    data: {delrequestid_no_nameid:delrequestid, db:db},
                    success: function(){
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Заявка без названия"+ delrequestid +" удалена.");
                    },
                    complete: function() {
                        $("#requests input.show_list").trigger("click");
                    }
                });
            }else{
                //Удаляем как положено, с названием из обеих таблиц
                $.ajax({
                    url: 'mysql_delete.php',
                    method: 'POST',
                    data: {delrequestid:delrequestid, delnameid:delnameid, db:db},
                    success: function(){
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Заявка "+ delrequestid +" удалена.");
                    },
                    complete: function() {
                        $("#requests input.show_list").trigger("click");
                    }
                });
            }

        } else { alert("Аккуратнее, блин! Чуть не удалил... Понадобится еще.") }
        return true;
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Удаление позиции из заявки. id позиции берется из кнопки
    $(document).off('click.posdel').on('click.posdel', 'input.posdelete', function (event) {
        var delpositionid = $(event.target).attr("position"); //id позиции
        var reqid = $(event.target).parents('tr[requestid]').attr('requestid');
        var db = $(event.target).parents('tr[database]').attr('database');
        if (confirm("Удалить запись ?")) {
            $.ajax({
                url: 'mysql_delete.php',
                method: 'POST',
                data: {delpositionid:delpositionid, db:db},
                success: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Позиция "+ delpositionid +" удалена.");
                },
                complete: function() {
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {requestid:reqid, db:db},
                        success: function (data) {
                            $('input[requestid='+reqid+'] ~ div div.positions').html(data);
                        }
                    });
                }
            });
        } else { alert("Аккуратнее, блин! Чуть не удалил... Понадобится еще.") }
        return true;
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Удаление расценки из позиции. id берется из атрибута pricing таргета.
    $(document).off('click.prsdel').on('click.prsdel', '.delpricing', function (event) {
        /*$('.delpricing').off().click(function () {*/
        var delpricingid = $(event.target).attr("pricing"); //id расценки
        var delposid = $(event.target).parents("tr[position]").attr('position'); //id позиции
        var db = $(event.target).parents('tr[database]').attr('database');
        if (confirm("Удалить расценку ?")) {
            $.ajax({
                url: 'mysql_delete.php',
                method: 'POST',
                data: {delpricingid:delpricingid, db:db},
                success: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Расценка "+ delpricingid +" удалена.");
                },
                complete: function() {
                    console.log(delposid);
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {positionid:delposid, db:db},
                        success: function (data) {
                            $('input[position='+delposid+'] ~ div.pricings').html(data);
                        }
                    });
                }
            });
        } else { alert("Фух... Понадобится еще.") }
        return true;
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Удаление платежки из позиции. id берется из атрибута таргета.
    $(document).off('click.paydel').on('click.paydel', '.delpayment', function (event) {
        var delpaymentid = $(event.target).attr("pay_id"); //id расценки
        var delpaymentrequest = $(event.target).attr("req_id"); //id расценки
        console.log(delpaymentid+" "+delpaymentrequest);
        if (confirm("Удалить платежку ?")) {
            $.ajax({
                url: 'mysql_delete.php',
                method: 'POST',
                data: {delpaymentid:delpaymentid},
                success: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Платежка "+ delpaymentid +" удалена.");
                },
                complete: function() {
                    $.ajax({
                        url: 'mysql_giveaways.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {the_request:delpaymentrequest},
                        success: function (data) {
                            $('.ga_contents[ga_request='+delpaymentrequest+'] .ga_c_payments').html(data.data1);
                            $('.ga_contents[ga_request='+delpaymentrequest+'] .ga_c_positions').html(data.data2);
                            $('.ga_contents[ga_request='+delpaymentrequest+'] .ga_c_giveaways').html(data.data3);
                        }
                    });
                }
            });
        } else { alert("Фух... Понадобится еще.") }
        return true;
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //Удаление реализации из позиции. id берется из атрибута таргета.
    $(document).off('click.execdel').on('click.execdel', '.delexecute', function (event) {
        return false;
        /*var delpaymentid = $(event.target).attr("pay_id"); //id расценки
        var delpaymentrequest = $(event.target).attr("req_id"); //id расценки
        console.log(delpaymentid+" "+delpaymentrequest);
        if (confirm("Удалить платежку ?")) {
            $.ajax({
                url: 'mysql_delete.php',
                method: 'POST',
                data: {delpaymentid:delpaymentid},
                success: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Платежка "+ delpaymentid +" удалена.");
                },
                complete: function() {
                    $.ajax({
                        url: 'mysql_giveaways.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {the_request:delpaymentrequest},
                        success: function (data) {
                            $('.ga_contents[ga_request='+delpaymentrequest+'] .ga_c_payments').html(data.data1);
                            $('.ga_contents[ga_request='+delpaymentrequest+'] .ga_c_positions').html(data.data2);
                            $('.ga_contents[ga_request='+delpaymentrequest+'] .ga_c_giveaways').html(data.data3);
                        }
                    });
                }
            });
        } else { alert("Фух... Понадобится еще.") }
        return true;
    */});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Удаление выдачи из позиции. id берется из атрибута таргета.
    $(document).off('click.givedel').on('click.givedel', '.delgiveaway', function (event) {
        var delgiveawayid = $(event.target).attr("give_id"); //id расценки
        var delgiveawayrequest = $(event.target).attr("req_id"); //id расценки
        if (confirm("Удалить выдачу ?")) {
            $.ajax({
                url: 'mysql_delete.php',
                method: 'POST',
                data: {delgiveawayid:delgiveawayid},
                success: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Выдача "+ delgiveawayrequest +" удалена.");
                },
                complete: function() {
                    $.ajax({
                        url: 'mysql_giveaways.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {the_request:delgiveawayrequest},
                        success: function (data) {
                            $('.ga_contents[ga_request='+delgiveawayrequest+'] .ga_c_payments').html(data.data1);
                            $('.ga_contents[ga_request='+delgiveawayrequest+'] .ga_c_positions').html(data.data2);
                            $('.ga_contents[ga_request='+delgiveawayrequest+'] .ga_c_giveaways').html(data.data3);
                        }
                    });
                }
            });
        } else { alert("Фух... Понадобится еще.") }
        return true;
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//Добавление позиции в таблицу positions
    $(document).off('click.ap').on('click.ap', 'input[type=button].addpos', function(event){
//Добавление позиции из окна синхронизации
        if(
            $(event.target).parents('#sync_add_to_base').length > 0
        ){
            var reqid = $(event.target).attr('requestid');
            var posname = $(event.target).attr('posname');general_oils_motor
            var linenum = $(event.target).attr('linenum');
            var db = $(event.target).attr('database');

            console.log(reqid+'*'+posname+'*'+db+'*'+linenum);

            if(posname!=''){
                console.log('Аякс на добавление позиции из окна синхронизаии');
                $.ajax({
                    url: 'mysql_insert.php',
                    method: 'POST',
                    data: {
                        sync_reqid:reqid,
                        sync_posname:posname,
                        sync_linenum:linenum,
                        db:db
                    },
                    success: function (data) {
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                        //Тут надо обновить только изменившуюся позицию, а не весь файл
                        //$('#sync_positions').trigger("click");
                        //Поэтому мы не триггерим клик, а отправляем на mysql_sync.php requestid
                        $.ajax({
                            url: 'mysql_sync.php',
                            method: 'POST',
                            data: {synched_request:reqid, db:db},
                            success: function (data) {
                                $('li[rid='+reqid+']').html(data);
                                switch(db){
                                    case 'ip':
                                        var pos_table_name = 'ip_positions';
                                        break;
                                    case 'ltk':
                                        var pos_table_name = 'positions';
                                        break;
                                }
                                $.ajax({
                                    url: 'mysql_sync.php',
                                    method: 'POST',
                                    data: {sync_html:pos_table_name,db:db},
                                    success: function (data) {
                                        $('#sync_add_to_base').html(data);
                                    }
                                });
                            }
                        });
                    }
                });
            } else {alert("Введите имя позиции")}

        }else{//Добавление позиции из списка заявок
            var reqid = $(event.target).attr("name");
            var posname = $(event.target).siblings('input[type="text"]').val();
            var db = $(event.target).attr('database');
            console.log(reqid+''+posname+''+db);
            if(posname!=''){
                console.log('Аякс на добавление позиции из списка заявок');
                $.ajax({
                    url: 'mysql_insert.php',
                    method: 'POST',
                    data: {reqid:reqid, posname:posname, db:db},
                    success: function (data) {
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                        $('td input[type=\'text\']').val('');
                    }, complete: function () {
                        $.ajax({
                            url: 'mysql_read.php',
                            method: 'POST',
                            data: {requestid:reqid},
                            success: function (data) {
                                $('input[requestid='+reqid+'] ~ div div.positions').html(data);
                                $(event.target).siblings('input[type="text"]').focus();
                            }
                        });
                    }
                });
            } else {alert("Введите имя позиции")}
        }
    });


//Чтение заявки. Айди берется из инпута плюса///////////////////////////////////////////////////////////////////////
    $(document).off('click.collapse').on('click.collapse', 'input.collapse', function(event){
        var rid = $(event.target).attr('requestid');
        var thetab = $('#reads li.ui-state-active').attr('id').substr(4);
        var db = $(event.target).parents('tr[database]').attr('database');

        //Если есть открытая заявка, надо сначала ее закрыть
        if($('div.contents:visible').length > 0){

            if ($(event.target).val() == 'X'){//Закрываем открытое
                $(event.target).siblings('.req_executals, .req_paymentals').css({'display' : 'none'});//Кнопки ТОРГ-12 и ₽
                $(event.target).val('♢').css({'background' : 'white', 'color' : 'black'}).siblings('div div.positions').html('');
                $(event.target).siblings('div.contents').slideUp(400);
                $('.'+thetab+'_list').removeClass('shrinken');
                $(event.target).parent().removeClass('widen');
                $('tr[requestid='+rid+'] .rentcount').html('');//По закрытию чистим расчет рентабельности
                return false;
            }
            //Закрываем старое
            $('.req_executals, .req_paymentals').css({'display' : 'none'});//Кнопки ТОРГ-12 и ₽
            $('input.collapse[value = "X"]').css('background', 'white');
            $('input.collapse[value = "X"]').css('color', 'black');
            $('input.collapse[value = "X"] ~ div div.positions').html('');
            $('input.collapse[value = "X"]').siblings('div.contents').slideUp(400);
            $('input.collapse[value = "X"]').val('♢');
            $('.'+thetab+'_list').removeClass('shrinken');
            $(event.target).parent().removeClass('widen');
            $('tr[requestid='+rid+'] .rentcount').html('');//По закрытию чистим расчет рентабельности

            //Открываем новое
            $(event.target).val('X');
            $(event.target).css('background', 'red');
            $(event.target).css('color', 'white');
            $(event.target).siblings('div.contents').slideDown(400);
            $(event.target).siblings('.req_executals, .req_paymentals').css({'display' : 'block'});//Кнопки ТОРГ-12 и ₽
            $('.'+thetab+'_list').addClass('shrinken');//Сужаем другие столбцы
            $(event.target).parent().addClass('widen');//Расширяем окно заявки

            $.ajax({
                url: 'mysql_read.php',
                method: 'POST',
                data: {requestid:rid, db:db},
                success: function (data) {
                    $('input[requestid='+rid+'] ~ div div.positions').html(data);
                },
                complete: function(){
                    $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Содержимое заявки ' + rid + ' из базы ' + db + ' получено.');
                }
            });

            /*Скроллимся к только что открытой завяке*/
            $('html, body').animate({
                scrollTop: $(".widen").offset().top
            }, 1000);
            /**/

        }else{
            //Просто открываем новое
            $(event.target).siblings('div').slideDown(400);
            $(event.target).css({'background' : 'red', 'color' : 'white'});
            $(event.target).val('X');
            $('.'+thetab+'_list').addClass('shrinken');//Сужаем другие столбцы
            $(event.target).parent().addClass('widen');//Расширяем окно заявки
            $(event.target).siblings('.req_executals, .req_paymentals').css({'display' : 'block'});//Кнопки ТОРГ-12 и ₽

            $.ajax({
                url: 'mysql_read.php',
                method: 'POST',
                data: {requestid:rid, db:db},
                success: function (data) {
                    $('input[requestid='+rid+'] ~ div div.positions').html(data);
                },
                complete: function(){
                    $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Содержимое заявки ' + rid + ' получено.');
                }
            });

            /*Скроллимся к только что открытой завяке*/
            $('html, body').animate({
                scrollTop: $(".widen").offset().top
            }, 1000);
            /**/
        }
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Чтение позиции. Строится список расценок. Айди берется из инпута плюса////////////////////////////////////////////
    $(document).off('click.collapsepos').on('click.collapsepos', 'input.collapsepos', function(event){
        var positionid = $(event.target).attr('position');
        var requestid = $(event.target).attr('request');
        var db = $(event.target).parents('tr[database]').attr('database');

        switch ($(event.target).siblings('div.pricings').css('display')){

            case 'none':
                $('td[position="'+positionid+'"] div.pricings').slideUp();
                $('div.pricings').slideUp();
                $('input.collapsepos').val('♢').css({'background-color': 'white', 'color': 'black'});

                $(event.target).siblings('div.pricings').slideDown();
                $.ajax({
                    url: 'mysql_read.php',
                    method: 'POST',
                    data: {positionid:positionid, db:db},
                    success: function (data) {
                        $('input[position='+positionid+'] ~ div.pricings').html(data);
                    },
                    complete: function(){
                        $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Содержимое позиции ' + positionid + ' получено.');
                    }
                });
                $(event.target).val('>').css('background-color', 'green');
                $(event.target).css('color', 'white');
                /*Затуманивание всей заявки и растуманивание только этой позиции*/
                //$('tr[requestid='+requestid+'] tr[position]').css('opacity', 0.2);
                //$('tr[requestid='+requestid+'] tr[position='+positionid+']').css('opacity', 1);
                /**/

                break;

            case 'block':
                $('td[position="'+positionid+'"] div.pricings').slideUp();
                $(event.target).siblings('div.pricings').slideUp();
                $('input[position='+positionid+'] ~ div').html('');
                $(event.target).val('♢').css('background-color', 'white');
                $(event.target).css('color', 'black');
                /*Растуманивание всей заявки*/
                //$('tr[requestid='+requestid+'] tr[position]').css('opacity', 1);
                /**/
                break;
        }
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Добавление расценки.
//Расширение дива///////////////////////////////////////////////////////////////////////////////////////////////////
    /*Добавление расценки Всплывающее окно прайсинговой рыбы*/
    $(document).off('click.addpricing').on('click.addpricing', 'input.addpricing', function(event){
        var reqid = $(event.target).parents('tr[requestid]').attr('requestid');
        var posid = $(event.target).attr('positionid');
        var byerid = $(event.target).parents('tr[byerid]').attr('byerid');
        var byername = $('tr[requestid="'+reqid+'"] td[byerid] span').text();
        var num = $('.req_header_'+reqid+ ' span.1c_num').text();
        var created = $('.req_header_'+reqid+ ' span.date').text();

        var db = $(event.target).parents('tr[database]').attr('database');
        console.log(db);

        $('#pricingwindow').slideDown().attr({ positionid:posid, byerid:byerid, requestid:reqid, database:db });
        $('#trade').attr('trade_id', '').val('');
        $('#seller').attr('seller_id', '').val('');
        $('#button_history').attr('hist_byer', byerid);//Добавляем идентификатор ПОкупателя в инпут по истории
        console.log(byername);
        $('#byer_name').text(byername);
        $('#nds_result, #nds_zak, #nds_to_pay').text('');
        $('#byer_name').text(byername);
        $('#byer_name').text(byername);
        $('#request_info').text('Заказ № '+num+' от '+created);

        //Запрос в базу за опциями покупателя
        //Проверка на QUEEN
        $.ajax({
            url: 'mysql_options.php',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {name_and_queen:posid, db:db},
            success: function (data) {
                var queen = data.queen;
                console.log(queen+" "+typeof queen);
                if(queen == '1'){
                    console.log('Из позиции');
                    $.ajax({//БЕРЕМ ИЗ ПОЗИЦИИ
                        url: 'mysql_options.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {pos_options:posid, db:db},
                        success: function(data){
                            $('#op').val(data.op);
                            $('#tp').val(data.tp);
                            $('#firstobp').val(data.firstobp);
                            $('#wtime').val(data.wt);
                        }
                    });
                }else if(queen == null){
                    console.log('Из заявки');
                    $.ajax({//БЕРЕМ ИЗ ЗАЯВКИ
                        url: 'mysql_options.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {req_options:reqid, db:db},
                        success: function(data){
                            $('#op').val(data.op);
                            $('#tp').val(data.tp);
                            $('#firstobp').val(data.firstobp);
                            $('#wtime').val(data.wt);
                        }
                    });
                }
            }
        });
        //АЯКС на информацию покупателя
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {byerid_info:byerid, db:db},
            success: function (data) {
                $('#byer_info').html(data);
            }
        });

        //АЯКС на товар-победитель
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {winner_trade:posid, db:db},
            success: function (data) {
                var json = $.parseJSON(data);
                $('#trade').attr({trade_id: json.data1, tare: json.data3}).val(json.data2);
                $('#button_history').attr('hist_trade', json.data1);
                $('#button_exec_trade_history').attr('hist_trade', json.data1);
            }
        });

        //АЯКС на список накладных
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {executes_list:reqid, db:db},
            success: function (data) {
                $('#executes_list').html(data);
            }
        });

        window.scrollTo(0, 0);
    });

//Закрытие расценки.
    $(document).off('click.closepricing').on('click.closepricing', 'input.closepricing', function(event){
        var posid = $('#pricingwindow').attr('positionid');
        var prcid = $('#pricingwindow').attr('pricingid');
        console.log(posid);
        console.log(prcid);


        if(posid != '-'){
            var theId = $('input.addpricing[positionid=' + posid + ']');
        }else{
            var theId = $('input.editpricing[pricing='+prcid+']');
        };

        //Очищаем окно расценки
        $('#trade').attr({trade_id: '', tare:''}).val('');
        $('#seller').attr('seller_id', '').val('');
        $('#button_history').attr({hist_byer: '-', hist_trade: '-'});
        $('#button_exec_trade_history').attr({hist_trade: '-'});
        $('#pricingwindow input[type="number"]').val('');
        $('#pricingwindow input[type="text"]').text('');
        $('#cases p,#obtzr,#tzr,#obtzrknam,#obtzrkpok,#rent h1,#tpr,#opr,#firstoh,#clearp,#marge,#margek,#realop,#realtp,#oh,#wtr,#wtimeday,#firstobpr,#clearpnar').text('');
        $('#pricingwindow').attr({positionid: '-', pricingid: '-', preditposid:'-', byerid:'-', requestid:'-', database:'-'});
        $('#byer_name').text('');
        $('.history').html('');
        $('.history_knam').html('');
        $('.history_kpok').html('');
        $('#byer_info').html('');
        $('#executes_list').html('');
        $('#request_info').text('');
        $('#nds_result, #nds_zak, #nds_to_pay').text('');
        $('#button_history_tzrkpok, #button_history_tzrknam, #button_history, #button_history_trade, #button_history_seller, #button_history_transports').removeClass('pushed');
        $('.history_kpok, .history_knam, .history, .history_trade, .history_seller, .history_transports').hide();



        /*Скроллимся к только что открытой завяке*/
        /*Надо понять, откуда была открыта расценка. То есть, из заявок или из результатов поиска, или из Р-1*/
        /*К счастью, открытую табу выдает класс 'ui-state-active'*/
        /*Проверяем, у какой табы есть клас 'ui-state-active' и туда скроллимся. ХЗ правда куда пристегиваться*/
        var thetab = $('#reads li.ui-state-active').attr('id').substr(4);
        console.log(thetab);

        if (thetab == 'giveaways'){
                $('html, body').animate({scrollTop: $('.byer_req_list .ga_widen').offset().top}, 1000);
        }



        if($('#' + thetab + ' .widen').length == 0)
        {
            $('html, body').animate({scrollTop: $('#' + thetab).offset().top}, 1000);
        }else
        {
            $('html, body').animate({scrollTop: $('#' + thetab + ' .widen').offset().top}, 1000);
        }
        //Сделать условие скролла и открытия для выдач (Р-1)
    });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*ЧТЕНИЕ/ИЗМЕНЕНИЕ РАСЦЕНКИ*/
    $(document).off('click.editpricing').on('click.editpricing', '.editpricing', function(event){
        var reqid = $(event.target).parents('tr[requestid]').attr('requestid');
        var posid = $(event.target).parents('tr[position]').attr('position');
        var prid = $(event.target).attr('pricing');
        var seller = $(event.target).parents('td').siblings('.pr-seller-name').text();
        var trade = $(event.target).parents('td').siblings('.pr-trade-name').text();
        var tare = $(event.target).parents('td').siblings('.pr-trade-name').attr('tare');
        var byerid = $(event.target).parents('tr[byerid]').attr('byerid');
        var byername = $('tr[requestid="'+reqid+'"] td[byerid] span').text();

        var db = $(event.target).parents('tr[database]').attr('database');
        //console.log(db);

        //Если эдитпрайсинг открывается из окна Р-1, переменные берутся из другого места
        if($(event.target).parents('.ga_contents').length>0){
            reqid = $(event.target).parents('.ga_contents').attr('ga_request');
            prid = $(event.target).attr('pricing');
            posid = $(event.target).attr('position');
            byerid = $('td.ga_widen > input[ga_request]').attr('byerid');
            byername = $('.byer_req_list li[byerid='+byerid+'] span.name').text();
            trade = $(event.target).siblings('.ga_trade').text();
            tare = $(event.target).siblings('.ga_trade').attr('tare');
            seller = $(event.target).siblings('.ga_seller').text();

            //ПОлучаем правильное значение byers_id.ТАк как в Р-1 в li[byerid] указан byerid из базы ЛТК,
            //в случае, если у нас db = ip, надо дополнительно менять этот byerid

        }
        window.scrollTo(0, 0);
        $('#pricingwindow').slideDown(200);
        if($(event.target).parents('#reads')){
        //console.log('Мы в общем списке заявок, надо бы скрыть Результаты поиска');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Очищаем окно расценки
        $('#trade').attr({trade_id: '', tare:''}).val('');
        $('#seller').attr('seller_id', '').val('');
        $('#button_history').attr({hist_byer: '-', hist_trade: '-'});
        $('#button_exec_trade_history').attr({hist_trade: '-'});
        $('#pricingwindow input[type="number"]').val('');
        $('#pricingwindow input[type="text"]').text('');
        $('#cases p,#obtzr,#tzr,#obtzrknam,#obtzrkpok,#rent h1,#tpr,#opr,#firstoh,#clearp,#marge,#margek,#realop,#realtp,#oh,#wtr,#wtimeday,#firstobpr,#clearpnar').text('');
        $('#pricingwindow').attr({positionid: '-', pricingid: '-', preditposid:'-', byerid:'-', requestid:'-', database:'-'});
        $('#byer_name').text('');
        $('#nds_result, #nds_zak, #nds_to_pay').text('');
        $('.history').html('');
        $('.history_knam').html('');
        $('.history_kpok').html('');
        $('.history_exec_trade').html('');
        $('#byer_info').html('');
        $('#executes_list').html('');
        $('#request_info').text('');

        /*Вставим прайсингайди в прайсингвиндоу ПРОБНОЕ!!!*/
        $('#pricingwindow').attr({pricingid: prid, byerid:byerid, preditposid:posid, requestid:reqid, database:db});
        //console.log(byername);
        $('#byer_name').text(byername);
        /**/

        //АЯКС на едитпрайсинг
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {pricingid:prid, db:db},
            success: function (data) {
            var json = $.parseJSON(data);
            /*ШАПКА*/
            $('#trade').attr({trade_id : json.tradeid, tare : tare}).val(trade);
            $('#seller').attr('seller_id', json.sellerid).val(seller);
            $('#button_history').attr('hist_trade', json.tradeid);//Добавляем идентификатор Товара в инпут по истории
            $('#button_exec_trade_history').attr('hist_trade', json.tradeid);//Добавляем идентификатор Товара в инпут по истории
            $('#request_info').text('Заказ № '+json.num+' от '+json.created);

            $('#zak').val(json.zak);
            $('#kol').val(json.kol);
            $('#tzr').text(json.tzr);
            $('#tzrknam').val(json.tzrknam);
            $('#tzrkpok').val(json.tzrkpok);
            $('#wtime').val(json.wtime);
            $('#wtimeday').text(json.wtimeday);
            $('#wtr').text(json.wtr);

            $('#nds_result').text(json.nds_result);
            $('#nds_zak').text(json.nds_zak);
            $('#nds_to_pay').text(json.nds_to_pay);


            /*ЦЕНА и РЕНТАБЕЛЬНОСТЬ*/
            $('#pr').val(Number(Number(json.price).toFixed(3)));
            $('#rent h1').text(Number(Number(json.rent).toFixed(2)));
            //Косметика
            $('#fixate').removeClass('active').attr('value', 'Закрепить');
            $('#pr').css({'font-weight': "normal", 'border': '2px solid white'});
            $('#go').slideUp().animate({top:'10vh', right:'1vw'}).slideDown();
            $('#fcount').css('opacity', '1');
            $('#cases').slideUp();
            $('#margediv').slideUp();
            $('#rop, #rtp').val("");
            $('#realop, #realtp').text("");
            //Косметика
            $('#op').val(json.op);
            $('#tp').val(json.tp);
            $('#firstobp').val(json.firstobp);
            $('#opr').text(json.opr);
            $('#tpr').text(json.tpr);
            $('#firstoh').val(json.firstoh);
            $('#clearp').text(json.clearp);
            },/*История*/
            complete: function(){
                $('#button_history').attr('hist_byer', byerid);//Добавляем идентификатор Покупателя в инпут по истории
                //Проверка на QUEEN
                $.ajax({
                    url: 'mysql_options.php',
                    method: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: {name_and_queen:posid, db:db},
                    success: function (data) {
                        var queen = data.queen;
                        //console.log(queen+" "+typeof queen);
                        if(queen == "1"){
                            $.ajax({//БЕРЕМ ИЗ ПОЗИЦИИ
                                url: 'mysql_options.php',
                                method: 'POST',
                                dataType: 'json',
                                cache: false,
                                data: {pos_options:posid, db:db},
                                success: function(data){
                                    $('#op').val(data.op);
                                    $('#tp').val(data.tp);
                                    $('#firstobp').val(data.firstobp);
                                    $('#wtime').val(data.wt);
                                    }
                            });
                        }else if(queen == null){
                            //console.log('queen has just almost killed this pricing, but i saved it!');
                        }
                    }
                });
                /*Выводим сообщение о том что расценка выгружена*/
                $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Расценка ' + prid + ' выгружена.');
            }
        });

        //АЯКС на информацию покупателя
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {byerid_info:byerid, db:db},
            success: function (data) {
                $('#byer_info').html(data);
            }
        });

        //АЯКС на список накладных
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {executes_list:reqid, db:db},
            success: function (data) {
                $('#executes_list').html(data);
            }
        });
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*Переименование позиции*/
//По клику на кнопку "Переименовать":
    $(document).off('click.rename').on('click.rename', '.edit', function (event) {
        var db = $(event.target).parents('tr[database]').attr('database');
        event.stopImmediatePropagation();
        //Все переменные берутся сразу
        var nameID = $(event.target).attr('position');
        var theTd = $('tr[position="'+nameID+'"] td[category="positions"]');
        var nameOld = theTd.children('span.name').text();


        if ($('#theinput').length == 1 && $('#theinput').attr('name')!= nameID) { //Если нажато Переименовать при уже открытом зэинпуте на другом элементе:
            var nameRealOld = $('#theinput').attr('placeholder');//Перед удалением берем из зэинпута плейсхолдер для старого имени и неймайди для селекта на след круге старого тп
            var nameIDold = $('#theinput').attr('name');
            $('#theinput').attr('placeholder', '');
            console.log(nameRealOld);
            console.log(nameIDold);

            /*Проверяем соответствующие инпуты на наличие класса savename*/
            if($('.savename')){$('.savename').addClass('edit').removeClass('savename').val('R')};
            $('#theinput').remove();
            $('tr[position="'+nameIDold+'"] td[category="positions"] span.name').text(nameRealOld);

        }

        theTd.children('span.name').text(''); //спан опустошается
        theTd.children('input:first').after($('<textarea rows="2" name="' + nameID + '" id="theinput" value="' + nameOld + '" placeholder="' + nameOld + '" ></textarea>'));

        $('#theinput').focus().select();
    });


//Чтобы можно было кликать на зэинпут без схлопываний
    $(document).off('click.theinput').on('click.theinput', '#theinput', function (event) {
        console.log("Клик на зэинпут без схлопываний");
        event.stopImmediatePropagation();
        event.preventDefault();
    });
//Чтобы зэинпут скрывался, когда кликаешь мимо ++Если у соответствующейго инпут баттона класс - сайвнейм - меняем вал и класс на эдит
    $(document).off('click.thebody').on('click.thebody', 'body', function (event) {
        if ($('#theinput').length > 0){

            console.log("чтобы зэинпут скрывался если клик мимо");
            var nameRealOld = $('#theinput').attr('placeholder');//Из плейсхолдера зэинпута берется старое (первоначальное) имя
            var nameIDold = $('#theinput').attr('name');//Из атрибута нейм зэинпута берется неймайди

            /*Выносим условие возвращения кнопки сейвнейм взад на общий уровень*/
            /*Проверяем соответствующие инпуты на наличие класса savename*/
            if($('.savename')){$('.savename').addClass('edit').removeClass('savename').val('R')};

            if ($('#theinput').parents('tr[requestid]').length > 0 && $('#theinput').parents('tr[position]').length == 0){
                console.log('Переименовывается заявка');
                $('#theinput').remove();
                $('td[name="'+nameIDold+'"]').children('input').after($('<span class="name">' + nameRealOld + '</span>'));

            }else if ($('#theinput').parents('tr[position]').length > 0){
                console.log('Переименовывается позиция');
                $('#theinput').after($('<span class="name">' + nameRealOld + '</span>'));
                $('#theinput').remove();

            }else {
                console.log('Переименовывается итем');
                $('#theinput').after('<span class="name">' + nameRealOld + '</span>');
                $('#theinput').remove();
            };
        };
    });
//Чтобы сохранение запускалось, только если имя действительно было изменено
    $(document).off('keyup.theinput').on('keyup.theinput', '#theinput', function (event) {
        event.stopImmediatePropagation();
        if($('#theinput').val() != $('#theinput').attr('placeholder')){

            if($('#theinput').parent().attr('category')=='positions'){
                console.log('Введено новое название позиции');
                //Добавляем кнопку .savename
                $('#theinput').parent().siblings('td:last').children('input.edit').val('Save').removeClass('edit').addClass('savename');
                //Аяксом добавляем скрипт для кнопки .savename
                if($('.savename').attr('loaded') != 0){
                    $.ajax({
                        url: "js/savename_ajax.js",
                        dataType: "script",
                        cache: true,
                        success: function() {
                            console.log('savename_ajax.js loaded successfully.');
                            $('.savename').attr('loaded', '0');
                        }
                    });
                };
            }else if($('#theinput').parent().attr('category')=='requests'){
                console.log('Введено новое название заявки');
                //Добавляем кнопку .savename
                $('#theinput').parent().siblings('td:last').children('input.edit').val('Save').removeClass('edit').addClass('savename');
                //Аяксом добавляем скрипт для кнопки .savename
                if($('.savename').attr('loaded') != 0){
                    $.ajax({
                        url: "js/savename_ajax.js",
                        dataType: "script",
                        cache: true,
                        success: function() {
                            console.log('savename_ajax.js loaded successfully.');
                            $('.savename').attr('loaded', '0');
                        }
                    });
                };
            }else if ($('#theinput').parent().attr('category')=='byers') {
                console.log('Введено новое название покупателя');
                $('input.edit[type="button"][name="'+$('#theinput').attr('name')+'"][value="R"]').val('Save').removeClass('edit').addClass('savename');
                if($('.savename').attr('loaded') != 0){
                    $.ajax({
                        url: "js/savename_ajax.js",
                        dataType: "script",
                        cache: true,
                        success: function() {
                            console.log('savename_ajax.js loaded successfully.');
                            $('.savename').attr('loaded', '0');
                        }
                    });
                };
            }else if ($('#theinput').parent().attr('category')=='sellers') {
                console.log('Введено новое название поставщика');
                $('input.edit[type="button"][name="'+$('#theinput').attr('name')+'"][value="R"]').val('Save').removeClass('edit').addClass('savename');
                if($('.savename').attr('loaded') != 0){
                    $.ajax({
                        url: "js/savename_ajax.js",
                        dataType: "script",
                        cache: true,
                        success: function() {
                            console.log('savename_ajax.js loaded successfully.');
                            $('.savename').attr('loaded', '0');
                        }
                    });
                };
            }else if ($('#theinput').parent().attr('category')=='trades') {
                console.log('Введено новое название товара');
                $('input.edit[type="button"][name="'+$('#theinput').attr('name')+'"][value="R"]').val('Save').removeClass('edit').addClass('savename');
                if($('.savename').attr('loaded') != 0){
                    $.ajax({
                        url: "js/savename_ajax.js",
                        dataType: "script",
                        cache: true,
                        success: function() {
                            console.log('savename_ajax.js loaded successfully.');
                            $('.savename').attr('loaded', '0');
                        }
                    });
                };
            };

        } else {
            console.log('равны');
            $('input.savename[type="button"][name="'+$('#theinput').attr('name')+'"][value="Save"]').val('R').removeClass('savename').addClass('edit');
        };
    });
//Добавление ЛУЗЕРА И ВИННЕРА
    $(document).off('click.losewin').on('click.losewin', '.winner', function (event) {
        var winid = $(event.target).attr('pricing'); // ID расценки, где нажато было
        var posid = $(event.target).parents('tr[position]').attr('position'); // ID позиции, где выбирается победитель
        var reqid = $(event.target).parents('tr[requestid]').attr('requestid'); //ID заявки, где есть позиция, где выбирается победитель

        var db = $(event.target).parents('tr[database]').attr('database');
        console.log(db);

        console.log("winid: "+winid+" , posid: "+posid+", reqid: "+reqid+", db: "+db);

        //Если Победитель выбран, мы щелкаем по "П" и победитель убирается.
        if($('tr[pricingid='+winid+']').hasClass('win')){
            /*Отменяем победителя*/
            console.log('это виннер, делаем лузера');
            console.log(winid+" , "+posid);
            $.ajax({//на мскл_рент отправлется минус_винайди и посайди
                url: 'mysql_rent.php',
                method: 'POST',
                data: {minus_winid:winid, posid:posid, db:db},
                success: function(){//По успеху - обновляется позиция
                    /*Чтение*/
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {positionid:posid, db:db},
                        success: function (data) {
                            $('input[position='+posid+']~div.pricings').html(data);
                        },
                        complete: function(){
                            $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Победитель отменен.');
                            $(event.target).val('*');
                            /*В самом конце, обновляем табличку полученными данными, чтобы не делать дополнительных запросов*/
                            $('tr[position='+posid+']>td.winname').text('');//Очищаем поле Победитель (Имя)
                            $('tr[position='+posid+']>td.rent').text('');//Очищаем поле Рентабельность (Число)
                            $('tr[position='+posid+']>td.pr').text('');//Очищаем поле Рентабельность (Число)
                        }
                    });
                },
                complete: function() {//И по комплиту происходит расчет общей рентабельности.
                    //На мускл_рент отправляется каунт и реквестайди
                    $.ajax({
                        url: 'mysql_rent.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {request:reqid, db:db},
                        success: function (data) {
                            $('tr[requestid='+reqid+'] .rentcount').html(data.data1);
                            $('tr[requestid='+reqid+'] .rent_whole').html(data.data2);
                            $('tr[requestid='+reqid+'] .sum_whole').html(data.data3);
                            $('h3.req_header_'+reqid+' .reqsumma').html(data.data3);
                        }
                    });

                }//Вводим измененные данные в таблицу
            });

        }else{
            console.log('это лузер, делаем виннера');
            console.log("Победитель: "+winid+" ,","Позиция: "+posid+" ,","Заявка: "+reqid+" .");
            /*Делаем победителя*/
            $.ajax({
                url: 'mysql_rent.php',
                method: 'POST',
                dataType: 'json',
                cache: false,
                data: {plus_winid:winid, posid:posid, db:db},
                success: function(data){
                    $('tr[position='+posid+']>td.winname').html(data.data1);//Вставить имя Победителя (Имя)
                    $('tr[position='+posid+']>td.pr').html(data.data2);//Вставить имя Победителя (Имя)
                    $('tr[position='+posid+']>td.rent').html(data.data3);//Вставить имя Победителя (Имя)
                    /*Чтение*/
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {positionid:posid, db:db},
                        success: function (data1) {
                            $('input[position='+posid+'] ~ div.pricings').html(data1);
                        },
                        complete: function(){
                            $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Победитель назначен.');
                            $(event.target).val('П');
                        }
                    });

                },
                complete: function() {//И по комплиту происходит расчет рентабельности.
                    //На мускл_рент отправляется каунт и реквестайди
                    $.ajax({
                        url: 'mysql_rent.php',
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        data: {request:reqid, db:db},
                        success: function (data) {
                            $('tr[requestid='+reqid+'] .rentcount').html(data.data1);
                            $('tr[requestid='+reqid+'] .rent_whole').html(data.data2);
                            $('tr[requestid='+reqid+'] .sum_whole').html(data.data3);
                            $('h3.req_header_'+reqid+' .reqsumma').html(data.data3);
                        }
                    });

                }//Вводим измененные данные в таблицу
            });

        }/*Сделали победителя и пересчитали рентабельность*/


    });
    /*РАСЧЕТ РЕНТАБЕЛЬНОСТИ по КНОПКЕ ВНУТРИ ЗАЯВКИ*/
    $(document).off('click.check_rent').on('click.check_rent', '.check_rent', function (event) {
        var reqid = $(event.target).attr('requestid'); //ID заявки, где есть позиция, где выбирается победитель
        var db = $(event.target).parents('tr[database]').attr('database');

        $.ajax({
            url: 'mysql_rent.php',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {request:reqid, db:db},
            success: function (data) {
                $('tr[requestid='+reqid+'] .rentcount').toggle().html(data.data1);
                $('tr[requestid='+reqid+'] .rent_whole').html(data.data2);
                $('tr[requestid='+reqid+'] .sum_whole').html(data.data3);
                $('h3.req_header_'+reqid+' .reqsumma').html(data.data3);
            }
        });

    });
    /**/

    $(document).off('click.count_rent_whole_byer').on('click.count_rent_whole_byer', '.count_rent_whole_byer', function (event) {
        var thebyer = $(event.target).attr('byer');
        $('.ga_byer_requests[ga_byer='+thebyer+'] tr[ga_request]').each(function () {
            var therequest = $(this).attr('ga_request');
            var db = $(this).attr('database');
            $.ajax({
                url: 'mysql_rent.php',
                method: 'POST',
                dataType: 'json',
                cache: false,
                data: {request:therequest, db:db},
                success: function (data) {
                    $('.ga_byer_requests[ga_byer='+thebyer+'] tr[ga_request='+therequest+'] td.sum_req_r1').html(data.data3);
                    $('.ga_byer_requests[ga_byer='+thebyer+'] tr[ga_request='+therequest+'] td.count_req_r1').html(data.data4);
                    console.log('Суммы заявок и суммы начислений обновлены');
                    //$('tr[requestid='+reqid+'] .rentcount').toggle().html(data.data1);
                    //$('tr[requestid='+reqid+'] .rent_whole').html(data.data2);
                    //$('h3.req_header_'+reqid+' .reqsumma').html(data.data3);
                }
            });
        })
    });



});



















