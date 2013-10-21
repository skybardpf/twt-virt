$(document).ready(function(){
    $('a.del-site').click(function(){
        var button = $(this);
        if (confirm('Внимание! Все данные сайта '+button.data('site-name')+' будут безвозвратно удалены. \nВы действительно хотите удалить сайт '+button.data('site-name')+' ?')) {
            $.ajax({
                type: 'GET',
                dataType: "json",
                url: button.data('url'),
                cache: false
            }).done(function(data) {
                if (data.success){
                    document.location.href = button.data('redirect-url');
                } else {
                    alert(data.message);
                }

            }).fail(function(a, ret, message) {
            });
        }
        return false;
    });
});