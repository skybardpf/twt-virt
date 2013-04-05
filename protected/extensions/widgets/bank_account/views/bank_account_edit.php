<?php
	/**
	 * @var $this BankAccountEditWidget
	 * @var $bank_account CBankAccount
	 */
?>
<div class="form">

	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'bank-account-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>true,
	))?>

	<fieldset>
		<?php if ($bank_account->resident) { ?>
			<?=$form->textFieldRow($bank_account, 'account_number', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($bank_account,'bank', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($bank_account,'bik', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($bank_account,'correspondent', array('class' => 'input-xxlarge')); ?>
		<?php } else { ?>
			<?=$form->textFieldRow($bank_account, 'account_number', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($bank_account,'bank', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($bank_account,'swift', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($bank_account,'iban', array('class' => 'input-xxlarge')); ?>
		<?php }?>
	</fieldset>
	<div class="form-actions">
		<?php
			$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Сохранить'), true);
			$this->widget('bootstrap.widgets.TbButton', array('label'=> 'Отмена'), true);
		?>
	</div>

	<?php $this->endWidget(); ?>

</div>