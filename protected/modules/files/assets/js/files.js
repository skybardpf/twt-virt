$(document).ready(function(){
    // Переименовать файл/папку
    $('a.file_rename').click(function(){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        var new_name = window.prompt('Введите новое имя:', this.dataset.name);
        if (new_name && new_name != this.dataset.name) {
            Loading.show();
            $.post(this.dataset.link, {name: new_name, ajax: 'index_rename'}, function(data){
                if (data.error) {
                    Loading.immidiate_hide();
                    alert('Произошла ошибка: '+data.message);
                } else {
                    window.location.reload();
                }
            }, 'json');
            return false;
        }
        return false;
    });

    function parseLinkData(data) {
        if (data.ret == 0) {
            if (data.new == 1) {
                Loading.hide();
                document.getElementById('modal-header').innerHTML = data.title;
                document.getElementById('modal-body').innerHTML = data.html;
                document.getElementById('modal-footer').innerHTML = data.footer;
                $('#ModalWindow').modal('show');
            } else {
                Loading.immidiate_hide();
                //$('#ModalWindow').modal('hide');
                //window.prompt('Ваша ссылка:', data.link);
	            document.getElementById('modal-header').innerHTML = data.title;
	            document.getElementById('modal-body').innerHTML = data.html;
	            document.getElementById('modal-footer').innerHTML = data.footer;
	            $('#ModalWindow').modal('show');

                var $delete_link = $('[data-file_id='+data.file_id+']').find('[data-action=delete_link]');
                if (!$delete_link.length) {
                    // Вставляем ссылку "Удалить временную ссылку"
	                $('[data-file_id='+data.file_id+'] > ul').append(data.remove_link);
	                // Вставляем в правую колонку таблицы две иконки: "Посмотреть временную ссылку" и  "Удалить временную ссылку"
	                $('[data-td_file_id='+data.file_id+']').append(data.show_remove_icons);
                }
            }
        } else {
            Loading.immidiate_hide();
            alert(data.error);
        }
    }

	$(document).on('click', 'a.file_link', function(){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        Loading.show();
        $.post(this.href, function(data){
            parseLinkData(data);
        }, 'json');
        return false;
    });

    $('#link-create-form-submit').live('click', function(){
        Loading.show();
        var form = document.getElementById('link-create-form');
        var formdata = $(form).serialize();
        $.post(form.action, formdata, function(data){
            parseLinkData(data);
        }, 'json');
        return false;
    });

    $('a.file_delete').click(function(){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        Loading.show();
        $.post(this.href, function(data){
            Loading.immidiate_hide();
            if (data.ret) {
                alert(data.error);
            } else window.location.reload();
        }, 'json');
        return false;
    });

    $(document).on('click', '[data-action=delete_link]', function(event){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        Loading.show();
        var action_link = this;
        $.post(this.href, function(data){
            Loading.immidiate_hide();
            var a_cont = document.getElementById('alerts_container');
            if (data.ret) {
                $(a_cont).append('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Ошибка!</h4>'+data.error+'</div>');
            } else {
	            // при удалении временной ссылки удаляется ссылка на удаление в выпадающем меню и ссылки просмотра/удаления в правом столбце таблицы
	            $(action_link).parents('tr').find('[data-action="delete_link"]').each(function () {
					$(this.parentNode).remove();
	            });
                //$(action_link.parentNode).remove();
                $(a_cont).append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Готово!</h4>'+data.message+'</div>');
            }
        }, 'json');
        return false;
    });

    // ↓↓↓↓ Перемещение файлов и папок ↓↓↓↓

        // Диалог выбора места назначения
        $('a.file_move').click(function(){
            $(this.parentNode.parentNode.parentNode).removeClass('open');
            Loading.show();
            $.post(this.href, function(data){
                if (data.ret) {
                    Loading.immidiate_hide();
                    alert(data.error);
                } else {
                    Loading.hide();
                    document.getElementById('modal-header').innerHTML = data.title;
                    document.getElementById('modal-body').innerHTML = data.html;
                    document.getElementById('modal-footer').innerHTML = data.footer;
                    $('#ModalWindow').modal('show');
                    console.dir(data);
                }
            }, 'json');
            return false;
        });

        // Сворачивание и разворачивание папок в модальном окне
        $('.dir_expand').live('click', function(){
            var $this = $(this);
            if ($this.hasClass('icon-folder-close')) {
                $this.removeClass('icon-folder-close').addClass('icon-folder-open');
            } else {
                $this.removeClass('icon-folder-open').addClass('icon-folder-close');
            }
            $(this.parentNode).children('ul').toggle()
            return false;
        });

        // Выбор папки назначения для перемещения
        $('.dir_target').live('click', function(){
            var $this = $(this);
            var $i = $(this.parentNode).children('i');
            if ($i.hasClass('icon-folder-close') && $i.hasClass('dir_expand')) {
                $i.click();
            }
            if ($this.hasClass('dir_selected')) {
                $('.dir_target').removeClass('dir_selected');
                $('#move_button').addClass('disabled').attr('disabled', 'disabled');
            } else {
                $('.dir_target').removeClass('dir_selected');
                $(this).addClass('dir_selected');
                $('#move_button').removeClass('disabled').removeAttr('disabled');
            }
            return false;
        });

        $('#move_button').live('click', function(){
            var $this = $(this);
            // Нажата выключенная кнопка
            if ($this.hasClass('disabled')) return false;

            var $elem = $('.dir_target.dir_selected');
            if ($elem.length == 0) {
                alert('Выберите пожалуйста папку-назначение.');
            } else if ($elem.length > 1) {
                alert('Может быть выбрана только одна папка.');
            } else {
                Loading.show();
                $.post(this.dataset.link, {target_id: $elem.get(0).dataset.id}, function(data){
                    Loading.immidiate_hide();
                    if (data.ret) {
                        alert(data.error);
                    } else {
    //                    prompt(data.message, data.link);
                        window.location.reload();
                    }
                }, 'json');
            }
            return false;
        });

    // ↑↑↑↑ Перемещение файлов и папок ↑↑↑↑
});