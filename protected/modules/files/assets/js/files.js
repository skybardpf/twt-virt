$(document).ready(function(){
    $('a.file_rename').click(function(){
        var new_name = window.prompt('Введите новое имя:', this.dataset.name);
        if (new_name && new_name != this.dataset.name) {
            Loading.show();
            $.post(this.href, {name: new_name, ajax: 'index_rename'}, function(data){
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
});