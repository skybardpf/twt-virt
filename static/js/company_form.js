$(function() {
	$('#Company_resident').on('change', function () {
		$('fieldset[data-resident]').hide().find('input,select').attr('disabled', 'disabled');
		$('fieldset[data-resident='+$(this).val()+']').show().find('input,select').removeAttr('disabled');
	});
});