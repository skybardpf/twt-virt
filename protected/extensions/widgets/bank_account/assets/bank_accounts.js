$(document).ready(function(){
	$(document).on('click', '[data-bank_account_link]', function () {
		$.get(this.href, function (data) {
			document.getElementById('modal-header').innerHTML = data.title;
			document.getElementById('modal-body').innerHTML = data.html;
			document.getElementById('modal-footer').innerHTML = data.footer;
			$('#ModalWindow').modal('show');
		}, 'json');
		return false;
	});

	$(document).on('click', '[data-bank_account_delete]', function () {
		var link = $(this);
		$.get(this.href, function (data) {
			if (data.code == 'error') {
				alert(data.message);
			} else if (data.code == 'Ok') {
				link.parent().remove();
			}
		}, 'json');
		return false;
	});

	$(document).on('click', '[data-save_button="account"]', function(){
		var $this = $(this);
		var form = document.getElementById('bank-account-form');
		var formdata = $(form).serialize();
		$.post(form.action, formdata, function(data){
			if (data.code == 'error') {
				alert(data.message);
			} else if (data.code == 'Ok') {
				var link = $('[data-bank_accounts="1"]').find('[data-bank_account_link="'+data.account_id+'"]');
				if (link.length) {
					link.parent().replaceWith(data.new_link);
				} else {
					$('[data-bank_accounts="1"]').append(data.new_link);
				}
				$('#ModalWindow').modal('hide');
			}
		}, 'json');
		return false;
	});
});