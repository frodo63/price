$(document).ready(function() {

    /*ФОРМИРОВАНИЕ КП*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.mail_compose').on('click.mail_compose', '.mail_compose', function (event) {

        var body_options = $('.mail_body_parts input[type="checkbox"]:checked, .mail_tail_parts input[type="radio"]:checked');
        var mail_array = [];
        var options_length = body_options.length;
        var preferred_group = $('#preferred_trade_group_input').val();
        var firm_type = $('#firm_type').val();

        for(var i = 0; i < options_length; i++){
            //Сформировать массив запрашиваемых данных
            mail_array.push($(body_options[i]).attr("id"));
        }

        //Отправить этот массив аяксом
        $.ajax({
            url: 'auto_kp_give_html.php',
            method: 'POST',
            data: {mail_array:mail_array},
            success: function(data){
                $('#html_result').html(data);
                $('#html_copy').text(data);
            },
            complete: function () {
                $('#preferred_trade_group').text("Снабжение "+preferred_group+" "+firm_type+" - одно из ключевых направлений нашей деятельности.");
            }
        });
    });
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
