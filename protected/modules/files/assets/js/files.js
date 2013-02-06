$(document).ready(function(){
    $('a.file_rename').click(function(){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        var new_name = window.prompt('Введите новое имя:', this.dataset.name);
        if (new_name && new_name != this.dataset.name) {
            Loading.show();
            $.post(this.dataset.link, {name: new_name, ajax: 'index_rename'}, function(data){
                if (data.error) {
                    Loading.hide();
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
                $('#ModalWindow').modal('hide')
                window.prompt('Ваша ссылка:', data.link);
            }
        } else {
            Loading.hide();
            alert(data.error);
        }
    }
    $('a.file_link').click(function(){
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
});