<?php
/**
 * @var $this CompaniesController
 * @var $model Company
 * @var $form TbActiveForm
 */

$this->breadcrumbs=array(
	'Компания «' . $model->name .'»' => $this->createUrl('/companies/view', array('company_id' => $model->id)),
	'Редактирование',
);
$this->pageTitle = 'Редактирование компании «' . $model->name .'»';
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
		<?=$form->textFieldRow($model,'name', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'inn', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'kpp', array('class' => 'input-xxlarge')); ?>

	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

	<?php $this->endWidget(); ?>

</div>