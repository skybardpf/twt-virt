<?php
/**
 * @var $this Admin_usersController
 * @var $model User
 * @var $form TbActiveForm
 */

Yii::app()->clientScript->registerScriptFile($this->asset_static.'/js/select2.min.js');
Yii::app()->clientScript->registerCssFile($this->asset_static.'/css/select2.css');
?>

<div class="form">

<?php
	/** @var $form TbActiveForm */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'model-form-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>true,
))?>

	<?php echo $form->errorSummary($model); ?>
	<div class="form-actions">
		<?php $buttons = $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> ($model->isNewRecord ? 'Добавить' : 'Сохранить')), true).'&nbsp'.
			$this->widget('bootstrap.widgets.TbButton', array('label'=> 'Отмена', 'url' => $this->createUrl('/admin_users/index')), true); ?>
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

		<?php /*
		<div class="control-group">
			<?=$form->labelEx($model, 'companies_ids', array('class' => 'control-label'))?>
			<div class="controls">
			<?php
				$baseID = CHtml::getIdByName('User[companies_ids][]');
				$id = 0;
				foreach ($model->getCompaniesList() as $company) :
			?>
					<div class="checkbox">
						<?php
						$admin = $company->admin_user_id && $company->admin_user_id == $model->id;
						if ($admin) {
							echo CHtml::hiddenField('User[companies_ids][]', $company->id);
						}
						echo CHtml::checkBox(
							'User[companies_ids][]',
							in_array($company->id, $model->companies_ids) or $admin,
							array(
								'value' => $company->id,
								'id' => $baseID.'_'.++$id,
								'disabled' => $admin
							)
						);
						?>
						<?=CHtml::label($company->name, $baseID.'_'.$id)?>
					</div>
				<?php endforeach ?>
			</div>
		</div> */?>
		<div class="control-group">
			<?=$form->labelEx($model, 'companies_ids_string', array('class' => 'control-label'))?>
			<div class="controls">
				<?php
				echo CHtml::hiddenField('User[companies_ids_string]', '');
				$baseID = CHtml::getIdByName('User[companies_ids_string]');

				$data = array();
				$preload_data = array();
				foreach ($model->getCompaniesList() as $company) {
					$tmp = array(
						'id'        => $company->id,
						'text'      => $company->name,
						'locked'    => $company->isAdmin($model->id),
					);
					if (in_array($company->id, $model->companies_ids)) {
						$preload_data[] = $company->id;
					}
					$data[] = $tmp;

				}
				Yii::app()->clientScript->registerScript('user_update_companies_select', 'js:
					$(document).ready(function(){
						$("#'.$baseID.'").select2({
							data: '.CJavaScript::encode($data).',
							width: "530px",
							multiple: true,
							allowClear: true,
							minimumInputLength: 1,
						});
						$("#'.$baseID.'").select2("val", '.CJavaScript::encode($preload_data).');
                        $(document.getElementById("'.$baseID.'").parentNode).on("blur", "input", function(event){
                            $(document.getElementById("'.$baseID.'")).select2("close");
                        });
						//$("#'.$baseID.'").select2("data", '.CJavaScript::encode($preload_data).');
					});
				'); ?>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

<?php $this->endWidget(); ?>

</div>