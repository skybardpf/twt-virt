<?php
	/**
	 * @var $this BankAccountsWidget
	 * @var $bank_accounts array() CBankAccount
	 */
?>

	<div data-bank_accounts="1">
		<?php if($bank_accounts) : foreach($bank_accounts as $account) :?>
			<?php $this->widget('ext.widgets.bank_account.BankAccountWidget', array(
				'bank_account'  => $account,
				'company_id' => $company_id,
				'company_resident' => $company_resident
			));?>
		<?php endforeach; endif;?>
	</div>
	<div>
		<a href="<?=$this->controller->createUrl('update_account', array('company_id' => $company_id, 'resident' => $company_resident))?>"
		   data-account_resident="<?=($company_resident) ? 1: 0?>"
		   data-bank_account_link=""
		   style="display:<?=$company_resident ? 'inline': 'none'?>;">
			Добавить
		</a>
		<a href="<?=$this->controller->createUrl('update_account', array('company_id' => $company_id, 'resident' => !$company_resident))?>"
		   data-account_resident="<?=($company_resident) ? 0: 1?>"
		   data-bank_account_link=""
		   style="display:<?=!$company_resident ? 'inline': 'none'?>;">
			Добавить
		</a>
	</div>

	<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'ModalWindow')); ?>
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h4 id="modal-header"></h4>
		</div>
		<div class="modal-body" id="modal-body"></div>
		<div class="modal-footer" id="modal-footer"></div>
	<?php $this->endWidget(); ?>
