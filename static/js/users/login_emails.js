$('document').ready(function(){
    var modal_btn_save = $('#dataModal .button_save');

    $('.delete-login-email').click(deleteLoginEmail);

    function updateLoginEmail(){
        var $this = $(this);
        modal_btn_save.data('url', $this.data('url'));
        modal_btn_save.data('action', 'update');
        modal_btn_save.data('tr', $this.parents('tr'));
        Loading.show();
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: $this.data('url'),
            cache: false
        }).done(function(data) {
                if (data.result == 'error'){
                    alert(data.message);
                } else {
                    var modal = $('#dataModal');
                    modal.find('.modal-body').html(data.html);
                    modal.modal().css({
                        width: 'auto',
                        'margin-left': function () {
                            return -($(this).width() / 2);
                        }
                    });
                }
            }).fail(function(a, ret, message) {

            }).always(function(){
                Loading.hide();
            });
        return false;
    }

    $('.create_login_email').click(function(){
        var $this = $(this);
        modal_btn_save.data('url', $this.data('url'));
        modal_btn_save.data('action', 'create');
        Loading.show();
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: $this.data('url'),
            cache: false
        }).done(function(data) {
            if (data.result == 'error'){
                alert(data.message);
            } else {
                var modal = $('#dataModal');
                modal.find('.modal-body').html(data.html);
                modal.modal().css({
                    width: 'auto',
                    'margin-left': function () {
                        return -($(this).width() / 2);
                    }
                });
            }
        }).fail(function(a, ret, message) {

        }).always(function(){
            Loading.hide();
        });
        return false;
    });

    $('.update-login-email').click(updateLoginEmail);

    /**
     *  Сохранеям email аккаунт.
     */
    modal_btn_save.on('click', function(){
        var $this = $(this);
        Loading.show();
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: $this.data('url'),
            cache: false,
            data: $('#form-login-email').serialize()
        }).done(function(data) {
            if (data.result == 'error'){
                alert(data.message);

            } else if (data.result == 'show_form'){
                var modal = $('#dataModal');
                modal.find('.modal-body').html(data.html);

            } else {
                var action = $this.data('action');
                var table = $('#grid-login-emails');
                if (action == 'create'){
                    if (table.find('.empty')){
                        table.find('.empty').parents('tr').remove();
                    }
                    var number = ((table.find('tr').size())%2 === 0) ? 'even' : 'odd';
                    var html = '<tr class="'+number+'">'+data.html+'</tr>';

                    table.find('tbody').append(html);
                } else if (action == 'update'){
                    $this.data('tr').html(data.html);
                }
                $('.update-login-email').off('click').on('click', updateLoginEmail);
                $('.delete-login-email').off('click').on('click', deleteLoginEmail);
                $('#dataModal').modal('hide');
            }
        }).fail(function(a, ret, message) {

        }).always(function(){
            Loading.hide();
        });
        return false;
    });

    /**
     * Удаляем логин email
     */
    function deleteLoginEmail(){
        var local = $(this);
        $('<div>Вы действительно хотите удалить логин Email?</div>').dialog({
            modal: true,
            resizable: false,
            title: 'Удалить из списка?',
            buttons: [{
                text: "Удалить",
                class: 'btn btn-danger',
                click: function(event){
                    var dialog = $(this);

                    Loading.show();
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: local.data('url'),
                        cache: false
                    }).done(function(data) {
                        console.log(data.success);
                        if (!data.success){
                            alert(data.message);
                        } else {
                            local.parents('tr').remove();
                            var table = $('#grid-login-emails');
                            if (table.find('tr').size() == 1){
                                table.find('tbody').append(
                                    '<tr>' +
                                        '<td colspan="4" class="empty">' +
                                        '<span class="empty">Нет результатов.</span>' +
                                        '</td>' +
                                    '</tr>'
                                );
                            }
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
    }
});