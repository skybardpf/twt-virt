$('document').ready(function(){
    $('.delete-ivr-menu').click(function(){
        var local = $(this);
        $('<div>Удалить пункт голосового меню?</div>').dialog({
            modal: true,
            resizable: false,
            title: 'Удалить пункт голосового меню?',
            buttons: [{
                text: "Удалить",
                class: 'btn btn-danger',
                click: function(event){
                    var button = $(event.target);
                    var dialog = $(this);
                    button.attr('disabled', 'disabled');

                    Loading.show();
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: local.data('url'),
                        cache: false
                    }).done(function(data) {
                            if (!data.success) {
                                alert(data.message);
                            } else {
                                document.location.href = local.data('redirect');
                            }
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
});