$(document).ready(function(){


    //ЗАказы
    $(document).off('click.sync').on('click.sync', '#sync_requests, #sync_payments, #sync_byers, #sync_sellers, #sync_trades', function(event){
        var sync_file = ($(event.target).attr("id")).substring(5);
        console.log(sync_file);
        $.ajax({
            url: 'mysql_sync.php',
            method: 'POST',
            data: {sync_file:sync_file},
            success: function (data) {
                $('#sync_info').html(data);
            }
        });
    });


    //Проходы по списку:
    $(document).off('click.sync_list').on('click.sync_list', '#sync_info .sres li', function (event) {
        console.log('сработал клик на лист итеме');
        var category = $(event.target).parents('li').attr('category')+"s";
        switch (category){
            case 'byers':
                var theID = $(event.target).parents('li').attr('byers_id');
                break;
            case 'sellers':
                var theID = $(event.target).parents('li').attr('sellers_id');
                break;
            case 'trades':
                var theID = $(event.target).parents('li').attr('trades_id');
                break;
        }
        console.log(theID);
        console.log(category);
        $(event.target).parents('.sres').next('input.sync_to_base').attr({innerid:theID,table:category});
    })

    //Соотнесение по кнопке
    $(document).off('click.sync_to_base').on('click.sync_to_base', '.sync_to_base', function (event) {
        var innerid = $(event.target).attr('innerid');
        var uid = $(event.target).attr('uid');
        //var dataver = $(event.target).attr('dataver');
        var table = $(event.target).attr('table');

        if(!innerid){
            console.log('innerid is undefined');
        }else{
            console.log(innerid);
            console.log(uid);
            console.log(table);

            $.ajax({
                url: 'mysql_sync.php',
                method: 'POST',
                data: {innerid:innerid,uid:uid,table:table},
                success: function (data) {
                    $('#editmsg').css("display", "block"). delay(2000).slideUp(300).html(data);
                }
            });
        }
    });


    $(document).off('click.syncaddnew').on('click.syncaddnew', '.sync_add_to_base', function(){
        $('#sync_add_to_base').toggleClass('up', 500);
        if($('#sinchronize_trades').length > 0){
            $('#sync_add_to_base').html("<div class ='creates'>" +
                "<br><input class='add_trade_name' type='text' placeholder='Введите наименование Товара' size='70'>" +
                "<br><span>Тара:</span><span class='trade_options_tare'></span><br>" +
                "<select id='add_trade_tare' size='1'>" +
                "<option value='штука'>штука (по умолчанию)</option>" +
                "<option value='банка'>банка (до 5кг)</option>" +
                "<option value='канистра'>канистра (5-50л)</option>" +
                "<option value='бочка'>бочка(200л)</option>" +
                "</select><br>" +
                "<span class='ready_comment'></span><br>" +
                "<input  type='button' name='trades' value='Добавить' disabled><br><br></div>");
            $('#sync_add_to_base .creates').css('display','block');
        }

        if($('#sinchronize_byers').length > 0){
            $('#sync_add_to_base').html("<div class='creates add_ramk'><br>" +
                "<input type='text' placeholder='Введите наименование Покупателя' size='70'>" +
                "<input type='button' tc='1' name='byers' value='Добавить'>" +
                "<br>" +
                "<br>" +
                "</div>");
            $('#sync_add_to_base .creates').css('display','block');
        }

        if($('#sinchronize_sellers').length > 0){
            $('#sync_add_to_base').html("<div class='creates'>" +
                "<br>" +
                "<input type='text' placeholder='Введите наименование Поставщика' size='70'>" +
                "<input type='button' tc='2' name='sellers' value='Добавить'>" +
                "<br>" +
                "<br>" +
                "</div>");
            $('#sync_add_to_base .creates').css('display','block');
        }
    });




});