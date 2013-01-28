$(document).ready(function(){
    $('tr.request_row').click(function(){
        window.location = this.dataset.url;
    });

    var support_closing_flag = false;
    $('.admin_support_closed').change(function(){
        if (support_closing_flag) return false;
        support_closing_flag = true;
        var checkbox = this;
        Loading.show();
        $.get(this.dataset.link, function(data){
                Loading.hide();
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
                support_closing_flag = false;
            }, 'json'
        );
        return false;
    });
    $('.admin_support_closed').click(function(){
        if (support_closing_flag) return false;
        $(this).change();
        return false;
    });
});
