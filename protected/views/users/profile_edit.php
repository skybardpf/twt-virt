<?php
/**
 * @var $this UsersController
 * @var $model User
 * @var $form TbActiveForm
 */

$this->breadcrumbs=array(
	'Профиль'=>array('users/profile'),
	'Редактирование',
);
$this->pageTitle = 'Редактирование ';
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
		<?php $buttons = $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> ($model->isNewRecord ? 'Добавить' : 'Сохранить')), true).'&nbsp'.
			$this->widget('bootstrap.widgets.TbButton', array('label'=> 'Отмена', 'url' => $this->createUrl('/users/profile')), true); ?>
		<?=$buttons?>
	</div>
	<fieldset>

		<?=$form->textFieldRow($model, 'email', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model, 'name', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model, 'surname', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model, 'phone', array('class' => 'input-xxlarge')); ?>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

	<?php $this->endWidget(); ?>

</div>