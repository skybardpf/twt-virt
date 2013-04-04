$(function() {
    $('#Company_admin_user_id').select2({allowClear: true});
    $('#Company_resident').on('change', function () {
		$('fieldset[data-resident]').hide().find('input,select').attr('disabled', 'disabled');
		$('fieldset[data-resident='+$(this).val()+']').show().find('input,select').removeAttr('disabled');
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