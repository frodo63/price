$(document).ready(function(){
    //Сортировка строк в таблице


    //Таблица "Платежки"
    //
    $(document).off('click.pay_payed').on('click.pay_payed', '#payments_order_payed', function(event){
        var order = 1;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'payments', order:order},
            success: function (data) {
                $('.payments_list').html(data);
            }
        });
    });
    $(document).off('click.pay_name').on('click.pay_name', '#payments_order_name', function(event){
        var order = 2;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'payments', order:order},
            success: function (data) {
                $('.payments_list').html(data);
            }
        });
    });
    $(document).off('click.pay_created').on('click.pay_created', '#payments_order_created', function(event){
        var order = 3;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'payments', order:order},
            success: function (data) {
                $('.payments_list').html(data);
            }
        });
    });
    $(document).off('click.pay_1c_number').on('click.pay_1c_number', '#payments_order_1c_number', function(event){
        var order = 4;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'payments', order:order},
            success: function (data) {
                $('.payments_list').html(data);
            }
        });
    });


    //Таблица "Выдачи"
    //
    $(document).off('click.vid_payed').on('click.vid_payed', '#vidachi_order_given_away', function(event){
        var order = 1;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'vidachi', order:order},
            success: function (data) {
                $('.vidachi_list').html(data);
            }
        });
    });
    $(document).off('click.vid_name').on('click.vid_name', '#vidachi_order_name', function(event){
        var order = 2;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'vidachi', order:order},
            success: function (data) {
                $('.vidachi_list').html(data);
            }
        });
    });
    $(document).off('click.vid_created').on('click.vid_created', '#vidachi_order_created', function(event){
        var order = 3;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'vidachi', order:order},
            success: function (data) {
                $('.vidachi_list').html(data);
            }
        });
    });
    $(document).off('click.vid_1c_number').on('click.vid_1c_number', '#vidachi_order_1c_number', function(event){
        var order = 4;
        $.ajax({
            url: 'mysql_read.php',
            method: 'POST',
            data: {table:'vidachi', order:order},
            success: function (data) {
                $('.vidachi_list').html(data);
            }
        });
    });


});