<?php
/**
 * @var $this CompaniesController
 * @var $model Company
 * @var $form TbActiveForm
 */
Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/../static/js/company_form.js'));

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

		<legend>Реквизиты компании</legend>
		<?=$form->textFieldRow($model,'legal_address', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'actual_address', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'phone', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model,'email', array('class' => 'input-xxlarge')); ?>
		<?=$form->dropDownListRow($model,'resident', array(0 => 'Не резидент РФ', 1 => 'Резидент РФ'), array('class' => 'input-xxlarge')); ?>
		<fieldset data-resident="1" <?=$model->resident? '' : 'style="display: none;"'?>>
			<?=$form->textFieldRow($model,'inn', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'kpp', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'okopf', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'ogrn', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>

			<legend>Реквизиты банковского счета</legend>
			<?=$form->textFieldRow($model,'account_number', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'bank', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'bik', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'correspondent_account', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>

		</fieldset>
		<fieldset data-resident="0" <?=$model->resident ? 'style="display: none;"' : ''?>>
			<?=$form->textFieldRow($model,'vat', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'registration_number', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'registration_date', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'registration_country', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>

			<legend>Реквизиты банковского счета</legend>
			<?=$form->textFieldRow($model,'account_number', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'bank', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'swift', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'iban', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>

			<legend>Данные о руководстве</legend>
			<?=$form->textFieldRow($model,'position_name1', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'position_owner1', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<hr>
			<?=$form->textFieldRow($model,'position_name2', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'position_owner2', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<hr>
			<?=$form->textFieldRow($model,'position_name3', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'position_owner3', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
		</fieldset>

	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

	<?php $this->endWidget(); ?>

</div>