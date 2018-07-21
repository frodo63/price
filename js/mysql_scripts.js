$(document).ready(function(){

    //СОЗДАНИЕ ТАБОВ, ПОДКЛЮЧЕНИЕ К JQUERY_UI///////////////////////////////////////////////////////////////////////////
    $( function() {
        $( "#reads" ).tabs();
    } );
    $(document).off('click.rtoggle').on('click.rtoggle', '#readstoggle', function () {
        $('#reads').toggle();
    });
    $(document).off('click.rstoggle').on('click.rstoggle', '#req_searchstoggle', function () {
        $('#search_reads').toggle();
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    //ДОБАВЛЕНИЕ в Таблицу. Имя талицы берется из атрибута инпута ('name')//////////////////////////////////////////////
    $(document).off('click.addtab').on('click.addtab', '.creates input[type="button"]', function(event){
        //Добавляем заявку?
        if($(event.target).attr('name') == 'requests'){
            var byer = $('#byer').attr("byer_id");
            var thename = $('#req_name').val();

            console.log("Добавляем заявку");
            console.log(byer);
            console.log(thename);

            if(thename!='' && byer > 0){
                $.ajax({
                    url: 'mysql_insert.php',
                    method: 'POST',
                    data: {byer:byer, thename:thename},
                    success: function (data) {
                        console.log("Добавлена заявка");
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                        $('#creates input[type=\'text\']').val('');
                    }/*,
                    complete: function() {$('a[href = "#requests"]').trigger('click');
                    }*/
                });
            } else {alert("Чето вы не то ввели. Там же две графы всего, разве это так сложно?")}
        }else{
            var table = $(event.target).attr("name");
            var table_c = $(event.target).attr("tc");
            var thename = $(event.target).prev().val();
            var addinput = $(event.target).prev('input[type="text"]');
                    if(thename!=''){
                        $.ajax({
                            url: 'mysql_insert.php',
                            method: 'POST',
                            data: {table_c:table_c, thename:thename},
                            success: function (data) {
                                $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                                $('#creates input[type=\'text\']').val('');
                            },
                            complete: function() {
                                $("a[href = \"#" + table + "\"]").trigger("click");
                                addinput.focus();
                            }
                        });
                    } else {alert("Введите имя")};
        };
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Чтение таблицы. Имя табицы берется из атрибута li('href') и отрезанием первого символа #//////////////////////////
    $(document).off('click.readtab').on('click.readtab', '#reads li a', function(){

        var table = $(this).attr("href").substring(1);
            $.ajax({
                url: 'mysql_read.php',
                method: 'POST',
                data: {table:table},
                success: function (data) {
                   $('#reads .' + table + '_list').html(data);
                },
                complete: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Данные из таблицы " + table + " получены.");
                    $('.creates input[type=\'text\']').val('');
                    $('.from,.to').val('');
                }
            });
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Чтение списка заявок из фильтра по дате.//////////////////////////////////////////////////////////////////////////
    $(document).off('click.filter_date').on('click.filter_date', '#requests_date_range .filter_date', function(){
        var from = $('#requests_date_range .from').val();
        console.log(from);
        from = from.slice(6,10)+'-'+from.slice(3,5)+'-'+from.slice(0,2);
        console.log(from);

        var to = $('#requests_date_range .to').val();
        console.log(to);
        to = to.slice(6,10)+'-'+to.slice(3,5)+'-'+to.slice(0,2);
        console.log(to);

        if(from!='--' && to!='--'){
            $.ajax({
                url: 'mysql_read.php',
                method: 'POST',
                data: {table:'requests', from:from, to:to},
                success: function (data) {
                    $('#reads .requests_list').html(data);
                },
                complete: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Показаны заявки с "+from+" до " +to+ ".");
                    $('.creates input[type=\'text\']').val('');
                }
            });
        }else{
            alert("Введите обе точки временного диапазона.");
        };
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Чтение списка заявок из фильтра по дате ВО ВКЛАДКЕ ВЫДАЧ И РАСЧЕТОВ///////////////////////////////////////////////
    $(document).off('click.ga_filter_date').on('click.ga_filter_date', '.ga_requests_date_range .filter_date', function(event){
        var the_byer = $(event.target).parents('.ga_byer_requests').attr('ga_byer');
        var from = $(event.target).siblings('.from').val();
        from = from.slice(6,10)+'-'+from.slice(3,5)+'-'+from.slice(0,2);

        var to = $(event.target).siblings('.to').val();
        to = to.slice(6,10)+'-'+to.slice(3,5)+'-'+to.slice(0,2);

        console.log(the_byer);
        console.log(from);
        console.log(to);

        if(from!='--' && to!='--'){
            $.ajax({
                url: 'mysql_giveaways.php',
                method: 'POST',
                data: {from:from, to:to, the_byer:the_byer},
                success: function (data) {
                    $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                },
                complete: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Показаны заявки с "+from+" до " +to+ ".");
                    $('.from,.to').datepicker({
                        dateFormat: "dd-mm-yy",
                        showButtonPanel: true,
                        dayNames: [ "Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
                        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
                        dayNamesShort: [ "Вос", "Пон", "Втр", "Срд", "Чтв", "Пят", "Суб" ],
                        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Нов", "Дек" ]
                    });
                }
            });
        }else{
            alert("Введите обе точки временного диапазона.");
        };
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    /*СПИСОК ЗАЯВОК В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ////////////////////////////////////////////////////////////////////////*/
    $(document).off('click.ga_requests').on('click.ga_requests', '.collapse_ga_byer', function (event) {
        var the_byer = $(event.target).attr('ga_byer');

        if ($('.ga_byer_requests:visible').length > 0){
            if ($(event.target).val() == 'X'){//Закрываем открытое
                $(event.target).css({'background': 'white', 'color': 'black', 'font-size' : '1em'}).val('W');
                $(event.target).next('span').css({'font-size' : '1em'});
                $(event.target).siblings('.ga_byer_requests').slideUp();
                return false;//На закрытии скрипт останавливается
            }else {
                //Открываем новое
                $.ajax({
                    url: 'mysql_giveaways.php',
                    method: 'POST',
                    data: {the_byer:the_byer},
                    success: function (data) {
                        $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                        //Скрытие открытых
                        $('.ga_byer_requests:visible').slideUp();
                        //Расширение в высоту
                        $('.ga_byer_requests[ga_byer='+the_byer+']').slideDown()/*.addClass('ga_widen')*/;
                        $('input.collapse_ga_byer[value = "X"]').next('span').css({'font-size' : '1em'});
                        $('input.collapse_ga_byer[value = "X"]').css({'background': 'white', 'color': 'black','font-size' : '1em'}).val('W');
                        $(event.target).val('X').css({'background-color' : 'green','color' : 'white','font-size' : 30});
                        $(event.target).next('span').css({'font-size' : 30});
                    },complete:function () {//Подключение дейтпикера
                        $('.from,.to').datepicker({
                            dateFormat: "dd-mm-yy",
                            showButtonPanel: true,
                            dayNames: [ "Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
                            dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
                            dayNamesShort: [ "Вос", "Пон", "Втр", "Срд", "Чтв", "Пят", "Суб" ],
                            monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                            monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Нов", "Дек" ]
                        });
                        $('.from,.to').val('');
                    }
                });
            }

        }else{

            //Просто открываем новое
            $.ajax({
                url: 'mysql_giveaways.php',
                method: 'POST',
                data: {the_byer:the_byer},
                success: function (data) {
                    $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                    //Скрытие открытых
                    $('div.ga_byer_requests:visible').slideUp();
                    //Расширение в высоту
                    $('.ga_byer_requests[ga_byer='+the_byer+']').slideDown()/*.addClass('ga_widen')*/;
                    $(event.target).val('X').css({'background-color' : 'green','color' : 'white','font-size' : 30});
                    $(event.target).next('span').css({'font-size' : 30});
                },complete:function () {//Подключение дейтпикера
                    $('.from,.to').datepicker({
                        dateFormat: "dd-mm-yy",
                        showButtonPanel: true,
                        dayNames: [ "Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
                        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
                        dayNamesShort: [ "Вос", "Пон", "Втр", "Срд", "Чтв", "Пят", "Суб" ],
                        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Нов", "Дек" ]
                    });
                    $('.from,.to').val('');
                }
            });
        }
    });
    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*СПИСОК ПЛАТЕЖЕЙ, НАЧИСЛЕНИЙ И ВЫДАЧ В РАМКАХ ОДНОЙ ЗАЯВКИ///////////////////////////////////////////////////////*/
    $(document).off('click.ga_contents').on('click.ga_contents', '.collapse_ga_request', function (event) {
        var the_request = $(event.target).attr('ga_request');

        if($(event.target).val() == 'X'){//Закрываем просто
            $(event.target).parents('.ga_byer_requests').removeClass('shrinken');
            $(event.target).parent().removeClass('ga_widen');
            $(event.target).val('W').css({'background-color':'white','color':'black'});
            $('tr[ga_request]').not('tr[ga_request='+the_request+']').show();
            $('.ga_contents').hide();//Спрятали содержимое заявок
            return false;
        };

        $(event.target).parents('.ga_byer_requests').addClass('shrinken');
        $(event.target).parent().addClass('ga_widen');
        $(event.target).val('X').css({'background-color':'red','color':'white'});
        $('body').animate({scrollTop: $(event.target).offset.top});
        /*Прятание*/
        $('tr[ga_request]').not('tr[ga_request='+the_request+']').hide();
        $('.ga_contents[ga_request='+the_request+']').show();

        $.ajax({
            url: 'mysql_giveaways.php',
            method: 'POST',
            dataType: 'json',
            cache: false,
            data: {the_request:the_request},
            success: function (data) {
                $('.ga_contents[ga_request='+the_request+'] .ga_c_payments').html(data.data1);
                $('.ga_contents[ga_request='+the_request+'] .ga_c_positions').html(data.data2);
                $('.ga_contents[ga_request='+the_request+'] .ga_c_giveaways').html(data.data3);
                $('.ga_contents[ga_request='+the_request+'] .ga_options').html(data.data4);

            }
        });
    });
    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*ДОБАВЛЕНИЕ ПЛАТЕЖКИ/ВЫДАЧИ*///////////////////////////////////////////////////////////////////////////////////////
    /*ВЫЗОВ ОКНА ДОБАВЛЕНИЯ*////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.comepayment').on('click.comepayment', '.add_payment', function (event) {
        $('#add_payment').toggleClass('come_here', 1000);
        console.log('Из большого скрипта');
        $('#add_payment input[name=1]').val('');//Стираем все данные
        $('#add_payment input[name=2]').val('');//Стираем все данные
        $('#add_payment input[name=3]').val('');//Стираем все данные
        $('#add_payment input[name=4]').val('');//Стираем все данные
        $('#button_add_payment').attr('requestid',''+$(event.target).attr('requestid')+'');//Добавляем в кнопку
    });

    $(document).off('click.comegiveaway').on('click.comegiveaway', '.add_giveaway', function () {
        $('#add_giveaway').toggleClass('come_here', 1000);
        console.log('Из большого скрипта');
        $('#add_giveaway>input[name=1]').val('');//Стираем все данные
        $('#add_giveaway>input[name=2]').val('');//Стираем все данные
        $('#add_giveaway>input[name=3]').val('');//Стираем все данные
        $('#button_add_giveaway').attr('requestid',''+$(event.target).attr('requestid')+'');//Добавляем в кнопку
    });

    $(document).off('click.come1cnum').on('click.come1cnum', '.edit_1c_num', function (event) {
        $('#edit_1c_num').toggleClass('come_here', 1000);
        $('#edit_1c_num>input[name=1]').val('');//Стираем все данные
        $('#edit_1c_num>input[name=2]').val('');//Стираем все данные
        console.log($(event.target).attr('requestid'));
        $('#button_edit_1c_num').attr('requestid',''+$(event.target).attr('requestid')+'');//Добавляем в кнопку
        $('#button_edit_created').attr('requestid',''+$(event.target).attr('requestid')+'');//Добавляем в кнопку
    });

    $(document).off('click.comeoptions').on('click.comeoptions', '.edit_options', function (event) {
        $('#edit_options>input[name=1]').val('');//Стираем все данные
        $('#edit_options>input[name=2]').val('');//Стираем все данные
        $('#edit_options>input[name=3]').val('');//Стираем все данные
        $('#edit_options>input[name=4]').val('');//Стираем все данные
        var reqid = $(event.target).attr('requestid');
        $('#button_edit_op').attr('requestid',''+reqid+'');//Добавляем в кнопку
        $('#button_edit_tp').attr('requestid',''+reqid+'');//Добавляем в кнопку
        $('#button_edit_firstobp').attr('requestid',''+reqid+'');//Добавляем в кнопку
        $('#button_edit_wt').attr('requestid',''+reqid+'');//Добавляем в кнопку

        /*Запрос в базу для текущих опций*/
        if($('#edit_options').hasClass('come_here')){
            return false;
        }else{
            $.ajax({
                url: 'mysql_req_options.php',
                method: 'POST',
                dataType: 'json',
                cache: false,
                data: {req_options:reqid},
                success: function (data) {

                    $('#req_op_op').text(data.op);
                    $('#req_op_tp').text(data.tp);
                    $('#req_op_firstobp').text(data.firstobp);
                    $('#req_op_wt').text(data.wt);

                    $('#edit_op').val(data.op);
                    $('#edit_tp').val(data.tp);
                    $('#edit_firstobp').val(data.firstobp);
                    $('#edit_wt').val(data.wt);

                }
            });
        }

        $('#edit_options').toggleClass('come_here', 1000);
        /*///////////////////////////////*/
    });

    /*ЗАКРЫТИЕ ОКНА ДОБАВЛЕНИЯ*/////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.gopayment').on('click.gopayment', '.close_add_p', function (event) {
        $('#add_payment').toggleClass('come_here', 1000);
        $('#add_payment input[name=1]').val('');//Стираем все данные
        $('#add_payment input[name=2]').val('');//Стираем все данные
        $('#add_payment input[name=3]').val('');//Стираем все данные
        $('#add_payment input[name=4]').val('');//Стираем все данные
        $('#button_add_payment').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
    });

    $(document).off('click.gogiveaway').on('click.gogiveaway', '.close_add_g', function () {
        $('#add_giveaway').toggleClass('come_here', 1000);
        $('#add_giveaway>input[name=1]').val('');//Стираем все данные
        $('#add_giveaway>input[name=2]').val('');//Стираем все данные
        $('#add_giveaway>input[name=3]').val('');//Стираем все данные
        $('#button_add_giveaway').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
    });

    $(document).off('click.go1cnum').on('click.go1cnum', '.close_edit_1c_num', function () {
        $('#edit_1c_num').toggleClass('come_here', 1000);
        $('#edit_1c_num>input[name=1]').val('');//Стираем все данные
        $('#edit_1c_num>input[name=2]').val('');//Стираем все данные
        $('#button_edit_1c_num').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_created').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
    });

    $(document).off('click.gooptions').on('click.gooptions', '.close_edit_options', function () {
        $('#edit_options').toggleClass('come_here', 1000);
        $('#edit_options>input[name=1]').val('');//Стираем все данные
        $('#edit_options>input[name=2]').val('');//Стираем все данные
        $('#edit_options>input[name=3]').val('');//Стираем все данные
        $('#edit_options>input[name=4]').val('');//Стираем все данные
        $('#button_edit_op').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_tp').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_firstobp').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_wt').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления

        $('#req_op_op').text('');
        $('#req_op_tp').text('');
        $('#req_op_firstobp').text('');
        $('#req_op_wt').text('');

        $('#edit_op').val();
        $('#edit_tp').val();
        $('#edit_firstobp').val();
        $('#edit_wt').val();
    });

    /*Проверка числовых значений*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('keyup.check_ga').on('keyup.check_ga', '.come_here #add_payment_sum, .come_here #add_giveaway_sum, .come_here #add_1c_num, .come_here #edit_op, .come_here #edit_tp, .come_here #edit_firstobp, .come_here #edit_wt', function (event) {
        console.log($(event.target).attr('id')+' - '+$(event.target).val());
        var p_sum = Number(Number($(event.target).val()).toFixed(2));
        var p_sum_str = $(event.target).val();

        if(p_sum_str.indexOf(',') >= 0){
            console.log(1);
            $(event.target).switchClass('ready','not_ready');
            $(event.target).siblings('.ready_comment').text('Замените запятую на точку. База иначе не поймет.').switchClass('ok','not-ok');
        }else if(isNaN(p_sum)){
            console.log(2);
            $(event.target).switchClass('ready','not_ready');
            $(event.target).siblings('.ready_comment').text('Не число.Уберите пробелы и буквы.База их не любит.').switchClass('ok','not-ok');
        }else if(p_sum<=0){
            console.log(3);
            $(event.target).switchClass('ready','not_ready');
            $(event.target).siblings('.ready_comment').text('Сумма <= 0').switchClass('ok','not-ok');
        }else {
            console.log(4);
            $(event.target).switchClass('not_ready','ready');
            $(event.target).siblings('.ready_comment').text('Все ОК').switchClass('not-ok','ok');
        };
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*СОБСТВЕННО ДОБАВЛЕНИЕ*////////////////////////////////////////////////////////////////////////////////////////////
    //ДОБАВЛЕНИЕ ПЛАТЕЖКИ///////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_payment').on('click.add_payment', '#button_add_payment', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения платежки*/
        var payment_date = $('#add_payment.come_here #add_payment_date').val();
        var num = $('#add_payment.come_here #add_payment_1c_num').val();
        var comment = $('#add_payment.come_here #add_payment_comment').val();
        var sum = Number(Number($('#add_payment.come_here #add_payment_sum').val()).toFixed(2));
        /*//////////////////////////////*/
         $.ajax({
             url: 'mysql_insert.php',
             method: 'POST',
             data: {reqid:reqid, payment_date:payment_date, num:num, comment:comment, sum:sum},
             success: function (data) {
                 $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                 console.log(data);
             }, complete: function () {
                 $.ajax({
                     url: 'mysql_giveaways.php',
                     method: 'POST',
                     dataType: 'json',
                     cache: false,
                     data: {the_request:reqid},
                     success: function (data) {
                         $('.ga_contents[ga_request='+reqid+'] .ga_c_payments').html(data.data1);
                         $('.ga_contents[ga_request='+reqid+'] .ga_c_positions').html(data.data2);
                         $('.ga_contents[ga_request='+reqid+'] .ga_c_giveaways').html(data.data3);
                         $('.ga_contents[ga_request='+reqid+'] .ga_options').html(data.data4);
                         $('#add_payment').toggleClass('come_here');
                     }
                 });
             }
         });
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //ДОБАВЛЕНИЕ ВЫДАЧИ/////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_giveaway').on('click.add_giveaway', '#button_add_giveaway', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения выдачи*/
        var giveaway_date = $('#add_giveaway.come_here #add_giveaway_date').val();
        var comment = $('#add_giveaway.come_here #add_giveaway_comment').val();
        var sum = Number(Number($('#add_giveaway.come_here #add_giveaway_sum').val()).toFixed(2));
        /*//////////////////////////////*/
         $.ajax({
             url: 'mysql_insert.php',
             method: 'POST',
             data: {reqid:reqid, giveaway_date:giveaway_date, comment:comment, sum:sum},
             success: function (data) {
                 $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
             }, complete: function () {
                 $.ajax({
                     url: 'mysql_giveaways.php',
                     method: 'POST',
                     dataType: 'json',
                     cache: false,
                     data: {the_request:reqid},
                     success: function (data) {
                         $('.ga_contents[ga_request='+reqid+'] .ga_c_payments').html(data.data1);
                         $('.ga_contents[ga_request='+reqid+'] .ga_c_positions').html(data.data2);
                         $('.ga_contents[ga_request='+reqid+'] .ga_c_giveaways').html(data.data3);
                         $('.ga_contents[ga_request='+reqid+'] .ga_options').html(data.data4);
                         $('#add_giveaway').toggleClass('come_here');
                     }
                 });
             }
         });
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ИЗМЕНЕНИЕ НОМЕРА ЗАКАЗА В 1С//////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.edit_1c_num').on('click.edit_1c_num', '#button_edit_1c_num', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения выдачи*/
        var new1cnum = $('#add_1c_num').val();
        console.log(new1cnum);
        /*//////////////////////////////*/
        $.ajax({
            url: 'mysql_save.php',
            method: 'POST',
            data: {reqid:reqid, new_1c_num:new1cnum},
            success: function (data) {
                $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
            }, complete: function () {//Нужно обновить данные
                if($('#tab_giveaways').hasClass('ui-state-active')){//Если мы в выдачах
                    console.log('Мы в выдачах');
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {chng_number_1c:reqid},
                        success: function (data) {
                            $('.req_header_'+reqid+' .1c_num').html(data);
                        }
                    });
                }
                //Если мы в заявках/расценках
                if($('#tab_requests').hasClass('ui-state-active')) {
                    console.log('Мы в расценках/заявках');
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {/*gt_table:'requests',gt_identifier:'requests_id',*/chng_number_1c:reqid/*,gt_attribute:'created'*/},
                        success: function (data) {
                            $('.req_header_'+reqid+' .1c_num').html(data);
                        }
                    });
                }
            }
        });
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ИЗМЕНЕНИЕ ДАТЫ ЗАЯВКИ/////////////////////////////////////////////////////////////////////////////////////////////

    $(document).off('click.edit_created').on('click.edit_created', '#button_edit_created', function(event){
        var reqid = Number($(event.target).attr("requestid"));
        /*Данные для заполнения выдачи*/
        var newdate = $('#add_created').val();
        console.log(newdate);
        newdate = newdate.slice(6,10)+'-'+newdate.slice(3,5)+'-'+newdate.slice(0,2);
        console.log(newdate);
        /*//////////////////////////////*/
        $.ajax({
            url: 'mysql_save.php',
            method: 'POST',
            data: {reqid:reqid, newdate:newdate},
            success: function (data) {
                $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
            }, complete: function () {//Нужно обновить данные
                if($('#tab_giveaways').hasClass('ui-state-active')){//Если мы в выдачах
                    console.log('Мы в выдачах');
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {chng_number:reqid},
                        success: function (data) {
                            $('.req_header_'+reqid+' .date').html(data);
                        }
                    });
                }
                //Если мы в заявках/расценках
                if($('#tab_requests').hasClass('ui-state-active')) {
                    console.log('Мы в расценках/заявках');
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {/*gt_table:'requests',gt_identifier:'requests_id',*/chng_number:reqid/*,gt_attribute:'created'*/},
                        success: function (data) {
                            $('.req_header_'+reqid+' .date').html(data);
                        }
                    });
                }
            }
        });
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ИЗМЕНЕНИЕ ОПЦИЙ ЗАКАЗА////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.edit_options').on('click.edit_options', '#button_edit_op, #button_edit_tp, #button_edit_firstobp, #button_edit_wt', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения выдачи*/

        var the_span = $(event.target).attr('id').substring(12);
        var c_c = $(event.target).attr('cc');
        var put_span = $('#req_op_'+the_span);//Куда результат будет в конце посажен
        the_span = $('#req_op_'+the_span).text();
        the_span = Number(parseFloat(the_span));
        var the_input = $(event.target).attr('id').substring(7);
        the_input = $('#'+the_input).val();
        the_input = Number(parseFloat(the_input));
        console.log(the_span+" "+typeof the_span);
        console.log(the_input+" "+typeof the_input);
        /*ПРОВЕРКА, ИЗМЕНИЛАСЬ ЛИ ОПЦИЯ ПЕРЕД ОТПРАВКОЙ НОВОЙ ЦИФРЫ*/
        if (the_span === the_input){
            console.log("отказ");
            return false;
        }else{
            //TODO:На соответствующий инпут надо положить класс .changed
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {reqid:reqid, c_c:c_c, the_input:the_input},
                success: function (data) {//Изменяем
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                },complete: function (data) {
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {c_c:c_c, reqid:reqid},
                        success: function (data) {//Читаем
                            $(put_span).html(data);
                            console.log("выполнено");
                        }
                    });
                }
            });
        }
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////
    $('.from,.to,#add_created').datepicker({
        dateFormat: "dd-mm-yy",
        showButtonPanel: true,
        dayNames: [ "Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
        dayNamesShort: [ "Вос", "Пон", "Втр", "Срд", "Чтв", "Пят", "Суб" ],
        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Нов", "Дек" ]
    });

    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /*Отображение заявок одного покупателя*/////////////////////////////////////////////////////////////////////////////
    $(document).off('.dblclick.sort_byer').on('dblclick.sort_byer', '.requests_list td[byerid]', function(event){
        //if( event.target != this )
            //return false;
        var the_b_id = $(event.target).parents('[byerid]').attr('byerid');
        console.log(the_b_id);
        var what2hide = $('.requests_list tr:not(.requests_list tr[byerid="'+the_b_id+'"],.requests_list thead tr)');
        what2hide.toggle();
    });

    $(".example").click(function(){
        $(this).fadeOut("fast");
    }).children().click(function(e) {
        return false;
    });

    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*Отображение дней отсрочки в опциях заявки*////////////////////////////////////////////////////////////////////////
    $('#edit_wt').change(function () {
        //Изменяется количество дней
        var wtime = Number(Number($('#edit_wt').val()).toFixed(2));
        $('#req_op_wt_days').text((wtime / 0.0334).toFixed(0));
        wtime = null;
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



});
