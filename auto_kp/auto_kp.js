$(document).ready(function() {

    /*ФОРМИРОВАНИЕ КП*///////////////////////////////////////////////////////////////////////////////////////
    $(document).off('click.mail_compose').on('click.mail_compose', '.mail_compose', function (event) {
        console.log('imalive!');

        var body_options = $('.mail_body_parts input[type="checkbox"]:checked, .mail_tail_parts input[type="radio"]:checked');
        var mail_array = [];
        var options_length = body_options.length;



        for(var i = 0; i < options_length; i++){
            //Сформировать массив запрашиваемых данных
            mail_array.push($(body_options[i]).attr("id"));
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