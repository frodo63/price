$(document).ready(function(){
/*Описание поведения блоков поисковой строки*/

    $(document).off('click.out').on('click.out', 'body', function () {
        $('#sres ul').html('');
        $('.sres ul').html('');
        $('#byer+div ul').html('');
        $('#trade+div ul').html('');
        $('#seller+div ul').html('');
    });

    /*Поведение ВЕЛИКОЙ СТРОКИ ПОИСКА ВСЕГО (ВСПВ)*/
    $(document).off('mouseenter.sres').on('mouseenter.sres', '#sres ul li', function (event) {
        /*После выпадения списка в бпс при клике попадает текст итема.*/
        $('#thesearch').val($(event.target).children('span').text());
        /*А атрибуты - категория и айдишник*/
        $('#thesearch').attr('category', $(event.target).attr('category'));
        $('#thesearch').attr('theid', $(event.target).attr('theid'));
        console.log('Категория: '+$('#thesearch').attr('category')+', ID: '+$('#thesearch').attr('theID'));
        /*Мы готовы для аякса*/
    });
    /*Клик на элементе выпадающего списка из ВСПВ*/
    /*На клике отключено событие скрывания списка по нажатию на что-либо*/

    $(document).off('click.sres').on('click.sres', '#sres ul li', function (event) {
        var category = $(event.target).attr('category');
        var theid = $(event.target).attr('theid');
        var table = 'requests';
        //TODO: Вставить проверку, что айди и категория - not undefined
        console.log('На аякс: категория: '+category+', ID: '+theid+'.');
        if (!!category && !!theid){
            $.ajax({
                url: 'mysql_read.php',
                method: 'POST',
                data: {table:table, category:category, theid:theid },
                success: function(data){
                    $('#reads').slideUp();
                    $('#search_reads').show();
                    $('#search_reads div.requests_list').html(data);
                },
                complete: function() {
                    if(category == 'request'){
                        $('.collapse').trigger('click.collapse');
                    };
                    $('html, body').animate({scrollTop: $("#thesearch").offset().top}, 1000);
                }
            });
        }
    });

    /*При изменении текста должен меняться атрибут #byer - byer_id, #seller - seller_id, #trade - trade_id*/
    $(document).off('click.sresseller').on('click.sresseller', '#seller+div ul li p', function (event) {
        $('#seller').val($(event.target).text());
        $('#seller').attr('seller_id', $(event.target).parent().attr('sellers_id'));
    });

    $(document).off('click.sresbyer').on('click.sresbyer', '#byer+div ul li p', function (event) {
        $('#byer').val($(event.target).text());
        $('#byer').attr('byer_id', $(event.target).parent().attr('byers_id'));
    });

    $(document).off('click.srestrade').on('click.srestrade', '#trade+div ul li p', function (event) {
        $('#trade').val($(event.target).text());
        var tradeid = $(event.target).parent().attr('trades_id');
        console.log(tradeid);
        $('#trade').attr('trade_id', tradeid);
        $('#button_history').attr('hist_trade', tradeid);//Добавление трейдайди в атрибут инфокнопки и стории для окончательного запроса
    });




    /*Описание поведения элементов выпадающего списка ВСПВ Подключение кнопок клавиатуры*/
    /*ВЕЛИКАЯ СТРОКА ПОИСКА ВСЕГО*/
    /*Описан выпадающий список*/
    $(document).off('keyup.sline').on('keyup.sline', '#thesearch', function (event) {
        var sline = $('#thesearch').val();
        if(event.which === 40||event.which === 39) {
            if($('#sres ul li').length > 0) {
                if ($('#sres ul li.sreslihover').length > 0) {
                    var slh = $('#sres ul li.sreslihover').index();
                    console.log(slh);
                    $('#sres ul li:eq(' + slh + ')').removeClass('sreslihover');
                    slh++;
                    console.log(slh);
                    $('#sres ul li:eq(' + slh + ')').trigger('mouseenter.sres').addClass('sreslihover');
                } else {
                    $('#sres ul li:eq(0)').trigger('mouseenter.sres').addClass('sreslihover');
                }
                ;
            };
        } else if(event.which === 38||event.which === 37) {
            if($('#sres ul li').length > 0){
                if($('#sres ul li.sreslihover').length > 0){
                    var slh = $('#sres ul li.sreslihover').index();
                    console.log(slh);
                    $('#sres ul li:eq('+slh+')').removeClass('sreslihover');
                    slh--;
                    console.log(slh);
                    $('#sres ul li:eq('+slh+')').trigger('mouseenter.sres').addClass('sreslihover');
                }else{
                    $('#sres ul li:eq(0)').trigger('mouseenter.sres').addClass('sreslihover');
                };
            };
        } else if(event.which === 13){
            $('#sres ul li.sreslihover').trigger('click.sres').bind('click.out').trigger('click.out');
            /*Как-то закрыть список результатов поиска*/

        } else if (event.which === 27){
            $('#thesearch').trigger('click.out');
        } else{
            if (sline.length > 0) {

                console.log(sline);

                $.ajax({
                    context : $('#thesearch'),
                    url: 'mysql_search.php',
                    method: 'POST',
                    data: {sline:sline},
                    success: function (data) {
                        $('#sres').html(data);
                    }

                });
            };
        };

    });

    /*ДОбавление нового в таблицы по нажатию на Enter*/
    $(document).off('keyup.addtab').on('keyup.addtab', '.creates input[type="text"]', function (event) {
        if(event.which === 13){
            $(event.target).next('input[type="button"]').trigger('click.addtab');
        };
    })

    /*ПОИСКОВЫЕ СТРОКИ ПОКУПАТЕЛЬ, ТОВАР, ПОСТАВЩИК*/
    $(document).off('keyup.byer').on('keyup.byer', '#byer', function(event){

        var sbyer = $('#byer').val();

        if (sbyer.length > 0) {

            console.log(sbyer);

            $.ajax({
                context : $('#byer'),
                url: 'mysql_search.php',
                method: 'POST',
                data: {sbyer:sbyer},
                success: function (data) {
                    $(event.target).next().html(data);
                }

            });
        };

    });

    $(document).off('keyup.seller').on('keyup.seller', '#seller', function(event){

        var sseller = $('#seller').val();

        if (sseller.length > 0) {

            console.log(sseller);

            $.ajax({
                context : $('#seller'),
                url: 'mysql_search.php',
                method: 'POST',
                data: {sseller:sseller},
                success: function (data) {
                    $(event.target).next().html(data);
                }

            });
        };

    });

    $(document).off('keyup.trade').on('keyup.trade', '#trade', function(event){

        var strade = $('#trade').val();

        if (strade.length > 0) {

            console.log(strade);

            $.ajax({
                context : $('#trade'),
                url: 'mysql_search.php',
                method: 'POST',
                data: {strade:strade},
                success: function (data) {
                    $(event.target).next().html(data);
                }

            });
        };

    });

    /*СТРОКА НОМЕНКЛАТУРЫ В ИМЕНИ ПОЗИЦИИ*/
    $(document).off('keyup.tradeclass').on('keyup.tradeclass', '.trade', function(event){

        var strade = $(event.target).val();

        if (strade.length > 0) {

            console.log(strade);

            $.ajax({
                context : $(event.target),
                url: 'mysql_search.php',
                method: 'POST',
                data: {strade:strade},
                success: function (data) {
                    $(event.target).next('.sres').html(data);
                }

            });
        };

    });

    //TODO:код_тут. фак, кто это за код?
    $(document).off('click.addpostrade', 'click.out').on('click.addpostrade', '.add-pos-inputs .sres ul li p', function (event) {
        var txt = $(event.target).text();
        $(event.target).parents('.sres').siblings('input.trade').val(txt);
        $(event.target).parents('.sres').html('');
    } );
    /*////////////////////////////////////////////////////////////////////////////////*/









})
