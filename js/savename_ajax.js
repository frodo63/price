/*$(document).off().on('click', 'input.savename', function(){*/
$(document).off('click.savename').on('click.savename', 'input.savename', function(e){//Привязал вручную. Иначе (верхний вариант - скрипт не шел.
    var table = $('#theinput').parent().attr('category');
    var nameid = $('#theinput').attr('name');
    var newname = $('#theinput').val();

    $.ajax({
        url: 'mysql_rename.php',
        method: 'POST',
        data: {nameid:nameid, newname:newname, table:table},
        success: function (data) {
            console.log(data);
            $(e.target).addClass('edit').removeClass('savename').val('R');//Вернули кнопку в первоначальное положение
            $('#theinput').remove();//Убрали зэинпут
            if(table == 'byers' || table == 'sellers' || table == 'trades'){
                $('td[name="'+nameid+'"]').children('span').text(data);
            }else{
                $('input.collapsepos[position="'+nameid+'"]').siblings('span').remove();
                $('input.collapsepos[position="'+nameid+'"]').after($('<span class="name">' + data + '</span>'))
            };//Вставили новый спан с новым именем
            /*$(e.target).off();*///Отвязали от .edit (бывшей кнопки .savename все события
            //Триггерим клик на одной из таб, чтобы запустить весь процесс заново

            if(table != 'positions'){$("a[href = \"#" + table + "\"]").trigger("click")}else{//В завершение для обновления всех скриптов перезагружаем табу.
                $(e.target).parents("td[category='requests']").children("input.collapse").trigger("click.collapse").trigger("click.collapse");//То же с позицией? НОч уть сложнее через родителя
                
            };
            console.log('нажатие на табу произведено');
            console.log(table);

        },
        complete: function(){
            $('#editmsg').css('display', 'block'). delay(2000).slideUp(300).html('Покупатель/Позиция/запявка переименован со старого имени на ' + newname + '.');
            console.log(e.target);



        }
    });

});