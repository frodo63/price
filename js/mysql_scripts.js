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
        if($(event.target).attr('name') == 'requests'){//Добавляем заявку?
            var byer = $('#byer').attr("byer_id");
            var thename = $('#req_name').val();
            console.log(byer);
            console.log(thename);

            if(thename!='' && byer > 0){
                $.ajax({
                    url: 'mysql_insert.php',
                    method: 'POST',
                    data: {byer:byer, thename:thename},
                    success: function (data) {
                        $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                        $('#creates input[type=\'text\']').val('');
                    },
                    complete: function() {$('a[href = "#requests"]').trigger('click');
                    }
                });
            } else {alert("Чето вы не то ввели. Там же две графы всего, разве это так сложно?")};
        }else{
            var table = $(event.target).attr("name");
            var thename = $(event.target).prev().val();
            var addinput = $(event.target).prev('input[type="text"]');
                    if(thename!=''){
                        $.ajax({
                            url: 'mysql_insert.php',
                            method: 'POST',
                            data: {table:table, thename:thename},
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
                   $('.' + table + '_list').html(data);
                },
                complete: function(){
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html("Данные из таблицы " + table + " получены.");
                    $('.creates input[type=\'text\']').val('');
                }
            });
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
                }
            });
        }
    });
    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*СПИСОК ЗАЯВОК В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ////////////////////////////////////////////////////////////////////////*/
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
            }
        });
    });
    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*Подготовка формы добавления платежки*/////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_payment_prep').on('click.add_payment_prep', '.add_payment', function(event){
        var reqid = $(event.target).attr("requestid");
        $('#button_add_payment').attr("requestid", reqid);
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //ДОБАВЛЕНИЕ ПЛАТЕЖКИ///////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_payment').on('click.add_payment', '#button_add_payment', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения платежки*/
        var date = $('#add_payment.come_here #add_payment_date').val();
        var num = $('#add_payment.come_here #add_payment_1c_num').val();
        var comment = $('#add_payment.come_here #add_payment_comment').val();
        var sum = $('#add_payment.come_here #add_payment_sum').val();
        console.log(date);
        console.log(num);
        console.log(comment);
        console.log(sum);



        /*//////////////////////////////*/

           /* $.ajax({
                url: 'mysql_insert.php',
                method: 'POST',
                data: {reqid:reqid, posname:posname},
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
        } else {alert("Введите имя позиции")};*/
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /*Подготовка формы добавления выдачи*///////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_giveaway_prep').on('click.add_giveaway_prep', '.add_giveaway', function(event){
        var reqid = $(event.target).attr("requestid");
        $('#button_add_giveaway').attr("requestid", reqid);
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //ДОБАВЛЕНИЕ ВЫДАЧИ/////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.add_giveaway').on('click.add_giveaway', '#button_add_giveaway', function(event){
        var reqid = $(event.target).attr("requestid");
        /*Данные для заполнения выдачи*/
        var date = $('#add_giveaway.come_here #add_giveaway_date').val();
        var comment = $('#add_giveaway.come_here #add_giveaway_comment').val();
        var sum = $('#add_giveaway.come_here #add_giveaway_sum').val();
        console.log(date);
        console.log(comment);
        console.log(sum);



        /*//////////////////////////////*/

        /* $.ajax({
             url: 'mysql_insert.php',
             method: 'POST',
             data: {reqid:reqid, posname:posname},
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
     } else {alert("Введите имя позиции")};*/
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.comepayment').on('click.comepayment', 'input.add_payment, .close_add_p', function () {
        $('#add_payment').toggleClass('come_here', 1000);
        $('#add_payment>input[name=1]').val('-');//Стираем все данные
        console.log('первый');
        $('#add_payment>input[name=2]').val('-');//Стираем все данные
        console.log('второй');
        $('#add_payment>input[name=3]').val('-');//Стираем все данные
        console.log('третий');
        $('#add_payment>input[name=4]').val('-');//Стираем все данные
        console.log('четвертый');
        $('#button_add_payment').attr('requestid','');//Стираем номер заявки из кнопки добавления

    });

    $(document).off('click.comegiveaway').on('click.comegiveaway', 'input.add_giveaway, .close_add_g', function () {
        $('#add_giveaway').toggleClass('come_here', 1000);
        $('#add_giveaway>input[name=1]').val('');//Стираем все данные
        $('#add_giveaway>input[name=2]').val('');//Стираем все данные
        $('#add_giveaway>input[name=3]').val('');//Стираем все данные
        $('#button_add_giveaway').attr('requestid','');//Стираем номер заявки из кнопки добавления
    });

    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



});
