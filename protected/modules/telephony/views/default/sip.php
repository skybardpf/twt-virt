<?php
/**
 * Управление SIP пользователя
 *
 * @var application\modules\telephony\controllers\DefaultController $this
 * @var application\modules\telephony\models\FormSIP $model
 */

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Настройки SIP')));

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
    'id' => 'form-sip',
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
        echo $form->textFieldRow($model, 'login', array('class' => 'input-xxlarge'));
        echo $form->textFieldRow($model, 'password', array('class' => 'input-xxlarge'));
        ?>
    </fieldset>

<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Сохранить'
));

$this->endWidget();