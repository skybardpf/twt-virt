$(document).ready(function(){
    $('a.del-site').click(function(){
        var local = $(this);

        $('<div>Внимание!<br/>' +
            'Все данные сайта "'+local.data('site-name')+'" будут безвозвратно удалены,<br/>' +
            'в том числе Email аккаунты.<br/>' +
            'Вы действительно хотите удалить сайт "'+local.data('site-name')+'" ?</div>').dialog({
            modal: true,
            resizable: false,
            title: 'Удалить сайт?',
            buttons: [{
                text: "Удалить",
                class: 'btn btn-danger',
                click: function(event){
                    var dialog = $(this);

                    Loading.show();
                    $.ajax({
                        type: 'GET',
                        dataType: "json",
                        url: local.data('url'),
                        cache: false
                    }).done(function(data) {
                        if (data.success){
                            document.location.href = local.data('redirect-url');
                        } else {
                            alert(data.message);
                        }

                    }).fail(function(a, ret, message) {
                    }).always(function(){
                        Loading.hide();
                        dialog.dialog('destroy');
                    });
                }
            },{
                text: 'Отмена',
                class: 'btn',
                click: function(){ $(this).dialog('destroy'); }
            }]
        });

        return false;
    });

    var local = $(this);

});