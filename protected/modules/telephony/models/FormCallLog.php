<?php
namespace application\modules\telephony\models;

/**
 * Форма фильтрации логов звонков по пользователям компании.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FormCallLog extends \CFormModel
{
    public $user_id;

    public function attributeLabels()
    {
        return array(
            'user_id' => \Yii::t('app', 'Пользователь'),
        );
    }

    public function rules()
    {
        return array(
//            array('user_id', 'required'),
//            array('login', 'length', 'max' => 50),
//
//            array('password', 'required'),
//            array('password', 'length', 'max' => 20, 'min' => 3),
        );
    }
}