<?php
/**
 * @var $this Admin_usersController
 * @var $model User
 * @var $form TbActiveForm
 */
$languages_code = array('' => 'выберите код языка');
foreach (Yii::app()->locale->getLocaleIDs() as $code) {
	$languages_code[$code] = Yii::app()->locale->getLanguage($code) . " ($code)";
}

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

		<?=$form->textFieldRow($model, 'email', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model, 'name', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model, 'surname', array('class' => 'input-xxlarge')); ?>
		<?=$form->textFieldRow($model, 'phone', array('class' => 'input-xxlarge')); ?>

		<?php if ($model->isNewRecord) : ?>
			<?=$form->passwordFieldRow($model, 'password', array('class' => 'input-xxlarge'))?>
			<?=$form->passwordFieldRow($model, 'repassword', array('class' => 'input-xxlarge'))?>
		<?php endif ?>
		<?=$form->checkBoxRow($model, 'active')?>

		<?=$form->checkBoxListRow($model, 'companies_ids', $model->getCompaniesList())?>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

<?php $this->endWidget(); ?>

</div>