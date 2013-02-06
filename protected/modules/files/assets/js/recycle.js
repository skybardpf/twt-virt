/**
 * User: Forgon / Yury Zyuzkevich
 * Date: 06.02.13
 * Time: 13:03
 */
$(document).ready(function(){
    $('a.recycle_restore').click(function(){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        Loading.show();
        $.post(this.href, function(data){
            Loading.immidiate_hide();
            if (data.ret) {
                alert(data.ret+': '+data.error);
            } else {
                window.location.reload();
            }
            }
        , 'json');
        return false;
    });
    $('a.recycle_remove').click(function(){
        $(this.parentNode.parentNode.parentNode).removeClass('open');
        var strangedata = false;
        if (this.dataset.dir == '0') {
            var message = 'Вы действительно хотите удалить файл? Действие нельзя отменить.';
        } else if (this.dataset.dir == '1') {
            var message = 'Вы действительно хотите удалить папку? Действие нельзя отменить.';
        } else {
            strangedata = true;
        }
        if (!strangedata) {
            if (window.confirm(message)) {
                Loading.show();
                $.post(this.href, function(data){
                    Loading.immidiate_hide();
                    if (data.ret) {
                        alert(data.ret+': '+data.error);
                    } else {
                        window.location.reload();
                    }
                }
                , 'json');
            }
        }
        return false;
    });
    $('#recycle_remove_all').click(function(){
        if (window.confirm('Вы действительно хотите очистить корзину? Действие нельзя отменить.')) {
            var back_link = this.dataset.recycle;
            Loading.show();
            $.post(this.href, function(data){
                Loading.immidiate_hide();
                if (data.ret) {
                    alert(data.ret+': '+data.error);
                } else {
                    window.location = back_link;
                }
            }
            , 'json');
        }
        return false;
    });
});