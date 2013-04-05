<?php
	/**
	 * @var $this BankAccountEditWidget
	 * @var $bank_account CBankAccount
	 */
?>
<div class="form">
	<fieldset>
		<?php if ($resident) { ?>
			<?=CHtml::activeLabelEx($bank_account, 'account_number', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'account_number' , array('class' => 'input-xlarge margin'));?>
			<?=CHtml::activeLabelEx($bank_account, 'bank', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'bank' , array('class' => 'input-xlarge margin'));?>
			<?=CHtml::activeLabelEx($bank_account, 'bik', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'bik' , array('class' => 'input-xlarge margin'));?>
			<?=CHtml::activeLabelEx($bank_account, 'correspondent', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'correspondent' , array('class' => 'input-xlarge margin'));?>
		<?php } else { ?>
			<?=CHtml::activeLabelEx($bank_account, 'account_number', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'account_number' , array('class' => 'input-xlarge margin'));?>
			<?=CHtml::activeLabelEx($bank_account, 'bank', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'bank' , array('class' => 'input-xlarge margin'));?>
			<?=CHtml::activeLabelEx($bank_account, 'swift', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'swift' , array('class' => 'input-xlarge margin'));?>
			<?=CHtml::activeLabelEx($bank_account, 'iban', array('class' => 'control-label lefter'));?>
			<?=CHtml::activeTextField($bank_account, 'iban' , array('class' => 'input-xlarge margin'));?>
		<?php }?>
	</fieldset>
</div>