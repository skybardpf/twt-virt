<?php
/**
 * @var $this Admin_companiesController
 * @var $model Company
 * @var $form TbActiveForm
 */
?>

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
		<?=$form->textFieldRow($model,'name', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'inn', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'kpp', array('class' => 'input-xxlarge')); ?>
		<?=$form->dropDownListRow($model, 'admin_user_id', array(null => 'не выбран') + CHtml::listData(User::model()->findAll(), 'id', 'fullName'),array('class' => 'input-xxlarge'))?>
		<?=$form->checkBoxRow($model, 'deleted')?>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

<?php $this->endWidget(); ?>

</div>