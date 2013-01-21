<?php
/* @var $this Admin_userController */
/* @var $admin AdminUser */
/* @var $form TbActiveForm */
?>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'admin-form-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>true,

))?>

	<?php echo $form->errorSummary($admin); ?>
	<div class="form-actions">
		<?php $buttons = $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> ($admin->isNewRecord ? 'Добавить' : 'Сохранить')), true); ?>
		<?=$buttons?>
	</div>
	<fieldset>

		<?=$form->textFieldRow($admin,'login'); ?>
		<?=$form->textFieldRow($admin,'email'); ?>
	<?php if ($admin->isNewRecord ): ?>
		<?=$form->passwordFieldRow($admin,'password'); ?>
		<?=$form->passwordFieldRow($admin,'repassword'); ?>
	<?php endif ?>
		<?=$form->checkBoxRow($admin, 'block')?>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

<?php $this->endWidget(); ?>

</div>