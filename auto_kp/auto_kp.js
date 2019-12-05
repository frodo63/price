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
CREATE TABLE `auto_kp`.`hydraulics` (
    `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
    `brand` ENUM('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
    `application` TEXT NOT NULL ,
    `description` TEXT NOT NULL ,
    `viscosity` TINYINT(3) NOT NULL ,
    `package_price` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE `auto_kp`.`soges` (
`id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`brand` ENUM('Bechem','Fuchs','Mol','Mobil') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`operations` VARCHAR(100) NOT NULL , `description` VARCHAR(500) NOT NULL ,
`metal_types` VARCHAR(50) NOT NULL ,
`concentration` VARCHAR(100) NOT NULL ,
`package_price` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `auto_kp`.`tails` (
`id` TINYINT(1) UNSIGNED NOT NULL ,
`name` ENUM('Марина','Сергей','Тимур','Дима') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`html` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO tails (name,html) VALUES("","");

*/
