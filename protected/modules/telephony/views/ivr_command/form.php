<?php
use \application\modules\telephony\models as M;

/**
 * Добавление/редактирование голосовой команды.
 *
 * @var application\modules\telephony\controllers\Ivr_commandController $this
 * @var application\modules\telephony\models\FormIvrCommand $model
 */

$t = (($model->isNewRecord) ? 'Добавление' : 'Редактирование') . ' голосовой команды';
echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', $t)));

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-ivr-command',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnChange' => true,
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));

if ($model->hasErrors()) {
    echo $form->errorSummary($model);
}
?>

    <fieldset>
        <?php
        echo $form->textFieldRow($model, 'title', array('class' => 'input-xxlarge'));
        if ($model->filename_sound_ru){
            echo $form->labelEx($model, 'filename_sound_ru');
        }
        echo $form->fileFieldRow($model, 'upload_sound_ru', array('class' => 'input-xxlarge'));
        if ($model->filename_sound_en){
            echo $form->labelEx($model, 'filename_sound_en');
        }
        echo $form->fileFieldRow($model, 'upload_sound_en', array('class' => 'input-xxlarge'));
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