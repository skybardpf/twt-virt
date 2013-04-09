<?=CHtml::activeHiddenField($bank_account, 'account_number', array('name' => 'CBankAccount[account][new_count][account_number]'));?>
<?=CHtml::activeHiddenField($bank_account, 'bank' , array('name' => 'CBankAccount[account][new_count][bank]'));?>
<?php if ($company_resident) { ?>
	<?=CHtml::activeHiddenField($bank_account, 'bik' , array('name' => 'CBankAccount[account][new_count][bik]'));?>
	<?=CHtml::activeHiddenField($bank_account, 'correspondent' , array('name' => 'CBankAccount[account][new_count][correspondent]'));?>
<?php } else { ?>
	<?=CHtml::activeHiddenField($bank_account, 'swift' , array('name' => 'CBankAccount[account][new_count][swift]'));?>
	<?=CHtml::activeHiddenField($bank_account, 'iban' , array('name' => 'CBankAccount[account][new_count][iban]'));?>
<?php }?>