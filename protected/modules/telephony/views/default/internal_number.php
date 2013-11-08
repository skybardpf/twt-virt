<?php
/**
 * @var application\modules\telephony\controllers\DefaultController $this
 * @var application\modules\telephony\models\FormInternalNumber $model
 */

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Настройки внутреннего номера')));

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
    'id' => 'form-internal-number',
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
        echo $form->checkBoxRow($model, 'forwarding', array('class' => 'input-xxlarge'));
        echo $form->textFieldRow($model, 'forwarding_number', array('class' => 'input-xxlarge'));
        echo $form->textFieldRow($model, 'pin', array('class' => 'input-xxlarge'));

        echo $form->checkBoxRow($model, 'sms_notification_when_fax', array('class' => 'input-xxlarge'));
        echo $form->checkBoxRow($model, 'voice_notification_when_fax', array('class' => 'input-xxlarge'));
        echo $form->checkBoxRow($model, 'sms_notification_when_voice_mail', array('class' => 'input-xxlarge'));
        echo $form->checkBoxRow($model, 'voice_notification_when_voice_mail', array('class' => 'input-xxlarge'));

        echo $form->checkBoxRow($model, 'email_notification_when_fax', array('class' => 'input-xxlarge'));
        echo $form->textFieldRow($model, 'email_to_send_information_fax', array('class' => 'input-xxlarge'));
        echo $form->checkBoxRow($model, 'email_notification_when_voice_mail', array('class' => 'input-xxlarge'));
        echo $form->textFieldRow($model, 'email_to_send_information_voice_mail', array('class' => 'input-xxlarge'));

        echo $form->checkBoxRow($model, 'do_not_disturb', array('class' => 'input-xxlarge'));
        ?>
        <div class="control-group">
            <?= $form->labelEx($model, 'do_not_disturb_start', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'do_not_disturb_start',
                        'language' => 'ru',
                        'mode'    => 'time',
                        'options' => array(
//                            'minDateTime' => date('Y-m-d 00:00:00'),
                            'showAnim' => 'fold',
//                            'dateFormat' => 'yy-mm-dd',
                            'timeFormat' => 'hh:mm',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'showOn' => 'button',
                            'constrainInput' => 'true',
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        )
                    )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
            <?= $form->labelEx($model, 'do_not_disturb_end', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'do_not_disturb_end',
                        'language' => 'ru',
                        'mode'    => 'time',
                        'options' => array(
//                            'minDateTime' => date('Y-m-d 00:00:00'),
                            'showAnim' => 'fold',
//                            'dateFormat' => 'yy-mm-dd',
                            'timeFormat' => 'hh:mm',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'showOn' => 'button',
                            'constrainInput' => 'true',
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        )
                    )
                );
                ?>
            </div>
        </div>
        <?php

//        echo $form->textFieldRow($model, 'do_not_disturb_start', array('class' => 'input-xxlarge'));
//        echo $form->textFieldRow($model, 'do_not_disturb_end', array('class' => 'input-xxlarge'));

        echo $form->dropDownListRow($model, 'incoming_call_action_id', $model->getIncomingCallActions(), array('class' => 'input-xxlarge'));
        ?>
    </fieldset>

<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Сохранить'
));

$this->endWidget();