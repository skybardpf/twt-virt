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
                        $(parent).addClass('not_readed').addClass('warning');
                        checkbox.checked = 0;
                    } else {
                        $(parent).removeClass('not_readed').removeClass('warning');
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
