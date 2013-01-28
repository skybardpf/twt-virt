$(document).ready(function(){
    $('a.file_rename').click(function(){
        var new_name = window.prompt('Введите новое имя:');
        Loading.show();
        if (new_name) {
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