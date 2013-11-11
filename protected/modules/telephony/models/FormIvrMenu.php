<?php
namespace application\modules\telephony\models;

/**
 * Форма управления пунктом голосового меню.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FormIvrMenu extends \CFormModel
{
    public $number;
    public $command_id;
    public $internal_number_id;

    public $isNewRecord = true;

    public function attributeLabels()
    {
        return array(
            'number' => \Yii::t('app', 'Комбинация цифр'),
            'command_id' => \Yii::t('app', 'Голосовая команда'),
            'internal_number_id' => \Yii::t('app', 'Внутренний номер'),
        );
    }

    public function rules()
    {
        return array(
            array('number', 'required'),
            array('number', 'numerical', 'integerOnly' => true),
            array('number', 'length', 'max' => 4, 'min' => 4),

//            array('password', 'required'),
//            array('password', 'length', 'max' => 20, 'min' => 3),
        );
    }
}