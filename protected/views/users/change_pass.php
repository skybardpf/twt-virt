<?php
/**
 * @var $this UsersController
 * @var $model User
 * @var $form TbActiveForm
 */

$this->breadcrumbs=array(
	'Профиль'=>array('users/profile'),
	'Смена пароля',
);
$this->pageTitle = 'Сменить пароль';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<div class="form">

	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'model-form-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>true,

))?>

	<?php echo $form->errorSummary($model); ?>
	<div class="form-actions">
		<?php $buttons = $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> ($model->isNewRecord ? 'Добавить' : 'Сохранить')), true); ?>
		<?=$buttons?>
	</div>
	<fieldset>
			<?=$form->passwordFieldRow($model, 'old_password', array('class' => 'input-xxlarge'))?>
			<?=$form->passwordFieldRow($model, 'password', array('class' => 'input-xxlarge'))?>
			<?=$form->passwordFieldRow($model, 'repassword', array('class' => 'input-xxlarge'))?>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

	<?php $this->endWidget(); ?>

</div>