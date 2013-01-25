$(document).ready(function(){
    $('tr.request_row').click(function(){
        window.location = this.dataset.url;
    });
    $('a.admin_support_close').click(function(){
        var link = this;
        $.get(this.href, function(data){
                if (data == '0') link.parentNode.innerHTML = "Закрыт";
                else alert('Произошла ошибка: '+data);
            }, 'text'
        );
        return false;
    });
});
