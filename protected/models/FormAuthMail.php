<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 *
 */
class FormAuthMail extends CFormModel
{
    public $user_email_id = 0;

    public function attributeLabels()
    {
        return array(
            'user_email_id' => Yii::t('app', 'Email аккаунт'),
        );
    }

    public function rules()
    {
        return array(
            array('user_email_id', 'required'),
        );
    }
}