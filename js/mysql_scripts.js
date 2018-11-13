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
                    },
                    complete: function() {$('a[href = "#requests"]').trigger('click');
                    }
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
                                addinput.val('').focus();
                            }
                        });
                    } else {alert("Введите имя")};
        };
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Чтение таблицы. Имя табицы берется из атрибута li('href') и отрезанием первого символа #//////////////////////////
    $(document).off('click.readtab').on('click.readtab', '.show_list', function(event){

        /**/
        $('.requests_list').removeClass('shrinken');
        $('td.widen').removeClass('widen');
        $('.requests_list tr').css('opacity', 1);
        /**/

        var table = $(event.target).parent().attr('id');
        console.log(table);
        if (table=='search'){
            return false;
        }else{
            $.ajax({
                url: 'mysql_read.php',
                method: 'POST',
                data: {table:table},
                success: function (data) {
                    //$('#reads .' + table + '_list').html(data);
                    $(event.target).siblings('.' + table + '_list').html(data);
                },
                complete: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Данные из таблицы " + table + " получены.");
                    $('.creates input[type=\'text\']').val('');
                    $('.from,.to').val('');
                }
            });
        }

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

    /*СПИСОК ВЫДАЧ В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ////////////////////////////////////////////////////////////////////////*/
    $(document).off('click.vid_vidachi').on('click.vid_vidachi', '.collapse_vid_byer', function (event) {
        var the_byer = $(event.target).attr('vid_byer');

        if ($('.vid_byer_requests:visible').length > 0){
            if ($(event.target).val() == 'X'){//Закрываем открытое
                $(event.target).val('♢');
                $(event.target).next('span').css({'font-size' : '1em'});
                $(event.target).siblings('.vid_byer_requests').slideUp();
                return false;//На закрытии скрипт останавливается
            }else {
                //Открываем новое
                $.ajax({
                    url: 'mysql_vidachi.php',
                    method: 'POST',
                    data: {the_byer:the_byer},
                    success: function (data) {
                        $('.vid_byer_requests[vid_byer='+the_byer+']').html(data);
                        //Скрытие открытых
                        $('.vid_byer_requests:visible').slideUp();
                        //Расширение в высоту
                        $('.vid_byer_requests[vid_byer='+the_byer+']').slideDown();
                        $('input.collapse_vid_byer[value = "X"]').next('span').css({'font-size' : '1em'});
                        $('input.collapse_vid_byer[value = "X"]').val('♢');
                        $(event.target).val('X');
                        $(event.target).next('span').css({'font-size' : 30});
                    }
                });
            }

        }else{

            //Просто открываем новое
            $.ajax({
                url: 'mysql_vidachi.php',
                method: 'POST',
                data: {the_byer:the_byer},
                success: function (data) {
                    $('.vid_byer_requests[vid_byer='+the_byer+']').html(data);
                    //Скрытие открытых
                    $('div.vid_byer_requests:visible').slideUp();
                    //Расширение в высоту
                    $('.vid_byer_requests[vid_byer='+the_byer+']').slideDown();
                    $(event.target).val('X');
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

    /*СПИСОК ЗАЯВОК В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ////////////////////////////////////////////////////////////////////////*/
    $(document).off('click.ga_requests').on('click.ga_requests', '.collapse_ga_byer', function (event) {
        var the_byer = $(event.target).attr('ga_byer');

        if ($('.ga_byer_requests:visible').length > 0){
            if ($(event.target).val() == 'X') {
                  //$(event.target).switchClass('x','w').val('W');
                  //$(event.target).next('span').css({'font-size' : '1em'});
                  //$(event.target).siblings('.ga_byer_requests').slideUp();
                //Скрытие открытых
                $('li[byerid].ga_widen .ga_byer_requests').html('');//Очищаем html аякса
                $('li[byerid].ga_widen').removeClass('ga_widen');//Сужаем высоту
                $('input.collapse_ga_byer[value = "X"]').next('span').css({'font-size' : '1em'});//Все увеличенные шрифты уменьшаются обратно
                $('input.collapse_ga_byer[value = "X"]').switchClass('x','w').val('♢');//Кнопочка
                $('.ga_byer_requests:visible').slideUp();//Скрывается контейнер
                console.log('about to false');
                return false;
            }
            else {
                //Скрытие открытых
                $('li[byerid].ga_widen .ga_byer_requests').html('');//Очищаем html аякса
                $('li[byerid].ga_widen').removeClass('ga_widen');//Сужаем высоту
                $('input.collapse_ga_byer[value = "X"]').next('span').css({'font-size' : '1em'});//Все увеличенные шрифты уменьшаются обратно
                $('input.collapse_ga_byer[value = "X"]').switchClass('x','w').val('♢');//Кнопочка
                $('.ga_byer_requests:visible').slideUp();//Скрывается контейнер
                //Открываем новое
                $.ajax({
                    url: 'mysql_giveaways.php',
                    method: 'POST',
                    data: {the_byer:the_byer},
                    success: function (data) {
                        //Расширение в высоту
                        $(event.target).parent('li[byerid]').addClass('ga_widen');
                        //Вставляем данные аякса
                        $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                        /*Скроллимся к только что открытой завяке*/
                        var e = $('.ga_widen').offset().top;
                        console.log(e);
                        $('html, body').animate({scrollTop: e}, 1000);
                        /**/
                        $(event.target).switchClass('w','x').val('X');//Кнопочка
                        $(event.target).next('span').css({'font-size' : 30});//Увеличивается шрифт
                        $('.ga_byer_requests[ga_byer='+the_byer+']').slideDown();//Показывается контейнер
                        console.log('clear open from 1');
                    },complete:function () {
                        $('.from,.to').datepicker({//Подключение дейтпикера
                            dateFormat: "dd-mm-yy",
                            showButtonPanel: true,
                            dayNames: [ "Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
                            dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
                            dayNamesShort: [ "Вос", "Пон", "Втр", "Срд", "Чтв", "Пят", "Суб" ],
                            monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                            monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Нов", "Дек" ]
                        });//Подключение дейтпикера
                        $('.from,.to').val('');//Очистка дейтпикера
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
                    //Расширение в высоту
                    $(event.target).parent('li[byerid]').addClass('ga_widen');
                    //Вставляем данные аякса
                    $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                    /*Скроллимся к только что открытой завяке*/
                    var e = $('.ga_widen').offset().top;
                    console.log(e);
                    $('html, body').animate({scrollTop: e}, 1000);
                    /**/
                    $(event.target).switchClass('w','x').val('X');//Кнопочка
                    $(event.target).next('span').css({'font-size' : 30});//Увеличивается шрифт
                    $('.ga_byer_requests[ga_byer='+the_byer+']').slideDown();//Показывается контейнер
                    console.log('clear open from 2');
                },complete:function () {
                    $('.from,.to').datepicker({//Подключение дейтпикера
                        dateFormat: "dd-mm-yy",
                        showButtonPanel: true,
                        dayNames: [ "Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
                        dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
                        dayNamesShort: [ "Вос", "Пон", "Втр", "Срд", "Чтв", "Пят", "Суб" ],
                        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
                        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Нов", "Дек" ]
                    });//Подключение дейтпикера
                    $('.from,.to').val('');//Очистка дейтпикера
                }
            });
        }
    });
    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*СПИСОК ПЛАТЕЖЕЙ, НАЧИСЛЕНИЙ И ВЫДАЧ В РАМКАХ ОДНОЙ ЗАЯВКИ///////////////////////////////////////////////////////*/
    $(document).off('click.ga_contents').on('click.ga_contents', '.collapse_ga_request', function (event) {
        var the_request = $(event.target).attr('ga_request');
        var the_byer = $(event.target).parents('li[byerid]').attr('byerid');

        if($(event.target).val() == 'X'){//Закрываем просто
            $(event.target).parents('.ga_byer_requests').removeClass('shrinken');
            $(event.target).parent().removeClass('ga_widen');
            $('.ga_c_payments, .ga_c_giveaways, .ga_c_positions').removeClass('min-h')//Правила для трех папок по высоте
            $('.ga_requests_date_range').show();//Дейтпикер
            $('.collapse_ga_byer.x').show();//Верхний красный крест
            $(event.target).val('♢').css({'background':'white','color':'black'});
            $('tr[ga_request]').not('tr[ga_request='+the_request+']').slideDown();
            $('.ga_contents').slideUp();//Спрятали содержимое заявок
            //Обновляем HTML Списка заявок по данному покупателю
            $.ajax({
                url: 'mysql_giveaways.php',
                method: 'POST',
                data: {the_byer: the_byer},
                success: function (data) {
                    $('.ga_byer_requests[ga_byer=' + the_byer + ']').html(data);
                }
            });
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            return false;
        };
        $(event.target).val('X').css({'background':'red','color':'white'});
        /*Прятание*/
        $('.ga_requests_date_range').hide();//Дейтпикер
        $('.collapse_ga_byer.x').hide();//Верхний красный крест
        $('tr[ga_request]').not('tr[ga_request='+the_request+']').hide();
        $(event.target).parents('.ga_byer_requests').addClass('shrinken');
        $(event.target).parent().addClass('ga_widen');
        $('.ga_c_payments, .ga_c_giveaways, .ga_c_positions').addClass('min-h')//Правила для трех папок по высоте


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

        $('.ga_contents[ga_request='+the_request+']').show();
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

    //ВЫЗОВ ОКНА ОПЦИЙ ЗАЯВКИ
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
                url: 'mysql_options.php',
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

    //ВЫЗОВ ОКНА ОПЦИЙ ПОЗИЦИИ
    $(document).off('click.comeposoptions').on('click.comeposoptions', '.edit_options_pos', function (event) {
        $('#edit_options_pos>input[name=1]').val('');//Стираем все данные
        $('#edit_options_pos>input[name=2]').val('');//Стираем все данные
        $('#edit_options_pos>input[name=3]').val('');//Стираем все данные
        $('#edit_options_pos>input[name=4]').val('');//Стираем все данные
        var posid = $(event.target).attr('pos_op_id');
        var reqid = $(event.target).attr('req_op_id');
        $('#button_edit_op_pos').attr('positionid',''+posid+'');//Добавляем в кнопку
        $('#button_edit_tp_pos').attr('positionid',''+posid+'');//Добавляем в кнопку
        $('#button_edit_firstobp_pos').attr('positionid',''+posid+'');//Добавляем в кнопку
        $('#button_edit_wt_pos').attr('positionid',''+posid+'');//Добавляем в кнопку

        /*Запрос в базу для текущих опций*/
        if($('#edit_options_pos').hasClass('come_here')){
            return false;
        }else{
            $.ajax({
                url: 'mysql_options.php',
                method: 'POST',
                dataType: 'json',
                cache: false,
                data: {name_and_queen:posid},
                success: function (data) {

                    $('#edit_options_pos h3').text(data.name);
                    var queen_status = data.queen;
                    console.log(queen_status+" "+typeof queen_status);
                    if(queen_status === "1"){//queen = 1
                        console.log('queen true');
                        $('#add_queen').prop('checked', true);
                        $('#edit_op_pos, #edit_tp_pos, #edit_firstobp_pos, #edit_wt_pos, #button_edit_op_pos, #button_edit_tp_pos, #button_edit_firstobp_pos, #button_edit_wt_pos').prop('disabled', false);
                        //запрос опций в позицию
                        $.ajax({
                            url: 'mysql_options.php',
                            method: 'POST',
                            dataType: 'json',
                            cache: false,
                            data: {pos_options:posid},
                            success: function (data) {
                                $('#edit_op_pos').val(data.op);
                                $('#edit_tp_pos').val(data.tp);
                                $('#edit_firstobp_pos').val(data.firstobp);
                                $('#edit_wt_pos').val(data.wt);

                                $('#pos_op_op').text(data.op);
                                $('#pos_op_tp').text(data.tp);
                                $('#pos_op_firstobp').text(data.firstobp);
                                $('#pos_op_wt').text(data.wt);
                            }
                        });
                    }else if (queen_status === "0") {//queen = 0
                        console.log('queen false');
                        $('#add_queen').prop('checked', false);
                        $('#edit_op_pos, #edit_tp_pos, #edit_firstobp_pos, #edit_wt_pos, #button_edit_op_pos, #button_edit_tp_pos, #button_edit_firstobp_pos, #button_edit_wt_pos').prop('disabled', true);
                        //запрос опций в заявку
                        $.ajax({
                            url: 'mysql_options.php',
                            method: 'POST',
                            dataType: 'json',
                            cache: false,
                            data: {req_options:reqid},
                            success: function (data) {
                                $('#edit_op_pos').val(data.op);
                                $('#edit_tp_pos').val(data.tp);
                                $('#edit_firstobp_pos').val(data.firstobp);
                                $('#edit_wt_pos').val(data.wt);

                                $('#pos_op_op').text(data.op);
                                $('#pos_op_tp').text(data.tp);
                                $('#pos_op_firstobp').text(data.firstobp);
                                $('#pos_op_wt').text(data.wt);
                            }
                        });
                    }
                }
            });
        }
        $('#edit_options_pos').toggleClass('come_here', 1000);
        /*///////////////////////////////*/
    });

    //ВЫЗОВ ОКНА ОПЦИЙ ТОВАРА
    $(document).off('click.cometradeoptions').on('click.cometradeoptions', '.edit_options_trade', function (event) {
        $('#edit_options_trade>input[name=1]').val('');//Стираем все данные
        $('#edit_options_trade>input[name=2]').val('');//Стираем все данные

        var tradeid = $(event.target).attr('tradeid');

        /*Запрос в базу для текущих опций*/
        if($('#edit_options_trade').hasClass('come_here')){
            return false;
        }else{
            $.ajax({
                url: 'mysql_options.php',
                method: 'POST',
                dataType: 'json',
                cache: false,
                data: {trade_options:tradeid},
                success: function (data) {

                    $('#trade_options_name').text(data.tradename);
                    $('#trade_options_tare').text(data.tare);

                    $('#edit_trade_name').val(data.tradename);
                    $('#edit_trade_tare').val(data.tare);

                    $('#button_edit_trade_name').attr('nameid',data.tradenameid);
                    $('#button_edit_trade_tare').attr('tradeid',data.trades_id);

                }
            });
        }

        $('#edit_options_trade').toggleClass('come_here', "fast");
        /*///////////////////////////////*/
    });

    /*Закрытие окна редактирования опций товара*/
    $(document).off('click.gotradeoptions').on('click.gotradeoptions', '.close_edit_options_trade', function () {
        $('#edit_options_trade').removeClass('come_here', 'fast');
        $('#trade_options_name').text('');

        $('#edit_trade_name, #edit_trade_tare').val('').removeClass('ready not_ready');
        $('.ready_comment').text('').removeClass('ok not-ok');

        $('#button_edit_trade_name').attr('nameid', 'xxx').prop('disabled', true);;
        $('#button_edit_trade_tare').attr('tradeid', 'xxx').prop('disabled', true);;


    });

    /*ЗАКРЫТИЕ ОКНА ДОБАВЛЕНИЯ*/////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.gopayment').on('click.gopayment', '.close_add_p', function (event) {
        $('#add_payment').toggleClass('come_here', 1000);
        $('#add_payment input[name=1]').val('');//Стираем все данные
        $('#add_payment input[name=2]').val('');//Стираем все данные
        $('#add_payment input[name=3]').val('');//Стираем все данные
        $('#add_payment input[name=4]').val('');//Стираем все данные
        $('#button_add_payment').attr('requestid','-');//Стираем номер заявки из кнопки добавления
        $('#button_add_payment').attr('paymentid','-');//Стираем номер платежки из кнопки добавления
    });

    $(document).off('click.gogiveaway').on('click.gogiveaway', '.close_add_g', function () {
        $('#add_giveaway').toggleClass('come_here', 1000);
        $('#add_giveaway>input[name=1]').val('');//Стираем все данные
        $('#add_giveaway>input[name=2]').val('');//Стираем все данные
        $('#add_giveaway>input[name=3]').val('');//Стираем все данные
        $('#button_add_giveaway').attr('requestid','-');//Стираем номер заявки из кнопки добавления
        $('#button_add_giveaway').attr('giveawayid','-');//Стираем номер выдачи из кнопки добавления
    });

    /*Закрытие окна редактирования номера в 1с и даты*/
    $(document).off('click.go1cnum').on('click.go1cnum', '.close_edit_1c_num', function () {
        $('#edit_1c_num').toggleClass('come_here', 1000);
        $('#edit_1c_num>input[name=1]').val('');//Стираем все данные
        $('#edit_1c_num>input[name=2]').val('');//Стираем все данные
        $('#button_edit_1c_num').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_created').attr('requestid','xxx');//Стираем номер заявки из кнопки добавления
        $('#1cnum').prop('checked',false);
    });

    /*Закрытие окна редактирования опций заявки*/
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
        $('#edit_options .req_op_wt_days').text('');

        $('#edit_op').val();
        $('#edit_tp').val();
        $('#edit_firstobp').val();
        $('#edit_wt').val();
    });

    /*Закрытие окна редактирования опций позиции*/
    $(document).off('click.goposoptions').on('click.goposoptions', '.close_edit_options_pos', function () {
        $('#edit_options_pos').toggleClass('come_here', 1000);
        $('#add_queen').prop( "checked", false );//Стираем все данные

        $('#edit_options_pos>input[name=1]').val('');//Стираем все данные
        $('#edit_options_pos>input[name=2]').val('');//Стираем все данные
        $('#edit_options_pos>input[name=3]').val('');//Стираем все данные
        $('#edit_options_pos>input[name=4]').val('');//Стираем все данные
        $('#button_edit_op_pos').attr('positionid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_tp_pos').attr('positionid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_firstobp_pos').attr('positionid','xxx');//Стираем номер заявки из кнопки добавления
        $('#button_edit_wt_pos').attr('positionid','xxx');//Стираем номер заявки из кнопки добавления

        $('#pos_op_op').text('');
        $('#pos_op_tp').text('');
        $('#pos_op_firstobp').text('');
        $('#pos_op_wt').text('');
        $('#edit_options_pos .req_op_wt_days').text('');

        $('#edit_op_pos').val();
        $('#edit_tp_pos').val();
        $('#edit_firstobp_pos').val();
        $('#edit_wt_pos').val();

    });

    /*Действия по чекингу/анчекингу королевы*/
    //$('#edit_options_pos #queen').prop( "checked", false );//Стираем все данные
    $(document).off('click.addqueen').on('click.addqueen', '#add_queen', function (event) {
        var posid = $('#button_edit_op_pos').attr('positionid');
        if($('#add_queen').prop('checked')){
            console.log($('#add_queen').prop('checked'));
            $('#edit_op_pos, #edit_tp_pos, #edit_firstobp_pos, #edit_wt_pos, #button_edit_op_pos, #button_edit_tp_pos, #button_edit_firstobp_pos, #button_edit_wt_pos').prop('disabled', false);
        }else{
            console.log($('#add_queen').prop('checked'));
            if(confirm("Вы действительно хотите отменить особые опции для этой позиции?")){
                console.log('YF fzrc');
                $.ajax({
                    url: 'mysql_options.php',
                    method: 'POST',
                    data: {minus_queen: posid},
                    success: function (data) {
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(3000).html(data);
                    },complete: function () {
                        $('#edit_op_pos, #edit_tp_pos, #edit_firstobp_pos, #edit_wt_pos, #button_edit_op_pos, #button_edit_tp_pos, #button_edit_firstobp_pos, #button_edit_wt_pos').prop('disabled', true);
                    }
                });
            }else{
                $('#add_queen').prop('checked', true);
            }

        }
    });
    /**/

    /*Проверка числовых значений*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('keyup.check_ga').on('keyup.check_ga', '.come_here #add_payment_sum, .come_here #add_giveaway_sum, .come_here #add_1c_num, ' +
        '.come_here #edit_op, .come_here #edit_tp, .come_here #edit_firstobp, .come_here #edit_wt,' +
        '.come_here #edit_op_pos, .come_here #edit_tp_pos, .come_here #edit_firstobp_pos, .come_here #edit_wt_pos', function (event) {
        console.log($(event.target).attr('id')+' - '+$(event.target).val());
        var p_sum = Number(Number($(event.target).val()).toFixed(2));
        var p_sum_str = $(event.target).val();

        if(p_sum_str.indexOf(',') >= 0){
            //console.log(1);
            $(event.target).switchClass('ready','not_ready');
            $(event.target).siblings('.ready_comment').text('Замените запятую на точку. База иначе не поймет.').switchClass('ok','not-ok');
        }else if(isNaN(p_sum)){
            //console.log(2);
            $(event.target).switchClass('ready','not_ready');
            $(event.target).siblings('.ready_comment').text('Не число.Уберите пробелы и буквы.База их не любит.').switchClass('ok','not-ok');
        }else if(p_sum<0){
            //console.log(3);
            $(event.target).switchClass('ready','not_ready');
            $(event.target).siblings('.ready_comment').text('Сумма <= 0').switchClass('ok','not-ok');
        }else if(p_sum=0){
            if($(event.target).attr('id') == 'add_payment_sum' || $(event.target).attr('id') == 'add_giveaway_sum'){
                console.log('ПЛатежка и выдача с нулевой суммой? О_о');
            }
        }else{
            //console.log(4);
            $(event.target).switchClass('not_ready','ready');
            $(event.target).siblings('.ready_comment').text('Все ОК').switchClass('not-ok','ok');
        };
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /*Проверка текстовых значений*//////////////////////////////////////////////////////////////////////////////////////
    $(document).off('keyup.input.tradename').on('keyup.input.tradename', '#edit_trade_name', function (event) {
        /*Данные для заполнения выдачи*/
        var newname = $('#edit_trade_name').val();
        var oldname = $('#trade_options_name').text();
        checkname(newname,oldname);
    });
    $(document).off('change.input.tare').on('change.input.tare', '#edit_trade_tare', function (event) {
        /*Данные для заполнения выдачи*/
        var newtare = $('#edit_trade_tare').val();
        var oldtare = $('#trade_options_tare').text();
        checktare(newtare,oldtare);
    });
    /*Проверка тестовых значений функцией*/
    /*ПРОВЕРКА ИМЕНИ ФУНКЦИЕЙ*/
    /*Проверка текстовых наименования товара*///////////////////////////////////////////////////////////////////////////
    function checkname(newname,oldname){
        //Проверка, изменилось ли:
        if(newname === oldname){
            //$('#edit_trade_name').siblings('.ready_comment').text('Ничего не изменилось.').switchClass('ok','not-ok');
            $('#edit_trade_name').switchClass('not_ready','ready');
            $('#edit_trade_name').siblings('.ready_comment').text('Ничего не изменилось.').switchClass('not-ok','ok');
            $('#button_edit_trade_name').prop('disabled', true);
            return false;
        }else{
            if(newname.indexOf("'") >= 0 || newname.indexOf("\"") >= 0){
                $('#edit_trade_name').switchClass('ready','not_ready');
                $('#edit_trade_name').siblings('.ready_comment').text('Ковычки уберите.База их не любит.').switchClass('ok','not-ok');
                $('#button_edit_trade_name').prop('disabled', true);
                return false;
            } else{
                $('#edit_trade_name').switchClass('not_ready','ready');
                $('#edit_trade_name').siblings('.ready_comment')/*.text('Можно сохранять.')*/.switchClass('not-ok','ok');
                $('#button_edit_trade_name').prop('disabled', false);
                return true;
            }
        }
    };

    /*Проверка типа тары*///////////////////////////////////////////////////////////////////////////////////////////////
    function checktare(newtare,oldtare){
        //Проверка, изменилось ли:
        if(newtare === oldtare){
            $('#edit_trade_tare').siblings('.ready_comment').text('Ничего не изменилось.').switchClass('not-ok','ok');
            $('#button_edit_trade_tare').prop('disabled', true);
            return false;
        }else{
                $('#edit_trade_tare').switchClass('not_ready','ready');
                $('#edit_trade_tare').siblings('.ready_comment')/*.text('Можно сохранять.')*/.switchClass('not-ok','ok');
                $('#button_edit_trade_tare').prop('disabled', false);
                return true;
        }
    };
    /**/
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*СОБСТВЕННО ДОБАВЛЕНИЕ*////////////////////////////////////////////////////////////////////////////////////////////

    //ДОБАВЛЕНИЕ ПЛАТЕЖКИ///////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_payment').on('click.add_payment', '#button_add_payment', function(event){

        var reqid = $(event.target).attr("requestid");
        var payid = $(event.target).attr("paymentid");
        /*Данные для заполнения платежки*/
        var payment_date = $('#add_payment.come_here #add_payment_date').val();
        var num = $('#add_payment.come_here #add_payment_1c_num').val();
        var sum = Number(Number($('#add_payment.come_here #add_payment_sum').val()).toFixed(2));


        //TODO:ПРОВЕРКА, ЕСТЬ ЛИ В event.target paymentid. Если paymentid !='-', отправляем на mysql.save, в противном - на insert.
        if($(event.target).attr('paymentid') !='-'){
            console.log('ушло на mysql_save.php');
            //Аякс на mysql_save.php
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {reqid:reqid, payment_date:payment_date, num:num, sum:sum, pay_id:payid},
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
                            $('#add_payment input[name=1]').val('');//Стираем все данные
                            $('#add_payment input[name=2]').val('');//Стираем все данные
                            $('#add_payment input[name=3]').val('');//Стираем все данные
                            $('#button_add_payment').attr('requestid','-');//Стираем номер заявки из кнопки добавления
                            $('#button_add_payment').attr('paymentid','-');//Стираем номер платежки из кнопки добавления
                        }
                    });
                }
            });
        }else{
            console.log('ушло на mysql_insert.php');
            $.ajax({
                url: 'mysql_insert.php',
                method: 'POST',
                data: {reqid:reqid, payment_date:payment_date, num:num, sum:sum},
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
                            $('#add_payment input[name=1]').val('');//Стираем все данные
                            $('#add_payment input[name=2]').val('');//Стираем все данные
                            $('#add_payment input[name=3]').val('');//Стираем все данные
                            $('#button_add_payment').attr('requestid','-');//Стираем номер заявки из кнопки добавления
                            $('#button_add_payment').attr('paymentid','-');//Стираем номер платежки из кнопки добавления
                        }
                    });
                }
            });
        }
        /*//////////////////////////////*/

    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ДОБАВЛЕНИЕ ВЫДАЧИ/////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_giveaway').on('click.add_giveaway', '#button_add_giveaway', function(event){
        var reqid = $(event.target).attr("requestid");
        var giveid = $(event.target).attr("giveawayid");
        /*Данные для заполнения выдачи*/
        var giveaway_date = $('#add_giveaway.come_here #add_giveaway_date').val();
        var comment = $('#add_giveaway.come_here #add_giveaway_comment').val();
        var sum = Number(Number($('#add_giveaway.come_here #add_giveaway_sum').val()).toFixed(2));
        /*//////////////////////////////*/

        if($(event.target).attr('giveawayid') !='-'){
            console.log('ушло на mysql_save.php');
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {reqid:reqid, giveaway_date:giveaway_date, comment:comment, sum:sum, give_id:giveid},
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
                            $('#add_giveaway>input[name=1]').val('');//Стираем все данные
                            $('#add_giveaway>input[name=2]').val('');//Стираем все данные
                            $('#add_giveaway>input[name=3]').val('');//Стираем все данные
                            $('#button_add_giveaway').attr('requestid','-');//Стираем номер заявки из кнопки добавления
                            $('#button_add_giveaway').attr('giveawayid','-');//Стираем номер выдачи из кнопки добавления
                        }
                    });
                }
            });

        }else{
            console.log('ушло на mysql_insert.php');
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
                            $('#add_giveaway>input[name=1]').val('');//Стираем все данные
                            $('#add_giveaway>input[name=2]').val('');//Стираем все данные
                            $('#add_giveaway>input[name=3]').val('');//Стираем все данные
                            $('#button_add_giveaway').attr('requestid','-');//Стираем номер заявки из кнопки добавления
                            $('#button_add_giveaway').attr('giveawayid','-');//Стираем номер выдачи из кнопки добавления
                        }
                    });
                }
            });
        }



    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ИЗМЕНЕНИЕ НОМЕРА ЗАКАЗА В 1С//////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.edit_1c_num').on('click.edit_1c_num', '#button_edit_1c_num', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения выдачи*/
        var new1cnum = $('#add_1c_num').val();
        //Проверка на чекбокс ИП
        if($('#1cnum').prop('checked') == true){
            new1cnum += '_ИП';
            console.log(new1cnum);
            console.log('ИП checked');
        }
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
                if($('#tab_requests').hasClass('ui-state-active') || $('#tab_search').hasClass('ui-state-active')) {
                    console.log('Мы в расценках/заявках или в результатах поиска');
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {/*gt_table:'requests',gt_identifier:'requests_id',*/chng_number_1c:reqid/*,gt_attribute:'created'*/},
                        success: function (data) {
                            $('.req_header_'+reqid+' .1c_num').html(data);
                            $('tr[requestid="'+reqid+'"] td.1c_num span').html(data);
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
                if($('#tab_requests').hasClass('ui-state-active') || $('#tab_search').hasClass('ui-state-active')) {
                    console.log('Мы в расценках/заявках или в результатах поиска');
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {/*gt_table:'requests',gt_identifier:'requests_id',*/chng_number:reqid/*,gt_attribute:'created'*/},
                        success: function (data) {
                            $('.req_header_'+reqid+' .date').html(data);
                            $('tr[requestid="'+reqid+'"] td.req_date span').html(data);

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

    //ИЗМЕНЕНИЕ ОПЦИЙ ПОЗИЦИИ///////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.edit_options_pos').on('click.edit_options_pos', '#button_edit_op_pos, #button_edit_tp_pos, #button_edit_firstobp_pos, #button_edit_wt_pos', function(event){
        var posid = $(event.target).attr("positionid");
        /*Данные для заполнения выдачи*/

        var the_span = $(event.target).attr('id').substring(12);
        the_span = the_span.replace('_pos', '');
        //console.log("the_span: "+the_span);
        var c_c = $(event.target).attr('cc');
        var put_span = $('#pos_op_'+the_span);//Куда результат будет в конце посажен
        the_span = $('#pos_op_'+the_span).text();
        the_span = Number(parseFloat(the_span));
        var the_input = $(event.target).attr('id').substring(7);
        //console.log("the_unput: "+the_input);
        the_input = $('#'+the_input).val();
        the_input = Number(parseFloat(the_input));
        //console.log(the_span+" "+typeof the_span);
        //console.log(the_input+" "+typeof the_input);

        var queen = $('#add_queen').prop('checked');
        if(queen){queen=1}else{queen=0};
        //console.log(queen);

        /*ПРОВЕРКА, ИЗМЕНИЛАСЬ ЛИ ОПЦИЯ ПЕРЕД ОТПРАВКОЙ НОВОЙ ЦИФРЫ*/
        if (the_span === the_input){
            console.log("отказ");
            return false;
        }else{
            //TODO:На соответствующий инпут надо положить класс .changed
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {posid:posid, c_c:c_c, the_input:the_input, queen:queen},
                success: function (data) {//Изменяем
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                },complete: function (data) {
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {pos_c_c:c_c, posid:posid},
                        success: function (data) {//Читаем
                            $(put_span).text(data);
                            console.log(put_span);
                            console.log("выполнено");
                        }
                    });
                }
            });
        }
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ИЗМЕНЕНИЕ ОПЦИЙ ТОВАРА
    //ИЗМЕНЕНИЕ НАИМЕНОВАНИЯ
    $(document).off('click.edit_trade_name').on('click.edit_trade_name', '#button_edit_trade_name', function(event){
        var table = 'trades';
        var nameid = $(event.target).attr("nameid");
        /*Данные для заполнения выдачи*/
        var newname = $('#edit_trade_name').val();
        var oldname = $('#trade_options_name').text();

        //Функция проверки
        if(checkname(newname,oldname)){
            $.ajax({
                url: 'mysql_rename.php',
                method: 'POST',
                data: {table:table, newname:newname, nameid:nameid},
                success: function (data) {
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                }, complete: function () {//Нужно обновить данные
                    $('#trade_options_name').text(newname);//Обновляем имя в самой менюшке
                    $('.trades_list td[category="trades"][name='+nameid+']>span').text(newname);//Обновляем имя в списке
                }
            });
        }
    });
    //ИЗМЕНЕНИЕ ТАРЫ
    $(document).off('click.edit_trade_tare').on('click.edit_trade_tare', '#button_edit_trade_tare', function(event){
        var oldtare = $('#trade_options_tare').text();
        var newtare = $('#edit_trade_tare').val();
        var tradeid = $(event.target).attr("tradeid");
        console.log(oldtare+'---'+newtare);
        if(checktare(newtare,oldtare)){
            console.log("Пошел аякс");
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {newtare:newtare, tradeid:tradeid},
                success: function (data) {
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                }, complete: function () {//Нужно обновить данные
                    $('#trade_options_tare').text(newtare);//Обновляем имя в самой менюшке
                    $('.trades_list td[tradeid='+tradeid+']>span').text(newtare);//Обновляем имя в списке
                }
            });
        }
    });

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
    $(document).off('dblclick.sort_byer').on('dblclick.sort_byer', '.requests_list td[byerid]', function(event){
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
    $(document).off('change.wt').on('change.wt', '#edit_wt, #edit_wt_pos', function(event){
        //Изменяется количество дней
        var wtime = Number(Number($(event.target).val()).toFixed(2));
        $(event.target).siblings('.req_op_wt_days').text((wtime / 0.0334).toFixed(0));
        wtime = null;
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*УБИРАНИЕ ЗАКАЗА ИЗ ВЫДАЧИ Р-1*/
    $(document).off('dblclick.r1_hide').on('dblclick.r1_hide', '.r1_hide', function(event){
        if(confirm('Убрать этот заказ из выдачи отчета Р-1? Он не будет появляться в этом списке, пока вы не измените' +
                ' его статус в списке расценок из вкладки "Заявки"')){
            var reqid = $(event.target).attr('requestid');
            var byerid = $(event.target).attr('byerid');
            console.log(reqid);
            console.log(byerid);
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {r1_hide_reqid:reqid},
                success: function (data) {//Изменяем
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                },complete: function (data) {
                    $.ajax({//Чтение
                        url: 'mysql_giveaways.php',
                        method: 'POST',
                        data: {the_byer:byerid},
                        success: function (data) {
                            $('.ga_byer_requests[ga_byer=' + byerid + ']').html(data);
                        }
                    });
                }

            });
        }
    });
    /**/

    /*ВОЗВРАЩЕНИЕ ЗАКАЗА В ВЫДАЧУ Р-1*/
    $(document).off('dblclick.r1_show').on('dblclick.r1_show', '.r1_show', function(event){
        if(confirm('Вернуть этот заказ в выдачу отчета Р-1? Он будет появляться в Р-1, пока вы не измените' +
                ' его статус во вкладке "Р-1"')){
            var reqid = $(event.target).attr('requestid');
            console.log(reqid);
            $.ajax({
                url: 'mysql_save.php',
                method: 'POST',
                data: {r1_show_reqid:reqid},
                success: function (data) {//Изменяем
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                },
                complete:function () {
                    $.ajax({
                        url: 'mysql_read.php',
                        method: 'POST',
                        data: {requestid:reqid},
                        success: function (data) {
                            $('input[requestid='+reqid+'] ~ div div.positions').html(data);
                        }
                    });
                }
            });
        }
    });
    /**/

    /*Уточнение по скрыванию заказов в Р-1*/
    $(document).off('click.r1_showhide').on('click.r1_showhide', '.r1_show, .r1_hide', function(event){
            $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html('<span>Чтобы убрать заказ из Р-1, двойной клик по кнопке и подтверждение.</span>');
    });
    /**/

    /*Скролл к верху страницы в списке товаров*/
    $(document).off('click.go_up').on('click.go_up', '#go_up', function(event){
        if($('#pricingwindow').is(":visible")){
            window.scrollTo(0, 99 * window.innerHeight/100);
        }else{
            window.scrollTo(0, 0);
        };

    });
    /**/

    //Открытие/Закрытие списка заказов в Раскатах Грома
    $(document).off('click.totals').on('click.totals', '.collapse_totals_byer', function(event){
        var t_b = $(event.target).attr('totals_byer');
        if($('.totals_byer_requests:visible').length > 0){
            $('.collapse_totals_byer').val('♢').css({'background-color':'white','color':'black'});//Меняем кнопку
            $(event.target).siblings('.totals_byer_requests').toggle();//Скрываем внутренность
            $(event.target).parents('tr[byerid]').toggleClass('widen_totals');//Уменьшаем внутренность
            $('.byer_req_list_totals tr[byerid]').toggle();
            $('.byer_req_list_totals tr[byerid='+t_b+']').toggle();//Кроме этой самой
        }else{
            $(event.target).val('X').css({'background-color':'red','color':'white'});//Меняем кнопку
            $(event.target).siblings('.totals_byer_requests').toggle();//Показываем внутренность
            $(event.target).parents('tr[byerid]').toggleClass('widen_totals');//Расширяем внутренность
            $('.byer_req_list_totals tr[byerid]').toggle();//Скрываем все строки
            $('.byer_req_list_totals tr[byerid='+t_b+']').toggle();//Кроме этой самой

        }

    });

    $(document).off('click.totals_glist').on('click.totals_glist', '.collapse_totals_g_list', function(event){
        if($('.totals_g_list:visible').length > 0){
            $('.collapse_totals_g_list').val('♢').css({'background-color':'white','color':'black'});//Меняем кнопку
            $(event.target).next('.totals_g_list').toggle();//Скрываем внутренность
        }else{
            $(event.target).val('X').css({'background-color':'red','color':'white'});//Меняем кнопку
            $(event.target).next('.totals_g_list').toggle();//Скрываем внутренность
        }

    });

    $(document).off('click.show_hr1').on('click.show_hr1', '.green, .lightgreen, .yellow, .lightblue, .red', function(event){
        $(event.target).children('input').toggle();
    });

    $(document).off('click.r1span').on('click.r1span', '.green span, .lightgreen span, .yellow span, .lightblue span, .red span', function(event){
        $(event.target).next('input').trigger('click.show_hr1');
    });



});
