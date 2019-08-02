$(document).ready(function(){

    function differ(a,b){return Math.abs(a-b);}

    /*function compareRents(rent, rent_in, op, callback){
        console.log('Inside compareRents');
        var diff = differ(rent,rent_in);
        var pace;

        if(diff <= 0.05){
            console.log(1);
            return false;
        }else if(diff > 0.05 && diff < 0.1 ){
            pace = 0.1;
            console.log(6+'шаг = 0.1');
        }
        else if(diff > 0.1 && diff < 0.5 ){
            pace = 0.2;
            console.log(5+'шаг = 0.2');
        }
        else if(diff > 0.5 && diff < 1){
            pace = 1;
            console.log(4+'шаг = 1');
        }
        else if(diff > 1){
            pace = 2;
            console.log(3+'шаг = 2');
        }
        else if(diff > 2){
            pace = 4;
            console.log(2+'шаг = 4');
        }

        if (rent > rent_in){
            console.log('больше');
            op = op - pace;
        }
        if (rent < rent_in){
            console.log('меньше');
            op = op + pace;
        }

        $('#op').val(op);

        callback();
        return true;
    }*/
    /*function comparePrices(price, price_in, op, callback){
        console.log('Inside comparePrices');
        var diff = differ(price,price_in);
        var pace;

        if(diff <= 1){
            console.log(1+' - Результат: '+price);
            return false;
        }
        else if(diff > 1 && diff < 5 ){
            pace = 0.05;
            console.log(7+' шаг = 0.05');
        }
        else if(diff > 5 && diff < 100 ){
            pace = 0.3;
            console.log(5+' шаг = 0.3');
        }
        else if(diff > 100 && diff < 1000){
            pace = 1.5;
            console.log(4+' шаг = 1.5');
        }
        else if(diff > 1000){
            pace = 3;
            console.log(3+' шаг = 3');
        }

        if (price > price_in){
            console.log('больше');
            op = op - pace;
        }
        if (price < price_in){
            console.log('меньше');
            op = op + pace;
        }

        $('#op').val(op);

        callback();
        return true;
    }*/

    function compareFastPrices(pr_index,tick,price,price_in,lop,lzak,ltzr,ltp,ltpr,wt,firstoh,callback){
            //console.log('Inside compareFastPrices');
            var diff = differ(price,price_in);
            var pace;
            var op = lop;
            if(diff <= 1 || tick >= 150){
                console.log(1);
                //Обновить данные актуальные по цене из изменения нашего процента и цены
                $('#op').val(op).trigger('change.op');
                if(tick >= 150){console.log('over 150')}
                return false;
            }
            else if(diff > 1 && diff < 10 ){pace = 0.1;console.log(diff+' шаг = 0.1');}
            else if(diff > 10 && diff < 50 ){pace = 0.3;console.log(diff+' шаг = 0.3');}
            else if(diff > 50 && diff < 100 ){pace = 1;console.log(diff+' шаг = 1');}
            else if(diff > 100 && diff < 500){pace = 2;console.log(diff+' шаг = 2');}
            else if(diff > 500 && diff < 1000){pace = 3;console.log(diff+' шаг = 3');}
            else if(diff > 1000 && diff < 2000){pace = 6;console.log(diff+' шаг = 6');}
            else if(diff > 2000 && diff < 4000){pace = 10;console.log(diff+' шаг = 10');}
            else if(diff > 4000 && diff < 8000){pace = 20;console.log(diff+' шаг = 20');}

            if (price > price_in){console.log('больше');op = op - pace;}
            if (price < price_in){console.log('меньше');op = op + pace;}

            //console.log('first callback');
            var f = callback(tick,lzak,ltzr,ltp,ltpr,wt,op,firstoh);


            if(isNaN(f[0])){
                return false;
            }else{
                //console.log('recursion starts');
                //console.log('Итерация:'+f[2]+', Цена: '+f[0]+', Рентабельность: '+f[1]);
                console.log('Итерация:'+f[2]+', Цена: '+f[0]);
                compareFastPrices(f[4],f[2],f[0],price_in,op,lzak,ltzr,ltp,ltpr,wt,firstoh,callback);
            }
    }
    function compareFastRents(pr_index,tick,rent,rent_in,lop,lzak,ltzr,ltp,ltpr,wt,firstoh,callback){
        //console.log('Inside compareFastRents');
        var diff = differ(rent,rent_in);
        var pace;
        var op = lop;
        if(diff <= 1 || tick >= 150){
            console.log(1);
            //Обновить данные актуальные по цене из изменения нашего процента и цены
            $('#op').val(op).trigger('change.op');
            if(tick >= 150){console.log('over 150')}
            return false;
        }
        else if(diff > 1 && diff < 2 ){pace = 0.2;console.log(diff+' шаг = 0.2');}
        else if(diff > 2 && diff < 5 ){pace = 1;console.log(diff+' шаг = 1');}
        else if(diff > 5 && diff < 10 ){pace = 2;console.log(diff+' шаг = 2');}
        else if(diff > 10 && diff < 50 ){pace = 5;console.log(diff+' шаг = 5');}
        else if(diff > 50 && diff < 100 ){pace = 10;console.log(diff+' шаг = 10');}

        if (rent > rent_in){console.log('больше');op = op - pace;}
        if (rent < rent_in){console.log('меньше');op = op + pace;}

        //console.log('first callback');
        var f = callback(tick,lzak,ltzr,ltp,ltpr,wt,op,firstoh);


        if(isNaN(f[1])){
            return false;
        }else{
            //console.log('recursion starts');
            console.log('Итерация:'+f[2]+', Рентабельность: '+f[1]);
            //console.log('Итерация:'+f[2]+', Цена: '+f[0]);
            compareFastRents(f[4],f[2],f[1],rent_in,op,lzak,ltzr,ltp,ltpr,wt,firstoh,callback);
        }
    }

    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //Задать рентабельность - ВРЕМЕННО КОММЕНТИМ, делаем быструю функцию
    /*$('#rent_in').off('change.rent_in').on('change.rent_in', function () {
        console.log('Inside change.rent');
        var op = Number(Number($('#op').val()).toFixed(3));
        var rent = Number(Number($('#rent h1').text()).toFixed(3));
        var rent_in = Number(Number($('#rent_in').val()).toFixed(3));

        //console.log(typeof(rent)+rent);
        //console.log(typeof(rent_in)+rent_in);
        //console.log(differ(rent,rent_in));

        //Функция вызывается только если некоторые переменные не undefined

        if(typeof rent === 'undefined' || typeof rent_in === 'undefined' || typeof op === 'undefined' || rent === '' || rent_in === '' || op === '' || isNaN(rent) || isNaN(rent_in) || isNaN(op)){
            alert("Данных недостаточно");
            return false;
        }else{
            var f = compareRents(rent,rent_in,op, function (){
                changeOp(function(){
                    givePrice();
                });
            });

            f;//Это самый настоящий вызов функции =))

            if (!f){
                return false;

            }else{$('#rent_in').trigger('change.rent_in');}
        }
    });*/
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //Задать цену - ВРЕМЕННО КОММЕНТИМ, делаем быструю функцию
    /*$('#pr_in').off('change.price').on('change.price', function () {
        console.log('Inside change.price');
        var op = Number(Number($('#op').val()).toFixed(3));
        var price = Number(Number($('#pr').val()).toFixed(3));
        var price_in = Number(Number($('#pr_in').val()).toFixed(3));

        //Функция вызывается только если некоторые переменные не undefined

        if(typeof price === 'undefined' || typeof price_in === 'undefined' || typeof op === 'undefined' || price === '' || price_in === '' || op === '' || isNaN(price) || isNaN(price_in) || isNaN(op)){
            alert("Данных недостаточно");
            return false;
        }else{
            var f = comparePrices(price,price_in,op, function (){
                changeOp(function(){
                    givePrice();
                });
            });

            f;//Это самый настоящий вызов функции =))

            if (!f){
                return false;

            }else{$('#pr_in').trigger('change.price');}
        }
    });*/
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

    //Задать рентабельность быстрой функцией - РАБОТАЕТ
    $('#rent_in').off('change.fastrent').on('change.fastrent', function () {
        //console.log('Inside changefast.rent');
        var rent = Number(Number($('#rent').val()).toFixed(3));
        var rent_in = Number(Number($('#rent_in').val()).toFixed(3));
        var lzak = Number($('#zak').val());
        var ltzr = Number($('#tzr').text());
        var lwt = Number($('#wtr').text());
        var lnam = Number($('#opr').text());
        var lim = Number($('#tpr').text());
        var ltp = Number(Number($('#tp').val()).toFixed(2));
        var ltpr = Number((Number($('#tpr').text())).toFixed(2));
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var lop = Number(Number($('#op').val()).toFixed(2));
        var firstoh = Number(Number($('#firstoh').val()).toFixed(2));
        var tick = 0;
        var pr_index = ltzr + lwt + lnam + lim; //Индекс цены - для определения минимального увеличения цены
        //Функция вызывается только если некоторые переменные не undefined

        if(
            typeof rent == 'undefined' || typeof rent_in == 'undefined' || typeof lop == 'undefined' ||
            rent === '' || rent_in === '' || lop === '' ||
            isNaN(rent) || isNaN(rent_in) || isNaN(lop)
        ){
            alert("Данных недостаточно");
            return false;
        }else{
            compareFastRents(pr_index,tick,rent,rent_in,lop,lzak,ltzr,ltp,ltpr,wt,firstoh, fastPrice);
        }
    });

    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    //Задать цену быстрой функцией - РАБОТАЕТ
    $('#pr_in').off('change.fastprice').on('change.fastprice', function () {
        //console.log('Inside changefast.price');
        var price = Number(Number($('#pr').val()).toFixed(3));
        var price_in = Number(Number($('#pr_in').val()).toFixed(3));
        var lzak = Number($('#zak').val());
        var ltzr = Number($('#tzr').text());
        var lwt = Number($('#wtr').text());
        var lnam = Number($('#opr').text());
        var lim = Number($('#tpr').text());
        var ltp = Number(Number($('#tp').val()).toFixed(2));
        var ltpr = Number((Number($('#tpr').text())).toFixed(2));
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var lop = Number(Number($('#op').val()).toFixed(2));
        var firstoh = Number(Number($('#firstoh').val()).toFixed(2));
        var tick = 0;
        var pr_index = ltzr + lwt + lnam + lim; //Индекс цены - для определения минимального увеличения цены
        //Функция вызывается только если некоторые переменные не undefined

        if(
            typeof price == 'undefined' || typeof price_in == 'undefined' || typeof lop == 'undefined' ||
            price === '' || price_in === '' || lop === '' ||
            isNaN(price) || isNaN(price_in) || isNaN(lop)
        ){
            alert("Данных недостаточно");
            return false;
        }else{
            compareFastPrices(pr_index,tick,price,price_in,lop,lzak,ltzr,ltp,ltpr,wt,firstoh, fastPrice);
        }
    });
    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
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
    $('#op').off('change.op').on('change.op', function(){
        console.log('Inside change.op');
        changeOp(function(){
            givePrice();
        })
    });
    function changeOp(callback){
        console.log('Inside changeOp function');
        //console.log('Изменился наш процент');
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
        //console.log('zak+kol ='+a+', wtr = '+wtr+', op='+op+'. opr ='+opr);

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+opr)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));
        var firstobpr =  Number($('#firstobpr').text());

        //Изменение НА РУКИ
        $('#firstoh').val(Number((tpr - tpr*firstobp/100).toFixed(2)));

        //Стираем переменнные
        zak=tzr=a=tp=op=firstobp=wt=wtr=opr=tpr=firstobpr=null;
        //Идет расчет цены
        callback();
    }
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
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));
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
        var zak = Number(Number($('#zak').val()).toFixed(3));              //Закупочная цена (на шт)
        var tzrknam = Number(Number($('#tzrknam').val()).toFixed(3));      //Транспортные до нашего склада (на шт)
        var tzrkpok = Number(Number($('#tzrkpok').val()).toFixed(3));      //Транспортные до покупателя (на шт)
        var tzr = Number(Number($('#tzr').text()).toFixed(3));             //Транспортные (на шт)
        var a = zak+tzr;                                                   //Сумма Закупа и ТЗР для формулы
        var tp = Number(Number($('#tp').val()).toFixed(3));                //Ненаша наценка (в формате десятичных 3 знаков)
        var op = Number(Number($('#op').val()).toFixed(3));                //Наша наценка (в формате десятичных 3 знаков)
        var firstobp = Number($('#firstobp').val());
        var wt = Number(Number($('#wtime').val()).toFixed(2));
        var wtr = Number(Number($('#wtr').text()).toFixed(2));

        //Изменение еноторублей
        $('#tpr').text(Number(((a+wtr+(a+wtr)*op/100)*tp/100).toFixed(2)));
        var tpr = Number(Number($('#tpr').text()).toFixed(2));

        //Изменение обналорублей
        $('#firstobpr').text(Number((tpr*firstobp/100).toFixed(2)));
        var firstobpr =  Number($('#firstobpr').text());

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
        zak=tzr=a=tp=op=firstobp=wt=wtr=null;
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
    //Для быстрого расчета
    function fastPrice(tick,lzak,ltzr,ltp,ltpr,wt,lop,firstoh){
        //Расчет цены
        var la = (lzak + ltzr);
        var lwt = la*0.0125*wt;
        var lnam = (la+lwt)*lop/100;
        var lim = (la+lwt+lnam)*ltp/100;
        var pr_index = ltzr + lwt + lnam + lim;

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
        var lrentS = lnam/lprice*100;
        $('#rent h1').text((lrentS).toFixed(3));
        //console.log('Функция fastPrice сработала, цена: '+lprice);
        if(isNaN(lprice) || isNaN(lrentS)){
            return false;
        }else{
            tick++;
            return [lprice, lrentS, tick, lop, pr_index];
        }

    }
    //Главная функция
    function givePrice(){
        console.log('Inside givePrice');
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
        $('#rent h1').text((lrentS).toFixed(3));
        //console.log('Проверка расчета рентабельности. Наше: '+lnam+'. Цена: '+lprice+'. Рентабельность: '+lrentS+'.');
        //console.log('Отношение наших к цене: '+lnam/lprice);

        //Разбили прайстекст на составляющие
        var pricetext = '<p>Цена: <b>' + (lprice).toFixed(2) + '</b> При расчете :<br>' +
            //Нам чистыми на 1 шт
            'НАМ: '+
            (lnam).toFixed(2) + ' руб. за шт.' + '<br>/<br>' +
            //НЕ наш процент
            'НЕ НАМ: '+
            //Им чистыми за 1 шт
            (lim).toFixed(2) + 'руб. за шт.' +
            '<br>Чистыми : ' + (clearpnar).toFixed(3) + ' %' +
            '<br> На руки: ' + (Number((lim).toFixed(2)) - firstobpr).toFixed(2) + ' руб. с 1 шт.' +
            '<br>При рентабельности: ' + (lrentS).toFixed(3) + ' % ' +
            '<input type="button" name="save" id="save" value="Сохранить этот результат" />';
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
                var thebyer = $('#pricingwindow').attr('byerid');
                var db = $('#pricingwindow').attr('database');


                lprice = Number(Number($('#pr').val()).toFixed(3));
                firstoh = Number(Number($('#firstoh').val()).toFixed(2));

                var formData =
                    '&db=' + db +
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
                    //console.log(formData);
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
                                data: {positionid:positionID, db:db},
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
                    //console.log(formData);
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
                                data: {positionid:preditposID, db:db},
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
                                            data: {read_winid:pricingID, db:db},
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
                                                    data: {request:reqid, db:db},
                                                    success: function (data) {
                                                        //Изменяем данные таблицы в общем списке заявок
                                                        $('tr[requestid='+reqid+'] .rent_whole').html(data.data2);
                                                        $('tr[requestid='+reqid+'] .sum_whole').html(data.data3);
                                                        $('h3.req_header_'+reqid+' .reqsumma').html(data.data3);
                                                        //Изменяем данные таблицы в Р-1
                                                        $('.ga_byer_requests[ga_byer='+thebyer+'] tr[ga_request='+reqid+'] td.sum_req_r1').html(data.data3);
                                                        $('.ga_byer_requests[ga_byer='+thebyer+'] tr[ga_request='+reqid+'] td.count_req_r1').html(data.data4);
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














