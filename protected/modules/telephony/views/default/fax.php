<?php
/**
 * Отправка факса для пользователя.
 *
 * @var application\modules\telephony\controllers\DefaultController $this
 * @var application\modules\telephony\models\FormSendFax $model
 */

Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/extensions/ckeditor/ckeditor.js');

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Отправка факса')));

if (Yii::app()->user->hasFlash('success')) {
    echo CHtml::tag('div',
        array(
            'style' => 'color: green;',
        ),
        Yii::app()->user->getFlash('success')
    );
}

//<div class="alert alert-success">
//                <button type="button" class="close" data-dismiss="alert">×</button>
//Настройки сохранены
//</div>

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-send-fax',
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
        echo $form->textAreaRow($model, 'text', array('class' => 'ckeditor'));
        ?>
    </fieldset>

<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Отправить'
));

$this->endWidget();