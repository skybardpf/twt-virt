$(document).ready(function(){
    $('tr.request_row').click(function(){
        window.location = this.dataset.url;
    });
    $('.admin_support_closed').change(function(){
        var checkbox = this;
        $.get(this.dataset.link, function(data){
                if (data.error == '0') {
                    var parent = checkbox.parentNode.parentNode;
                    if (data.opened) {
                        $(parent).removeClass('success');
                        if (parent.dataset.prev_class) $(parent).addClass(parent.dataset.prev_class);
                        checkbox.checked = 0;
                    } else {
                        $(parent).removeClass('warning');
                        $(parent).addClass('success');
                        checkbox.checked = 1;
                    }
                }
                else alert('Произошла ошибка: '+data.message);
            }, 'json'
        );
        return false;
    });
    $('.admin_support_closed').click(function(){
        $(this).change();
        return false;
    });
});
