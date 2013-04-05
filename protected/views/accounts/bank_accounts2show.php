<?php if($bank_accounts) : foreach ($bank_accounts as $bank_account) : if($bank_account->resident == $company_resident) :?>
	<?=$bank_account->account_number?>, <?=$bank_account->bank?><br>
<?php endif;endforeach; endif;?>
