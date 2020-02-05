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
            '<br><span>Предлагаем к поставке: </span><br>' +
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

    //Показ пустой текстарии для своего текста в КП
    $(document).off('change.custom_text').on('change.custom_text', '#with_custom_text', function (event) {
        $('#the_custom_text').slideUp();
        if($('#with_custom_text').is(":checked")) {
            $('#the_custom_text').slideDown();
        }
    });

    //Показ формы добавления кастомного товара
    $(document).off('change.custom_trades').on('change.custom_trades', '#with_custom_products', function (event) {
        $('#custom_trades').slideUp();
        if($('#with_custom_products').is(":checked")) {
            $('#custom_trades').slideDown();
        }
    });

    $(document).off('change.preferred').on('change.preferred', '#with_preferred_firm', function (event) {
        $('#preferred').slideUp();
        if($('#with_preferred_firm').is(":checked")) {
            $('#preferred').slideDown();
        }
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



    function GiveKP() {
        //В массиве body_options - все чекбоксы, относящиеся к содержанию кп, исключая чекбоксы, включающие определенные асти кп (Дилерство, Умные мысли, Свой текст, общий список, заключение)
        var body_options = $('.mail_body_parts input:not(".select_group"):checked, .mail_tail_parts input[type="radio"]:checked');
        var mail_array = [];
        var options_length = body_options.length;
        var preferred_group = $('#preferred_trade_group_input').val();
        var firm_type = $('#firm_type').val();
        var add_custom_trade_length = $('.add_custom_trade').length;

        var with_prices = 0;
        if($('#with_prices').is(":checked")){with_prices = 1}
        var with_pics = 0;
        if($('#with_pics').is(":checked")){with_pics = 1}
        var with_dealership = 0;
        if($('#with_dealership').is(":checked")){with_dealership = 1}
        var with_thoughts = 0;
        if($('#with_thoughts').is(":checked")){with_thoughts = 1}
        var with_preferred_firm = 0;
        if($('#with_preferred_firm').is(":checked")){with_preferred_firm = 1}
        var with_custom_text = 0;
        var custom_text = 0;
        if($('#with_custom_text').is(":checked")){
            with_custom_text = 1;
            custom_text = $('#the_custom_text').val();
        }
        var with_custom_products = 0;
        if($('#with_custom_products').is(":checked")){with_custom_products = 1}

        var with_whole_product_list = 0;
        if($('#with_whole_product_list').is(":checked")){with_whole_product_list = 1}
        var with_closing = 0;
        if($('#with_closing').is(":checked")){with_closing = 1}

        for(var i = 0; i < options_length; i++){
            //Сформировать массив запрашиваемых данных
            mail_array.push($(body_options[i]).attr("id"));
        }

        console.log(add_custom_trade_length);
        console.log(mail_array);

        var custom_name = "";
        var custom_description = "";
        var custom_packing = "";
        var custom_price = "";
        var custom_trades_line = "";
        if(add_custom_trade_length > 0){
            custom_trades_line = '<br><table style="border-collapse: collapse; width: 95%">';
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
                    '<td style="width: 2%; border: 1px solid black; font-size: 20px; text-align: center">'+linenum+'</td><td style="border: 1px solid black; font-size: 20px; width: 25%; text-align: center"><b>'+custom_name+'</b></td>';
                custom_trades_line += '<td style="border: 1px solid black; font-size: 20px; width: 50%; text-align: center">'+custom_description+'</td>';
                custom_trades_line +='<td style="border: 1px solid black; font-size: 20px; width: 10%; text-align: center">'+custom_packing+'</td>' +
                    '<td style="border: 1px solid black; font-size: 20px; width: 10%; text-align: center">'+custom_price+'</td>' +
                    '</tr>';
                console.log(custom_trades_line);
            }
            custom_trades_line += '</table><br>';
            console.log(custom_trades_line);
        }

        //Отправить этот массив аяксом
        $.ajax({
            url: 'auto_kp_give_html.php',
            method: 'POST',
            data: {
                mail_array:mail_array,
                with_prices:with_prices,
                with_pics:with_pics,
                with_dealership:with_dealership,
                with_thoughts:with_thoughts,
                with_preferred_firm:with_preferred_firm,
                preferred_group:preferred_group,
                firm_type:firm_type,
                with_custom_text:with_custom_text,
                custom_text:custom_text,
                with_whole_product_list:with_whole_product_list,
                with_closing:with_closing
            },
            success: function(data){
                $('#html_result').html(data);
            },
            complete: function () {
                console.log("Все выполнилось");
                if(with_custom_products == 1){
                    $('#custom_trades_table').append(custom_trades_line);
                }else{
                    $('#custom_trades_table').html('')
                }
                $('#html_copy').text($('#html_result').html());
            }
        });
    }

    /*ФОРМИРОВАНИЕ КП*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.mail_compose').on('click.mail_compose', '.mail_compose', function (event) {
        GiveKP();
    });

    $(document).off('change.checkbox_givekp').on('change.checkbox_givekp', '.add_custom_trade input[type=text], .delete_current_trade, .mail_body_parts input[type=checkbox], #with_pics, #with_custom_products, #with_prices, #with_dealership, #with_thoughts, #with_preferred_firm, #preferred_trade_group_input, #firm_type, #with_custom_text, #the_custom_text, #with_whole_product_list, #with_closing, #20_dima, #20_marina, #20_sergey, #20_timur, #deselect_all', function (event) {
        GiveKP();
    });
});



$(document).off('click.mail_copy').on('click.mail_copy', '#mail_copy', function (event) {
    $('#html_copy').select();
    document.execCommand('copy');
    $('#info_span').text('Скопировано');
});
