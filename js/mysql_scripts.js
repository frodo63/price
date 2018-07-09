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

        if ($('div.ga_byer_requests:visible').length > 0){

            //ДОбавить красные крестики при открытии/закрытии, закончить с ервым уровнем.

            $('div.ga_byer_requests:visible').slideUp(400);
            //Закрываем открытое
            //Закрываем старое
            //Открываем новое
            $('.ga_byer_requests[ga_byer='+the_byer+']').slideDown(400);
            $.ajax({
                url: 'mysql_giveaways.php',
                method: 'POST',
                data: {the_byer:the_byer},
                success: function (data) {
                    $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                }
            });
            /*КНОПОЧКИ*/
            $(event.target).val('W').css({'background-color' : 'white','color' : 'black'});
            /**/
        }else{

            //Просто открываем новое
            $('.ga_byer_requests[ga_byer='+the_byer+']').slideDown(400);
            $.ajax({
                url: 'mysql_giveaways.php',
                method: 'POST',
                data: {the_byer:the_byer},
                success: function (data) {
                    $('.ga_byer_requests[ga_byer='+the_byer+']').html(data);
                }
            });
            /*КНОПОЧКИ*/
            $(event.target).val('X').css({'background-color' : 'red','color' : 'white'});
            /**/
        }


    });
    /**/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*СПИСОК ЗАЯВОК В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ////////////////////////////////////////////////////////////////////////*/
    $(document).off('click.ga_contents').on('click.ga_contents', '.collapse_ga_request', function () {
        var the_request = $(event.target).attr('ga_request');
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



});
