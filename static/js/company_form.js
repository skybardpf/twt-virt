$(function() {
    $('#Company_admin_user_id').select2({allowClear: true});
    $('#Company_resident').on('change', function () {
		$('fieldset[data-resident]').hide().find('input,select').attr('disabled', 'disabled');
		$('fieldset[data-resident='+$(this).val()+']').show().find('input,select').removeAttr('disabled');
	    // активирование/дизактивирование полей "Данные о руководстве" при редактировании компании
	    var field_block_edit = $('fieldset[data-resident-edit="0"]');
	    ($(this).val() == field_block_edit.data('resident-edit')) ? field_block_edit.find('input,select').removeAttr('disabled'): field_block_edit.find('input,select').attr('disabled', 'disabled');
	});
    $('.bank_account_add_button').click(function(){
        var template = document.getElementById(this.dataset.resident);
        var account = template.cloneNode();
        account.removeAttribute('id');
        $(account).find('input,select').removeAttr('disabled');
        $(account).show();
        this.parentNode.parentNode.parentNode.appendChild(account);
        return false;
    });
});