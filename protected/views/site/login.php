<?php
/**
 * @var $this SiteController
 * @var $model User
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

	<?=$form->errorSummary($model); ?>

	<?=$form->textFieldRow($model, 'email'); ?>
	<?=$form->passwordFieldRow($model, 'password')?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Войти'))?>
	</div>

	<?php $this->endWidget(); ?>

</div>