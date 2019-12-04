$(document).ready(function() {

    /*ФОРМИРОВАНИЕ КП*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.mail_compose').on('click.mail_compose', '.mail_compose', function (event) {
        console.log('imalive!');

        var body_options = $('.mail_body_parts input[type="checkbox"]');
        var mail_array = [];


        console.log(body_options);

        for(var option in body_options){
            //console.log(option);
            /*if(option.is(":checked")){
                //Сформировать массив запрашиваемых данных
                mail_array.push(option.attr('name'));
            }*/
        }

        //Отправить этот массив аяксом
        /*$.ajax({
            url: 'mysql_auto_kp.php',
            method: 'POST',
            data: {mail_array:mail_array},
            success: function(data){
                //Что-то
            },complete:function () {
                //Что-то
            }
        });*/

        console.log(mail_array);

    });
});