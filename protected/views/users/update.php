<?php
/**
 * @var $this UsersController
 * @var $model User
 * @var $form TbActiveForm
 */

Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(
    Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css'
);

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
			$this->widget('bootstrap.widgets.TbButton', array('label'=> 'Отмена', 'url' => $this->createUrl('/users/index', array('company_id' => $company_id))), true); ?>
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
						$admin = $company->isAdmin($model->id);
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

        <?php if (!$model->isNewRecord) { ?>
        <div class="control-group">
            <?= CHtml::label('Email логины', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    $this->renderPartial(
                        'login_emails',
                        array(
                            'user' => $model
                        )
                    );
                ?>
            </div>
        </div>
        <?php } ?>

	</fieldset>
	<div class="form-actions">
		<?=$buttons?>
	</div>

	<?php $this->endWidget(); ?>

</div>

<?php
    if (!$model->isNewRecord) {
       /**
        * Модальное окошко для добавления/редактирования Email аккаунта
        */
        $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'dataModal'));
        ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h4><?= Yii::t("menu", "Email аккаунт") ?></h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t("menu", "Сохранить"),
                'url' => '#',
                'htmlOptions' => array('class' => 'button_save', 'data-dismiss' => 'modal'),
            ));

            $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t("menu", "Отмена"),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            ));
            ?>
        </div>
    <?php
        $this->endWidget();
    }
    ?>