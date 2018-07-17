$(document).ready(function(){
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ЕНОТОПРОЦЕНТА
    $('#tp').change(function(){
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').val()).toFixed(3));      //Транспортные (на шт)
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)

            //Изменяется еноторубль
            $('#tpr').text(((zak+tzr)*(1+op/100)*(tp/100)).toFixed(2));
            var tpr = Number($('#tpr').text());
            var firstobp = Number($('#firstobp').val());
            //Изменяется обналорубль
            $('#firstobpr').text((tpr*firstobp/100).toFixed(2));
            var firstobpr =  Number($('#firstobpr').text());
            //Изменяется первое на руки
            $('#firstoh').text((tpr - firstobpr).toFixed(2));
            //Стираются все переменные
            zak = tzr = tp = op = tpr = obp = firstobpr = null;
            //И расчет цены
            givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ НАШЕГО ПРОЦЕНТА
    $('#op').change(function(){
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').val()).toFixed(3));      //Транспортные (на шт)
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)

            //Изменяются наши рубли
            $('#opr').text(((op/100)*(zak+tzr)).toFixed(2));
            var opr = (zak+tzr)*(op/100);
            //Изменяется еноторубль
            $('#tpr').text((((zak+tzr) + opr) * (tp/100)).toFixed(2));
            var tpr = Number($('#tpr').text());
            var obp = Number($('#firstobp').val());
            //Изменяется обналорубль
            $('#firstobpr').text((tpr*obp/100).toFixed(2));
            var firstobpr =  Number($('#firstobpr').text());
            //Изменяется первое на руки
            $('#firstoh').text((tpr - firstobpr).toFixed(2));
            //Стираются все переменные
            zak = tzr = tp = op = tpr = obp = opr = firstobpr = null;
            //И расчет цены
            givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ОТСРОЧКИ
    $('#wtime').change(function () {
        //Изменяется количество дней
        var wtime = Number(Number($('#wtime').val()).toFixed(2));
        $('#wtimeday').text((wtime/0.0334).toFixed(0));
        //Стираем переменнные
        wtime = null;
        //Идет расчет цены
        givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ НАШЕЙ ЦЕНЫ
    $('#zak').change(function () {
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').val()).toFixed(3));      //Транспортные (на шт)
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)

        //Изменяются наши проценторубли
        $('#opr').text(((op/100)*(zak+tzr)).toFixed(2));
        var opr = (zak+tzr)*(op/100);
        //Изменяется еноторубль
        $('#tpr').text((((zak+tzr) + opr) * (tp/100)).toFixed(2));
        var tpr = Number($('#tpr').text());
        var obp = Number($('#firstobp').val());
        //Изменяется обналорубль
        $('#firstobpr').text((tpr*obp/100).toFixed(2));
        var firstobpr =  Number($('#firstobpr').text());
        //Изменяется первое на руки
        $('#firstoh').text((tpr - firstobpr).toFixed(2));
        //Стираются все переменные
        zak = tzr = tp = op = tpr = obp = opr = firstobpr = null;
        //И расчет цены
        givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ТЗР
    $('#tzr').change(function () {
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').val()).toFixed(3));      //Транспортные (на шт)
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var obtzr = Number(Number($('#obtzr').val()).toFixed(3));

        //Изменяются наши проценторубли
        $('#opr').text(((op/100)*(zak+tzr)).toFixed(2));
        var opr = (zak+tzr)*(op/100);
        //Изменяется еноторубль
        $('#tpr').text((((zak+tzr) + opr) * (tp/100)).toFixed(2));
        var tpr = Number($('#tpr').text());
        var obp = Number($('#firstobp').val());
        //Изменяется обналорубль
        $('#firstobpr').text((tpr*obp/100).toFixed(2));
        var firstobpr =  Number($('#firstobpr').text());
        //Изменяется первое на руки
        $('#firstoh').text((tpr - firstobpr).toFixed(2));
        //Изменяется обналотзр
        $('#obtzr').text((tzr*(1-(obp/100))).toFixed(2));
        //Стираются все переменные
        zak = tzr = tp = op = tpr = obp = opr = firstobpr = null;
        //И расчет цены
        givePrice();
    });

    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*ИЗМЕНЕНИЕ ПЕРВОГО ОБНАЛОПРОЦЕНТА*/
    $('#firstobp').change(function () {
        var firstobp = Number(Number($('#firstobp').val()).toFixed(1));      //Процент обнала
        var tzr = Number(Number($('#tzr').val()).toFixed(3));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));
        //Изменяется еноторубль
        $('#firstobpr').text((tpr - (tpr*((100-firstobp)/100))).toFixed(2));
        var firstobpr = Number(Number($('#firstobpr').text()).toFixed(2));
        //Изменяется первое на руки
        $('#firstoh').text((tpr - firstobpr).toFixed(2));
        //Новый обнал идет вниз в функцию зафиксированной цены
        $('#obp').val(Number(Number($('#firstobp').val()).toFixed(1)));
        //Следом внизу в зафиксированной цене изменяется и на руки
        //Изменяется обналотзр
        $('#obtzr').text((tzr*(1-(firstobp/100))).toFixed(2));
        //Удаляем все переменные
        firstobp = tpr = firstobpr = null;
        //И считаем цену
        givePrice();
    });

    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*ИЗМЕНЕНИЕ ФИКС ОБНАЛОПРОЦЕНТ*/
    $('#obp').change(function () {
        var obp = Number(Number($('#obp').val()).toFixed(0));      //Процент обнала
        var rtp = Number(Number($('#rtp').val()).toFixed(0));
        //Изменяются фикс обналорубли
        $('#oh').text((rtp*((100-obp)/100)).toFixed(0));
        //Отправляется новый обналопроцент вверх в формулу отпущенной цены
        $('#firstobp').val(Number(Number($('#obp').val()).toFixed(2)));


    });

    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*$('#price').submit(function(event) {*/
    $('#go').off('click.pricecount').on('click.pricecount', function(event){
        event.preventDefault();
        if
        (
            $('#zak').val() == 'undefined' ||
            $('#kol').val() == 'undefined' ||
            $('#op').val() == 'undefined' ||
            $('#zak').val() <= 0 ||
            $('#kol').val() <= 0 ||
            $('#op').val() <= 0 ||
            $('#tzr').val() < 0 ||
            $('#tp').val() < 0
        )
        {
            console.log("first");
            return false;
        } else {
            console.log("second");
            givePrice();
        }
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //Главная функция
    function givePrice(){
        //Переменные
        var lzak = Number($('#zak').val());    //Закупочная цена (за 1 единицу товара)
        var lkol = Number($('#kol').val());    //Количество товара
        var ltzr = Number($('#tzr').val());    //Транспортные (общая сумма за рейс)
        var ltp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных двух знаков)
        var wt = Number(Number($('#wtime').val()).toFixed(2));        //Отсрочка платежа, в месяцах, нужна при расчете рентабельности
        var lop = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных двух знаков)
        var fobp = Number(Number($('#firstobp').val()).toFixed(0));
        var firstobpr = Number($('#firstobpr').text());
        var uid = Number($('#id').text());


        //РАСЧЕТ ЦЕНЫ И РЕНТАБЕЛЬНОСТИ ПРИ ЗАФИКСИРОВАННОЙ ЦЕНЕ
        if ($('#fixate').hasClass('active')){
            console.log('active fixate');
            var fixed = 1;
            var lprice = Number($('#pr').val());
            var rop = Number(Number($('#rop').val()).toFixed(1));   //НАМ р
            var rtp = Number(Number($('#rtp').val()).toFixed(1));   //ИМ р
            var oh = Number($('#oh').text());
            var marge = Number(Number($('#marge').text()).toFixed(0));
            var margek = Number(Number($('#margek').text()).toFixed(0));
            var realop = ((rop / margek)*100).toFixed(0);
            var realtp = Number(((rtp / margek)*100).toFixed(0));
            var obp = Number(Number($('#obp').val()).toFixed(1));
            var wt = Number(Number($('#wtime').val()).toFixed(2));        //Отсрочка платежа, в месяцах, нужна при расчете рентабельности
            var clearp = ((oh/lprice)*100).toFixed(2);
            /*Расчет рентабельности*/
            var lrentS = (rop * (1 - 0.015*wt))/lprice*100;
            $('#rent h1').text((lrentS).toFixed(3) + ' %');

            var pricetext = '<p>Цена: <b>' + (lprice).toFixed(2) + '</b> При расчете : ' +
                '<br>НАМ: ' +
                //Нам чистыми на 1 шт
                (rop).toFixed(2) + 'руб. за шт.' + ' <br>/<br> НЕ НАМ: ' +
                //Им чистыми за 1 шт
                (oh).toFixed(2) + 'руб. за шт.' +
                '<br> Что есть ' + ((oh/lprice)*100).toFixed(2) + ' % чистыми от суммы при обнале ' + obp +
                '%. <br>С рентабельностью: ' + (lrentS).toFixed(3) + '%.<br/>' +
                //Кнопка сохранить результат
                '<br>' + '<input type="submit" name="save" id="save" value="Сохранить этот результат" />';
            $('#cases').html(pricetext);
            pricetext = null;
            $('#cases').slideDown();


        }
        else
        {
            console.log('INactive fixate');
            /*////////////////////////////////////////////////////////////////////////////////////////////////////*/
            /*РАСЧЕТ ЦЕНЫ И РЕНТАБЕЛЬНОСТИ ПРИ ОТПУЩЕННОЙ ЦЕНЕ*/
            /*Расчет цены*/
                var fixed = 0;
                var lprice = ( (lzak + ltzr) + ((lzak + ltzr) * (lop/100)) ) +
                    ( (lzak + ltzr) + ((lzak + ltzr) * (lop/100)) ) * (ltp/100);

                $('#pr').val((lprice).toFixed(2));
            //Высчитываем РЕАЛЬНЫЙ процент (для наруки)
                var firstoh = Number((Number($('#firstoh').text())).toFixed(2));
                var clearp = firstoh/lprice*100;
                $('#clearp').text((clearp).toFixed(3) + ' %');
                var opr = Number((Number($('#opr').text())).toFixed(2));

                /*Расчет рентабельности*/
                var lrentS = (opr*(1-0.015*wt))/lprice*100;
                $('#rent h1').text((lrentS).toFixed(3) + ' %');


                //Разбили прайстекст на составляющие

                var pricetext = '<p>Цена: <b>' + (lprice).toFixed(2) + '</b> При расчете :<br>' +
                    'НАМ: '+
                    //Нам чистыми на 1 шт
                    ((lzak + ltzr) * (lop/100)).toFixed(2) + ' руб. за шт.' + '<br>/<br>' +
                    //НЕ наш процент
                    'НЕ НАМ: '+
                    //Им чистыми за 1 шт
                    ( ( ((lzak+ltzr) * (1+lop/100)) ) * (ltp/100) ).toFixed(2) + 'руб. за шт.' +
                    '<br>Чистыми : ' + (clearp).toFixed(3) + ' %' +
                    '<br> На руки: ' + (Number((((lzak+ltzr) + ((lzak+ltzr) * (lop/100)) ) * (ltp/100)).toFixed(2)) - firstobpr).toFixed(2) + ' руб. с 1 шт.' +
                    '<br>При рентабельности: ' + (lrentS).toFixed(3) + ' % <input type="submit" name="save" id="save" value="Сохранить этот результат" />';
                $('#cases').html(pricetext);
                pricetext = null;
                $('#cases').slideDown();


                //Эти две переменные зявляются для подготовки отправки формы POST
                var ltpr = ( (lzak+ltzr) + ((lzak+ltzr) * (lop/100)) ) * (ltp/100);
                var lopr = (lzak + ltzr) * (lop/100);

                $('#obnal, #fixate').slideDown();
        }


        /*////////////////////////БЛОК ОТПРАВКИ ФОРМЫ В БАЗУ///////////////////////////*/
        $(document).off('click.pricesave').on('click.pricesave', '#save', function(event){
            event.preventDefault();//Если эту херню не поставить, аякс-запрос будет постоянно отменяться (status=cancelled). Потому что у кнопки сейв был тайп = сабмит. Нужно
            // было ллибо его убрить, изменить на буттон, либо превент дефолт. ПОэтому отправлялся неполный формдата, который составляет как раз результат .serialize
                if (
                    $('#trade').val() != "" &&
                    $('#seller').val() != ""
                    )
                {
                 var positionID = $('#pricingwindow').attr('positionid');
                 var pricingID = $('#pricingwindow').attr('pricingid');

                 var formData =
                     '&trade=' + $('#trade').attr('trade_id') +
                     '&seller=' + $('#seller').attr('seller_id') +
                     '&zak=' + Number($('#zak').val()) +
                     '&kol=' + Number($('#kol').val()) +
                     '&tzr=' + Number($('#tzr').val()) +
                     '&op=' + Number(Number($('#op').val()).toFixed(3)) +
                     '&tp=' + Number(Number($('#tp').val()).toFixed(3)) +
                     '&firstobp=' + Number(Number($('#firstobp').val()).toFixed(0)) +
                     '&wtime=' + Number(Number($('#wtime').val()).toFixed(2)) +
                     '&obp=' + Number(Number($('#obp').val()).toFixed(1)) +
                     '&price=' + lprice +
                     '&firstoh=' + firstoh +
                     '&rent=' + lrentS +
                     '&tpr=' + ltpr +
                     '&opr=' + lopr +
                     '&fixed=' + fixed +
                     '&firstobpr=' + firstobpr +
                     '&rop=' + rop +
                     '&rtp=' + rtp +
                     '&realop=' + realop +
                     '&realtp=' + realtp +
                     '&oh=' + oh +
                     '&marge=' + marge +
                     '&margek=' + margek +
                     '&clearp=' + clearp;
                if(positionID != '-'){
                    formData += '&positionid=' + positionID;
                    console.log(formData);
                    //Аякс скрипт на savepricing
                    $.ajax({
                        url: 'mysql_save.php',
                        method: 'POST',
                        data: formData,
                        success: function (data) {
                            $('#editmsg').css("display", "block"). delay(1000).slideUp(300).html(data);
                        },
                        complete: function () {
                            $.ajax({
                                url: 'mysql_read.php',
                                method: 'POST',
                                data: {positionid:positionID},
                                success: function (data) {
                                    $('input[position='+positionID+'] ~ div.pricings').html(data);
                                }
                            });
                        }
                    });
                }else{
                    formData += '&pricingid=' + pricingID;
                    console.log(formData);
                    //Аякс скрипт на editpricing
                    $.ajax({
                        url: 'mysql_save.php',
                        method: 'POST',
                        data: formData,
                        success: function (data) {
                            $('#editmsg').css("display", "block"). delay(1000).slideUp(300).html(data);
                        }
                    });
                };

                } else {
                    alert("Для добавления в базу заполните поля: \n'Товар', \n'Поставщик'.")
                };
        });
    }
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ЗАКРЕПЛЕНИЕ ЦЕНЫ
    $('#fixate').click(function () {
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(0));      //Закупочная цена (за 1 единицу товара)
        var kol = Number(Number($('#kol').val()).toFixed(0));      //Количество товара
        var tzr = Number(Number($('#tzr').val()).toFixed(0));      //Транспортные (общая сумма за рейс)
        var tp = Number(Number($('#tp').val()).toFixed(0));        //Ненаша наценка (в формате десятичных двух знаков)
        var op = Number(Number($('#op').val()).toFixed(0));        //Наша наценка (в формате десятичных двух знаков)
        var obp = Number(Number($('#obp').val()).toFixed(0));      //Процент обнала
        var price = Number($('#pr').val());                        //Новая цена попадает в переменную price


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Магия с кнопочками. Получилось на 50й раз, только через .attr
        $('#fixate').toggleClass('active');

        if ($('#fixate').attr("value") == "Закрепить"){
            $('#pr').css("font-weight", "bold");
            $('#pr').css("border", "solid 2px red");
            $('#go').slideUp();
            $('#go').animate({
                top:  "90vh",
                right: "56.5vw"
            });
            $('#go').slideDown();
            $('#fcount').css("opacity", "0.2");
            $('#cases').slideUp();
            $('#fixate').attr("value", "Отпустить");

        /*////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

            var marge = (price * kol) - ( (zak+tzr) * kol );
            $('#marge').text((marge).toFixed(0));
            var margek = marge / kol;
            $('#margek').text((margek).toFixed(0));
            $('#margediv').slideDown();

            //ЕНОТ%, новый ЕНОТОРУБЛЬ ОТМЕНЕН!!!
            var tmarge = price*((tp)/100);

            $('#rop').val( Number(((marge/kol) - tmarge).toFixed(0)) );
            $('#rtp').val( Number((tmarge).toFixed(0)) );

            //Только после пересчета устанавливаем переменные
            var rop = Number(Number($('#rop').val()).toFixed(0));
            var rtp = Number(Number($('#rtp').val()).toFixed(0));
            //И высчитываем соотношение
            $('#realop').text( ((rop / margek)*100).toFixed(0) + '%, от маржи.');
            $('#realtp').text( ((rtp / margek)*100).toFixed(0) + '%, от маржи.');

            //ОБНАЛ - окончательный ЕНОТОРУБЛЬ
            var tmargeo = tmarge - (tmarge * (obp / 100));
            $('#oh').text((tmargeo).toFixed(2));
        }
        else {
            /*//////////////////////////////////////*/
            //Красота
            $('#fixate').attr("value", "Закрепить");
            $('#pr').css("font-weight", "normal");
            $('#pr').css("border", "solid 2px white");
            $('#go').slideUp();
            $('#go').animate({
                top:  "10vh",
                right: "1vw"
            });
            $('#fcount').css("opacity", "1")
            $('#go').slideDown();
            $('#cases').slideUp();
            /*///////////////////////////////////////*/
            $('#margediv').slideUp();
            $('#rop, #rtp').val("");
            $('#realop, #realtp, #oh').text("");

        }
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //СООТНОШЕНИЕ ВНУТРИ МАРЖИ
    $('#rtp').change(function () {
        var zak = Number(Number($('#zak').val()).toFixed(0));      //Закупочная цена (за 1 единицу товара)
        var kol = Number(Number($('#kol').val()).toFixed(0));      //Количество товара
        var tzr = Number(Number($('#tzr').val()).toFixed(0));      //Транспортные (общая сумма за рейс)
        var tp = Number(Number($('#tp').val()).toFixed(0));        //Ненаша наценка (в формате десятичных двух знаков)
        var op = Number(Number($('#op').val()).toFixed(0));        //Наша наценка (в формате десятичных двух знаков)
        var obp = Number(Number($('#obp').val()).toFixed(2));      //Процент обнала
        var price = Number($('#pr').val());                        //Новая цена попадает в переменную price
        var marge = (price * kol) - ( (zak+tzr) * kol );
        var margek = marge / kol;

        //Задал пределы изменения rop и rtp - больше нуля и меньше маржи на шт
        if($('#rtp').val() > 0 && $('#rop').val() > 0 && $('#rtp').val() < margek)
        {
            $('#rop').val((margek - Number($(this).val())).toFixed(0));
            var rop = Number(Number($('#rop').val()).toFixed(0));
            var rtp = Number(Number($('#rtp').val()).toFixed(0));

            $('#realtp').text( ((rtp / margek)*100).toFixed(0) + '%, от маржи.');
            $('#realop').text( ((rop / margek)*100).toFixed(0) + '%, от маржи.');
            $('#oh').text((rtp*((100-obp)/100)).toFixed(0));
        }

        if($('#rtp').val() > margek)
        {
            $('#rtp').val(margek);
        }
        givePrice();

    });
    $('#rop').change(function () {
        var zak = Number(Number($('#zak').val()).toFixed(0));      //Закупочная цена (за 1 единицу товара)
        var kol = Number(Number($('#kol').val()).toFixed(0));      //Количество товара
        var tzr = Number(Number($('#tzr').val()).toFixed(0));      //Транспортные (общая сумма за рейс)
        var tp = Number(Number($('#tp').val()).toFixed(0));        //Ненаша наценка (в формате десятичных двух знаков)
        var op = Number(Number($('#op').val()).toFixed(0));        //Наша наценка (в формате десятичных двух знаков)
        var obp = Number(Number($('#obp').val()).toFixed(2));      //Процент обнала
        var price = Number($('#pr').val());                        //Новая цена попадает в переменную price
        var marge = (price * kol) - ( (zak+tzr) * kol );
        var margek = marge / kol;

        if($('#rtp').val() > 0 && $('#rop').val() > 0 && $('#rop').val() < margek)
        {
            $('#rtp').val((margek - Number($(this).val())).toFixed(0));
            var rop = Number(Number($('#rop').val()).toFixed(0));
            var rtp = Number(Number($('#rtp').val()).toFixed(0));

            $('#realtp').text( ((rtp / margek)*100).toFixed(0) + '%, от маржи.');
            $('#realop').text( ((rop / margek)*100).toFixed(0) + '%, от маржи.');
            $('#oh').text((rtp*((100-obp)/100)).toFixed(0));
        }

        if($('#rop').val() > margek)
        {
            $('#rop').val(margek);
        }
        givePrice();
    });


















































































})















