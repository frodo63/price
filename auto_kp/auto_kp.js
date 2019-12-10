$(document).ready(function() {

    //Аккордион подключение и настройки
    $( function() {
        $( "#accordion" ).accordion({
            heightStyle: "content",
            collapsible: true,
            active: false
        });
    } );

    //Добавление нового товара в кастомной КП
    $(document).off('click.add_custom_trade').on('click.add_custom_trade', '#add_custom_trade', function (event) {
        $('#custom_trades').append('' +
            '<div class=\'add_custom_trade\'>' +
            '<br><hr><br><span>Предлагаем к поставке: </span><br>' +
            '<input type=\'text\' name=\'insert_name\' size=\'20\' value=\'\' style=\'font-size: 15px;text-align: center\'><br>' +
            '<span>Описание: </span><br>' +
            '<input type=\'text\' name=\'insert_description\' size=\'20\' value=\'\' style=\'font-size: 15px;text-align: center\'><br>' +
            '<span>Фасовка: </span><br>' +
            '<input type=\'text\' name=\'insert_packing\' size=\'20\' value=\'\' style=\'font-size: 15px;text-align: center\'><br>' +
            '<span>Цена: </span><br>' +
            '<input type=\'text\' name=\'insert_price\' size=\'20\' value=\'\' style=\'font-size: 15px;text-align: center\'><br>' +
            '<input type=\'button\' id=\'delete_current_trade\' value=\'-\'>' +
            '</div>');
    });

    //Удаление  нынешнего товара в кастомной КП
    $(document).off('click.delete_custom_trade').on('click.delete_custom_trade', '#delete_current_trade', function (event) {
        $(event.target).parent('.add_custom_trade').remove();
    });

    $(document).off('mouseover.mouseover_custom_trade').on('mouseover.mouseover_custom_trade', '#delete_current_trade', function (event) {
        $(event.target).parent('.add_custom_trade').css({'background-color': 'pink'});
    });
    $(document).off('mouseout.mouseover_custom_trade').on('mouseout.mouseover_custom_trade', '#delete_current_trade', function (event) {
        $(event.target).parent('.add_custom_trade').css({'background-color': 'white'});
    });


    //ОТменить все галочки
    $(document).off('click.deselect_all').on('click.deselect_all', '#deselect_all', function (event) {
        $('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    });



    /*ФОРМИРОВАНИЕ КП*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.mail_compose').on('click.mail_compose', '.mail_compose', function (event) {

        var body_options = $('.mail_body_parts input:not(.select_group):not(#with_prices):not(.add_custom_trade input)[type="checkbox"]:checked, .mail_tail_parts input[type="radio"]:checked');
        var mail_array = [];
        var options_length = body_options.length;
        var preferred_group = $('#preferred_trade_group_input').val();
        var firm_type = $('#firm_type').val();
        var add_custom_trade_length = $('.add_custom_trade').length;

        var with_prices = 0;
        if($('#with_prices').is(":checked")){with_prices = 1}
        var with_pics = 0;
        if($('#with_pics').is(":checked")){with_pics = 1}

        for(var i = 0; i < options_length; i++){
            //Сформировать массив запрашиваемых данных
            mail_array.push($(body_options[i]).attr("id"));
        }

        console.log(add_custom_trade_length);

        var custom_name = "";
        var custom_description = "";
        var custom_packing = "";
        var custom_price = "";
        var custom_trades_line = "";
        console.log(custom_trades_line);

        if(add_custom_trade_length > 0){
            custom_trades_line = '<br><br><hr><h2>Коммерческое предложение</h2><table style="border-collapse: collapse; width: 95%">';
            console.log(custom_trades_line);
            for(var i = 0; i < add_custom_trade_length; i++){


                var thetrade = $('.add_custom_trade').eq(i);
                var linenum = i+1;


                custom_name = thetrade.children('input[name="insert_name"]').val();
                custom_description = thetrade.children('input[name="insert_description"]').val();
                custom_packing = thetrade.children('input[name="insert_packing"]').val();
                custom_price = thetrade.children('input[name="insert_price"]').val();

                console.log(typeof(custom_description));


                custom_trades_line += '<tr>' +
                    '<td style="width: 2%; border: 1px solid black; font-size: 20px; text-align: center">'+linenum+'</td><td style="border: 1px solid black; font-size: 20px; width: 45%; text-align: center">'+custom_name+'</td>';
                custom_trades_line += '<td style="border: 1px solid black; font-size: 20px; width: 30%; text-align: center">'+custom_description+'</td>';
                custom_trades_line +='<td style="border: 1px solid black; font-size: 20px; width: 10%; text-align: center">'+custom_packing+'</td>' +
                    '<td style="border: 1px solid black; font-size: 20px; width: 10%; text-align: center">'+custom_price+'</td>' +
                    '</tr>';
                console.log(custom_trades_line);
            }
            custom_trades_line += '</table><br><hr><br>';
            console.log(custom_trades_line);
        }

        //Отправить этот массив аяксом
        $.ajax({
            url: 'auto_kp_give_html.php',
            method: 'POST',
            data: {mail_array:mail_array, with_prices:with_prices, with_pics:with_pics},
            success: function(data){
                $('#html_result').html(data);
            },
            complete: function () {
                $('#preferred_trade_group').text("Снабжение "+preferred_group+" "+firm_type+" - одно из ключевых направлений нашей деятельности.");
                $('#custom_trades_table').append(custom_trades_line);
                $('#html_copy').text($('#html_result').html());

            }
        });
    });

    $(document).off('change.select_group').on('change.select_group', '.select_group', function (event) {
        var id = $(this).attr('id');
        console.log('changed '+id);
        if($(this).is(":checked")){
            $('input[id^='+id+']').prop('checked', true);
        }


        if($(this).is(":not(:checked)")){
            $('input[id^='+id+']').prop('checked', false);
        }
    })

});



$(document).off('click.mail_copy').on('click.mail_copy', '#mail_copy', function (event) {
    $('#html_copy').select();
    document.execCommand('copy');
    $('#info_span').text('Скопировано');
});
/*
 CREATE TABLE `food_greases` (
 `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `brand` enum('Bechem','Total','Rocol','Matrix') COLLATE utf8_unicode_ci NOT NULL,
 `application` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `working_temp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `packing_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

 CREATE TABLE `hydraulics` (
 `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `brand` enum('Bechem','Total','Shell','Mobil','Castrol','Agip','Fuchs') COLLATE utf8_unicode_ci NOT NULL,
 `application` text COLLATE utf8_unicode_ci NOT NULL,
 `description` text COLLATE utf8_unicode_ci NOT NULL,
 `viscosity` tinyint(3) NOT NULL,
 `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

 CREATE TABLE `soges` (
 `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `brand` enum('Bechem','Mol') COLLATE utf8_unicode_ci NOT NULL,
 `application` text COLLATE utf8_unicode_ci NOT NULL,
 `operations` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `metal_types` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `concentration` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `packing_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

 CREATE TABLE `tails` (
 `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
 `name` enum('Dima','Marina','Sergey','Timur') COLLATE utf8_unicode_ci NOT NULL,
 `html` text COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

*/
