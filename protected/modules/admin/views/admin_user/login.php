<?php
/**
 * @var $this Admin_userController
 * @var $admin AdminUser
 * @var $form TbActiveForm
 */
$this->breadcrumbs = array('Вход');
$this->pageTitle = 'Вход';
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'admin-login-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<?=$form->errorSummary($admin); ?>

	<?=$form->textFieldRow($admin, 'login'); ?>
	<?=$form->passwordFieldRow($admin, 'password')?>
	<?=$form->checkBoxRow($admin, 'notRememberSession')?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Войти'))?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->