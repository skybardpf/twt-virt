<?php
namespace application\modules\telephony\models;

/**
 * Форма управления SIP настройками пользователя.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FormSIP extends \CFormModel
{
    public $login = 'Login';
    public $password = 'pass';

    public function attributeLabels()
    {
        return array(
            'login' => \Yii::t('app', 'Логин'),
            'password' => \Yii::t('app', 'Пароль'),
        );
    }

    public function rules()
    {
        return array(
            array('login', 'required'),
            array('login', 'length', 'max' => 50),

            array('password', 'required'),
            array('password', 'length', 'max' => 20, 'min' => 3),
        );
    }
}