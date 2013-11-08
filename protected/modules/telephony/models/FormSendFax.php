<?php
namespace application\modules\telephony\models;

/**
 * Форма отправки факса пользователем.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FormSendFax extends \CFormModel
{
    public $number;
    public $text;

    public function attributeLabels()
    {
        return array(
            'number' => \Yii::t('app', 'Номер телефона'),
            'text' => \Yii::t('app', 'Текст письма'),
        );
    }

    public function rules()
    {
        return array(
            array('number', 'required'),
            array('number', 'length', 'max' => 20, 'min' => 9),

            array('text', 'required'),
            array('text', 'length', 'max' => 1000),
        );
    }
}