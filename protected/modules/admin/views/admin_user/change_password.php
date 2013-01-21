<?php
/* @var $this Admin_userController */
/* @var $model AdminUser */
/* @var $form TbActiveForm */


$this->breadcrumbs=array(
	'Администраторы'=>array('/admin/admin_user'),
	'Смена пароля'
);
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'admin-change_password-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?=$form->passwordFieldRow($model,'password'); ?>
	<?=$form->passwordFieldRow($model,'repassword'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Сменить пароль')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>