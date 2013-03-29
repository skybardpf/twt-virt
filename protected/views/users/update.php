<?php
/**
 * @var $this UsersController
 * @var $model User
 * @var $form TbActiveForm
 */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	$model->isNewRecord ? 'Добавление' : 'Редактирование',
);
$this->pageTitle = ($model->isNewRecord ? 'Добавление пользователя' : 'Редактирование «' . $model->name . ' ' . $model->surname .'»');
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
			$this->widget('bootstrap.widgets.TbButton', array('label'=> 'Отмена', 'url' => $this->createUrl('/users')), true); ?>
		<?=$buttons?>
	</div>
	<fieldset>

		<?=$form->textFieldRow($model, 'email', array('class' => 'input-xxlarge', 'disabled' => !in_array($model->scenario, array('owner_update', 'owner_create')))); ?>
		<?=$form->textFieldRow($model, 'name', array('class' => 'input-xxlarge', 'disabled' => !in_array($model->scenario, array('owner_update', 'owner_create')))); ?>
		<?=$form->textFieldRow($model, 'surname', array('class' => 'input-xxlarge', 'disabled' => !in_array($model->scenario, array('owner_update', 'owner_create')))); ?>
		<?=$form->textFieldRow($model, 'phone', array('class' => 'input-xxlarge', 'disabled' => !in_array($model->scenario, array('owner_update', 'owner_create')))); ?>

		<?php if ($model->isNewRecord) : ?>
			<?=$form->passwordFieldRow($model, 'password', array('class' => 'input-xxlarge', 'disabled' => !in_array($model->scenario, array('owner_update', 'owner_create'))))?>
			<?=$form->passwordFieldRow($model, 'repassword', array('class' => 'input-xxlarge', 'disabled' => !in_array($model->scenario, array('owner_update', 'owner_create'))))?>
		<?php endif ?>
		<?=$form->checkBoxRow($model, 'active', array('disabled' => !in_array($model->scenario, array('owner_update', 'owner_create'))))?>

		<div class="control-group">
			<?=$form->labelEx($model, 'companies_ids', array('class' => 'control-label'))?>
			<div class="controls">
				<?php
				$baseID = CHtml::getIdByName('User[companies_ids][]');
				$id = 0;
				foreach ($model->getCompaniesList(Yii::app()->user->id) as $company) :
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
								'disabled' => $admin ? $admin : (!$model->create_user_id && !in_array($company->id, $model->companies_ids))
							)
						);
						?>
						<?=CHtml::label($company->name, $baseID.'_'.$id)?>
					</div>
					<?php endforeach ?>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

	<?php $this->endWidget(); ?>

</div>