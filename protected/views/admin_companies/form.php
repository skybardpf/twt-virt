<?php
/**
 * @var $this Admin_companiesController
 * @var $model Company
 * @var $form TbActiveForm
 */
$select2_path = CHtml::asset(Yii::app()->basePath.'/../static/select2');
Yii::app()->clientScript->registerScriptFile($select2_path.'/select2.js');
Yii::app()->clientScript->registerCssFile($select2_path.'/select2.css');
Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/../static/js/company_form.js'));
?>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'model-form-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>true,

))?>

	<?php echo $form->errorSummary($model); ?>
	<div class="form-actions">
		<?php $buttons =
			$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> ($model->isNewRecord ? 'Добавить' : 'Сохранить')), true).'&nbsp'.
			$this->widget('bootstrap.widgets.TbButton', array('label'=> 'Отмена', 'url' => $this->createUrl('/admin_companies/index')), true); ?>
		<?=$buttons?>
	</div>
	<fieldset class="">
		<?=$form->textFieldRow($model,'name', array('class' => 'input-xxlarge')); ?>


		<div class="control-group">
			<?=$form->labelEx($model, 'admin_ids', array('class' => 'control-label'))?>
			<div class="controls">
				<?php
				echo CHtml::hiddenField('Company[admin_ids_string]', '');
				$baseID = CHtml::getIdByName('Company[admin_ids_string]');

				$data = array();
				$preload_data = array();
				foreach (User::model()->findAll() as $user) {
					$tmp = array(
						'id'        => $user->id,
						'text'      => $user->name.' '.$user->surname,
						'locked'    => false,
					);
					if (in_array($user->id, $model->getAdminIds())) {
						$preload_data[] = $tmp;
					}
					$data[] = $tmp;

				}
				Yii::app()->clientScript->registerScript('company_update_admins_select', 'js:
					$(document).ready(function(){
						$("#'.$baseID.'").select2({
							data: '.CJavaScript::encode($data).',
							width: "530px",
							multiple: true,
							allowClear: true,
							minimumInputLength: 1
						});
						//$("#'.$baseID.'").select2("val", '.CJavaScript::encode($preload_data).');
						$("#'.$baseID.'").select2("data", '.CJavaScript::encode($preload_data).');
					});
				'); ?>
			</div>
		</div>


		<?php /*$form->dropDownListRow($model, 'admin_user_id', array(null => '') + CHtml::listData(User::model()->findAll(), 'id', 'fullName'), array('class' => 'input-xxlarge', 'data-placeholder' => 'Не выбран'))*/?>
		<?=$form->checkBoxRow($model, 'deleted')?>

		<fieldset>
			<legend>Реквизиты компании</legend>
			<?=$form->textFieldRow($model,'legal_address', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'actual_address', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'phone', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'email', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'f_quote', array('class' => 'input-xxlarge')); ?>
			<?=$form->dropDownListRow($model,'resident', array(0 => 'Не резидент РФ', 1 => 'Резидент РФ'), array('class' => 'input-xxlarge')); ?>
        </fieldset>
		<fieldset data-resident="1" <?=$model->resident? '' : 'style="display: none;"'?>>
			<?=$form->textFieldRow($model,'inn', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'kpp', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'okopf', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
			<?=$form->textFieldRow($model,'ogrn', array('class' => 'input-xxlarge', 'disabled' => !$model->resident)); ?>
		</fieldset>
		<fieldset>
			<?php $this->widget('ext.widgets.bank_account.BankAccountsWidget', array(
				'bank_accounts'  => $model->bankAccounts,
				'company_id' => $model->id,
				'company_resident' => $model->resident
			)); ?>
		</fieldset>
		<!--<fieldset data-resident="0" <?=$model->resident ? 'style="display: none;"' : ''?>>
			<?=$form->textFieldRow($model,'vat', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'registration_number', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'registration_date', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
			<?=$form->textFieldRow($model,'registration_country', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>

			<fieldset>
				<legend>Реквизиты банковского счета</legend>
				<?=$form->textFieldRow($model,'account_number', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
				<?=$form->textFieldRow($model,'bank', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
				<?=$form->textFieldRow($model,'swift', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
				<?=$form->textFieldRow($model,'iban', array('class' => 'input-xxlarge', 'disabled' => $model->resident)); ?>
            </fieldset>
		</fieldset>-->
		<fieldset>
            <legend>Данные о руководстве</legend>
			<?=$form->textFieldRow($model,'position_name1', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'position_owner1', array('class' => 'input-xxlarge')); ?>
            <hr>
			<?=$form->textFieldRow($model,'position_name2', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'position_owner2', array('class' => 'input-xxlarge')); ?>
            <hr>
			<?=$form->textFieldRow($model,'position_name3', array('class' => 'input-xxlarge')); ?>
			<?=$form->textFieldRow($model,'position_owner3', array('class' => 'input-xxlarge')); ?>
		</fieldset>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

<?php $this->endWidget(); ?>

</div>