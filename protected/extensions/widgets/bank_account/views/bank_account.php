<?php
	/**
	 * @var $this BankAccountWidget
	 * @var $bank_account CBankAccount
	 */
?>
<?php if ($bank_account) :?>
<div>
	<a href="<?=$this->controller->createUrl('update_account', array('company_id' => $company_id, 'resident' => $bank_account->resident, 'account_id' => $bank_account->id))?>"
	   data-account_resident="<?=$bank_account->resident?>"
	   data-bank_account_link="<?=$bank_account->id?>"
	   style="display:<?=($bank_account->resident == $company_resident) ? 'inline': 'none'?>;">
		<?=$bank_account->account_number?>, <?=$bank_account->bank?>
	</a>
	<a href="<?=$this->controller->createUrl('delete_account', array('account_id' => $bank_account->id))?>"
	   data-account_resident="<?=$bank_account->resident?>"
	   data-bank_account_delete="<?=$bank_account->id?>"
	   style="display:<?=($bank_account->resident == $company_resident) ? 'inline': 'none'?>;">
		Удалить
	</a>
</div>
<?php endif;?>