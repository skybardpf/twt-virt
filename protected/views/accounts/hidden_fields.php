<?php if($bank_account->id){
	$id = '[account]['.$bank_account->id.']';
} else {
	$id = '[new][new_count]';
}?>
<?=CHtml::activeHiddenField($bank_account, 'account_number', array('name' => 'CBankAccount'.$id.'[account_number]'));?>
<?=CHtml::activeHiddenField($bank_account, 'bank' , array('name' => 'CBankAccount'.$id.'[bank]'));?>
<?php if ($company_resident) { ?>
	<?=CHtml::activeHiddenField($bank_account, 'bik' , array('name' => 'CBankAccount'.$id.'[bik]'));?>
	<?=CHtml::activeHiddenField($bank_account, 'correspondent' , array('name' => 'CBankAccount'.$id.'[correspondent]'));?>
<?php } else { ?>
	<?=CHtml::activeHiddenField($bank_account, 'swift' , array('name' => 'CBankAccount'.$id.'[swift]'));?>
	<?=CHtml::activeHiddenField($bank_account, 'iban' , array('name' => 'CBankAccount'.$id.'[iban]'));?>
<?php }?>
