<?php
use \application\modules\telephony\models as M;

/**
 * Добавление/редактирование пункта голосового меню.
 *
 * @var application\modules\telephony\controllers\Ivr_menuController $this
 * @var application\modules\telephony\models\FormIvrMenu $model
 */

$t = (($model->isNewRecord) ? 'Добавление' : 'Редактирование') . ' пункта голосового меню';
echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', $t)));

if (Yii::app()->user->hasFlash('success')) {
    echo CHtml::tag('div',
        array(
            'style' => 'color: green;',
        ),
        Yii::app()->user->getFlash('success')
    );
}

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-ivr-menu',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnChange' => true,
    ),
));

if ($model->hasErrors()) {
    echo $form->errorSummary($model);
}
?>

    <fieldset>
        <?php
        echo $form->textFieldRow($model, 'number', array('class' => 'input-xxlarge'));
        echo $form->dropDownListRow($model, 'command_id', M\FormIvrCommand::getStandardCommands(), array('class' => 'input-xxlarge'));
        echo $form->dropDownListRow($model, 'internal_number_id', array(), array('class' => 'input-xxlarge'));
        ?>
    </fieldset>

<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Сохранить'
));
echo '&nbsp;&nbsp;';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'link',
    'label' => 'Отмена',
    'url' => $this->createUrl('index', array('cid' => $this->company->primaryKey)),
));


$this->endWidget();