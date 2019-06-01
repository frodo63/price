$(document).ready(function(){
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ЗАКУПА
    $('#zak').change(function () {
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));


        //Изменение отсрочкорублей
        $('#wtr').text(Number((a*0.0125*wt).toFixed(2)));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //Изменение проценторублей
        $('#opr').text(Number(((a+wtr)*op/100).toFixed(2)));
        var opr = Number($('#opr').text());

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+(a+wtr)*op/100)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));;
        var firstobpr =  Number($('#firstobpr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=tpr=firstobpr=null;
        //Идет расчет цены
        givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ТЗР К НАМ
    $('#tzrknam').change(function () {
        console.log('Изменяется tzrknam');
        //Переменные
        var tzrknam = Number(Number($('#tzrknam').val()).toFixed(3));      //Транспортные до нашего склада (на шт)
        var tzrkpok = Number(Number($('#tzrkpok').val()).toFixed(3));      //Транспортные до покупателя (на шт)
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));

        //Изменяется обналотзркнам
        $('#obtzrknam').text((tzrknam*(1-(firstobp/100))).toFixed(2));
        //Изменяется сам тзр
        $('#tzr').text((tzrknam + tzrkpok).toFixed(2));

        //Происходит изменение тзр и только потом происходит выбирание переменной тзр для расчета цены
        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы

        //Изменение отсрочкорублей
        $('#wtr').text(Number((a*0.0125*wt).toFixed(2)));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //И происходит то, что обычно происходит при изменении тзр:
        //Изменение проценторублей
        $('#opr').text(Number(((a+wtr)*op/100).toFixed(2)));
        var opr = Number($('#opr').text());

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+(a+wtr)*op/100)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));;
        var firstobpr =  Number($('#firstobpr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=tpr=firstobpr=tzrknam=tzrkpok=null;
        //Идет расчет цены
        //givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ТЗР К ПОКУПАТЕЛЮ
    $('#tzrkpok').change(function () {
        console.log('Изменяется tzrkpok');
        //Переменные
        var tzrknam = Number(Number($('#tzrknam').val()).toFixed(3));      //Транспортные до нашего склада (на шт)
        var tzrkpok = Number(Number($('#tzrkpok').val()).toFixed(3));      //Транспортные до покупателя (на шт)
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));


        //Изменяется обналотзркпок
        $('#obtzrkpok').text((tzrkpok*(1-(firstobp/100))).toFixed(2));
        //Изменяется сам тзр
        $('#tzr').text((tzrknam + tzrkpok).toFixed(2));

        //Происходит изменение тзр и только потом происходит выбирание переменной тзр для расчета цены
        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы

        //Изменение отсрочкорублей
        $('#wtr').text(Number((a*0.0125*wt).toFixed(2)));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //И происходит то, что обычно происходит при изменении тзр:
        //Изменение проценторублей
        console.log(a + 'типа ' + typeof(a) );
        console.log(wtr + 'типа ' + typeof(wtr) );
        console.log(op + 'типа ' + typeof(op) );
        $('#opr').text(Number(((a+wtr)*op/100).toFixed(2)));
        var opr = Number($('#opr').text());

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+(a+wtr)*op/100)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));;
        var firstobpr =  Number($('#firstobpr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=tpr=firstobpr=tzrknam=tzrkpok=null;
        //Идет расчет цены
        givePrice();

    });
    //ИЗМЕНЕНИЕ ОТСРОЧКИ
    $('#wtime').change(function () {
        console.log('Изменилась отсрочка');
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //Изменяется количество дней
        $('#wtimeday').text((wt/0.0334).toFixed(0));

        //Изменение отсрочкорублей
        $('#wtr').text(Number((a*0.0125*wt).toFixed(2)));

        //Изменение проценторублей
        $('#opr').text(Number(((a+wtr)*op/100).toFixed(2)));
        var opr = Number($('#opr').text());

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+(a+wtr)*op/100)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=tpr=null;
        //Идет расчет цены
        givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ НАШЕГО ПРОЦЕНТА
    $('#op').change(function(){
        console.log('Изменился наш процент');
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //Изменение проценторублей
        $('#opr').text(Number(((a+wtr)*op/100).toFixed(2)));

        var opr = Number($('#opr').text());
        console.log('zak+kol ='+a+', wtr = '+wtr+', op='+op+'. opr ='+opr);

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+opr)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));;
        var firstobpr =  Number($('#firstobpr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=tpr=firstobpr=null;
        //Идет расчет цены
        givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //ИЗМЕНЕНИЕ ЕНОТОПРОЦЕНТА
    $('#tp').change(function(){
        console.log('Изменился енотопроцент');
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)
        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+(a+wtr)*op/100)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));;
        var firstobpr =  Number($('#firstobpr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=tpr=firstobpr=null;
        //Идет расчет цены
        givePrice();
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*ИЗМЕНЕНИЕ ПЕРВОГО ОБНАЛОПРОЦЕНТА*/
    $('#firstobp').change(function () {
        //Переменные
        var zak = Number(Number($('#zak').val()).toFixed(3));      //Закупочная цена (на шт)

        var tzrknam = Number(Number($('#tzrknam').val()).toFixed(3));      //Транспортные до нашего склада (на шт)
        var tzrkpok = Number(Number($('#tzrkpok').val()).toFixed(3));      //Транспортные до покупателя (на шт)

        var tzr = Number(Number($('#tzr').text()).toFixed(3));      //Транспортные (на шт)
        var a = zak+tzr;                                           //Сумма Закупа и ТЗР для формулы
        var tp = Number(Number($('#tp').val()).toFixed(3));        //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));        //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //Изменение проценторублей
        $('#opr').text(Number(((a+wtr)*op/100).toFixed(2)));
        var opr = Number($('#opr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Новый обнал идет вниз в функцию зафиксированной цены
        $('#obp').val(Number(Number($('#firstobp').val()).toFixed(1)));
        //Следом внизу в зафиксированной цене изменяется и на руки

        //Изменяется обналотзркнам
        $('#obtzrknam').text((tzrknam*(1-(firstobp/100))).toFixed(2));

        //Изменяется обналотзркпок
        $('#obtzrkpok').text((tzrkpok*(1-(firstobp/100))).toFixed(2));

        //Удаляем все переменные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=null;
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

    //Главная функция
    function givePrice(){
        //Переменные
        var lzak = Number($('#zak').val());                         //Закупочная цена (за 1 единицу товара)
        var lkol = Number($('#kol').val());                         //Количество товара
        var ltzr = Number($('#tzr').text());                         //Транспортные (на 1 шт товара)
        var ltp = Number(Number($('#tp').val()).toFixed(2));        //Ненаша наценка (в формате десятичных двух знаков)
        var ltpr = Number((Number($('#tpr').text())).toFixed(2));
        var wt = Number(Number($('#wtime').val()).toFixed(2));      //Отсрочка платежа, в месяцах, нужна при расчете рентабельности
        var lop = Number(Number($('#op').val()).toFixed(2));        //Наша наценка (в формате десятичных двух знаков)
        var fobp = Number(Number($('#firstobp').val()).toFixed(0));
        var firstobpr = Number($('#firstobpr').text());
        var uid = Number($('#id').text());
        var firstoh = Number(Number($('#firstoh').val()).toFixed(2));

        //РАСЧЕТ ЦЕНЫ И РЕНТАБЕЛЬНОСТИ
        console.log('inactive fixate');
        //Расчет цены
        var fixed = 0;
        var la = (lzak + ltzr);             //Сумма закупа и тзр, именуемое "А"
        var lwt = la*0.0125*wt;             //Отсрочка  это сумма отсрочек покупателю и поставщику.это дополнительная затрата в виде 1,25% в месяц от суммы закупа и ТЗР
        var lnam = (la+lwt)*lop/100;        //Начислено нам в рублях
        var lim = (la+lwt+lnam)*ltp/100;    //Начислено им в рублях

        var lprice = Number((la + lwt + lim + lnam).toFixed(3));
        //Даем цену
        $('#pr').val((lprice).toFixed(3));

        //Высчитываем грязный процент (отношение начисленного к цене)
        var clearp = ltpr/lprice*100;
        $('#clearp').text((clearp).toFixed(2) + ' %');

        //Высчитываем чистый процент (отношение выдаваемого к цене)
        var clearpnar = firstoh/lprice*100;
        $('#clearpnar').text((clearpnar).toFixed(2) + ' %');

        //Расчет рентабельности
        //var opr = Number((Number($('#opr').text())).toFixed(2));
        var lrentS = lnam/lprice*100;
        $('#rent h1').text((lrentS).toFixed(3) + ' %');
        console.log('Проверка расчета рентабельности. Наше: '+lnam+'. Цена: '+lprice+'. Рентабельность: '+lrentS+'.');

        //Разбили прайстекст на составляющие
        var pricetext = '<p>Цена: <b>' + (lprice).toFixed(2) + '</b> При расчете :<br>' +
            //Нам чистыми на 1 шт
            'НАМ: '+
            (lnam).toFixed(2) + ' руб. за шт.' + '<br>/<br>' +
            //НЕ наш процент
            'НЕ НАМ: '+
            //Им чистыми за 1 шт
            (lim).toFixed(2) + 'руб. за шт.' +
            '<br>Чистыми : ' + (clearp).toFixed(3) + ' %' +
            '<br> На руки: ' + (Number((lim).toFixed(2)) - firstobpr).toFixed(2) + ' руб. с 1 шт.' +
            '<br>При рентабельности: ' + (lrentS).toFixed(3) + ' % <input type="button" name="save" id="save" value="Сохранить этот результат" />';
        $('#cases').html(pricetext);
        pricetext = null;
        $('#cases').slideDown();

        $('#obnal').slideDown();

        /*////////////////////////БЛОК ОТПРАВКИ ФОРМЫ В БАЗУ///////////////////////////*/
        $(document).off('click.pricesave').on('click.pricesave', '#save', function(event){
            event.preventDefault();//Если эту херню не поставить, аякс-запрос будет постоянно отменяться (status=cancelled). Потому что у кнопки сейв был тайп = сабмит. Нужно
            // было либо его убрать, изменить на буттон, либо превент дефолт. Поэтому отправлялся неполный формдата, который составляет как раз результат .serialize
            if (
                $('#trade').val() != "" &&
                $('#seller').val() != ""
            )
            {
                var positionID = $('#pricingwindow').attr('positionid');
                var pricingID = $('#pricingwindow').attr('pricingid');
                var preditposID = $('#pricingwindow').attr('preditposid');
                var reqid = $('.collapsepos[position='+preditposID+']').attr('request');


                lprice = Number(Number($('#pr').val()).toFixed(3));
                firstoh = Number(Number($('#firstoh').val()).toFixed(2));

                console.log(lprice+" типа "+typeof(lprice));
                console.log(firstoh+" типа "+typeof(firstoh));

                var formData =
                    '&trade=' + $('#trade').attr('trade_id') +
                    '&seller=' + $('#seller').attr('seller_id') +
                    '&zak=' + Number($('#zak').val()) +
                    '&kol=' + Number($('#kol').val()) +
                    '&tzr=' + Number($('#tzr').text()) +
                    '&tzrknam=' + Number($('#tzrknam').val()) +
                    '&tzrkpok=' + Number($('#tzrkpok').val()) +
                    '&op=' + Number(Number($('#op').val()).toFixed(2)) +
                    '&tp=' + Number(Number($('#tp').val()).toFixed(2)) +
                    '&firstobp=' + Number(Number($('#firstobp').val()).toFixed(0)) +
                    '&wtime=' + Number(Number($('#wtime').val()).toFixed(2)) +
                    '&obp=' + Number(Number($('#obp').val()).toFixed(1)) +
                    '&price=' + lprice +
                    '&firstoh=' + firstoh +
                    '&rent=' + lrentS +
                    '&tpr=' + lim +//новое
                    '&opr=' + lnam +//новое
                    '&fixed=' + fixed +
                    '&firstobpr=' + firstobpr +
                    '&clearp=' + Number(Number(clearp).toFixed(2)) +
                    '&wtr=' + Number(Number($('#wtr').text()).toFixed(2)) +
                    '&wtimeday=' + Number(Number($('#wtimeday').text()).toFixed(2));
                if(positionID != '-'){//Если это первое сохранение расценки
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
                    //Если это редактирование расценки
                    //Добавить переменную в прайсингвиндоу с номером позиции для обновления текста по окончании редактирования
                    //это preditposid

                    formData += '&pricingid=' + pricingID;
                    console.log(formData);
                    //Аякс скрипт на editpricing
                    $.ajax({
                        url: 'mysql_save.php',
                        method: 'POST',
                        data: formData,
                        success: function (data) {
                            $('#editmsg').css("display", "block"). delay(1000).slideUp(300).html(data);
                        },
                        complete: function () {
                            $.ajax({//Меняются реквизиты текущей расценки
                                url: 'mysql_read.php',
                                method: 'POST',
                                data: {positionid:preditposID},
                                success: function (data) {
                                    $('input[position='+preditposID+'] ~ div.pricings').html(data);
                                },
                                complete: function () {//ПРОВЕРКА, если редкатировалась расценка-победитель, то изменяем реквизиты победителя
                                    if($('tr[pricingid='+pricingID+']').hasClass('win')){
                                        $.ajax({
                                            url: 'mysql_rent.php',
                                            method: 'POST',
                                            dataType: 'json',
                                            cache: false,
                                            data: {read_winid:pricingID},
                                            success: function(data) {
                                                $('tr[position=' + preditposID + ']>td.winname').html(data.data1);//Вставить имя Победителя (Имя)
                                                $('tr[position=' + preditposID + ']>td.pr').html(data.data2);//Вставить СУмму по позиции
                                                $('tr[position=' + preditposID + ']>td.rent').html(data.data3);//Вставить новую рентабельность
                                            },
                                            complete: function () {//Изменяем сумму заявки в списке заявок, самой большой таблице и в верхней строке
                                                $.ajax({
                                                    url: 'mysql_rent.php',
                                                    method: 'POST',
                                                    dataType: 'json',
                                                    cache: false,
                                                    data: {request:reqid},
                                                    success: function (data) {
                                                        $('tr[requestid='+reqid+'] .rent_whole').html(data.data2);
                                                        $('tr[requestid='+reqid+'] .sum_whole').html(data.data3);
                                                        $('h3.req_header_'+reqid+' .reqsumma').html(data.data3);
                                                    }
                                                });
                                            }
                                        })
                                    }
                                }
                            });
                        }
                    });
                }

            } else {
                alert("Для добавления в базу заполните поля: \n'Товар', \n'Поставщик'.")
            }
        });
    }







































})














