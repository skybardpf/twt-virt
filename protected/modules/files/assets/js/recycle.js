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
});