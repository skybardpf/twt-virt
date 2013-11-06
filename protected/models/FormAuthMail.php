<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 *
 */
class FormAuthMail extends CFormModel
{
    public $user_email_id = 0;

    public $repassword;
    public $old_password;
    public $password;

    public function attributeLabels()
    {
        return array(
            'user_email_id' => Yii::t('app', 'Email аккаунт'),
            'old_password' => Yii::t('app', 'Старый пароль'),
            'password' => Yii::t('app', 'Пароль'),
            'repassword' => Yii::t('app', 'Повтор пароля'),
        );
    }

    public function rules()
    {
        return array(
            array('user_email_id', 'required', 'skipOnError' => false),
            array('old_password, password, repassword', 'required', 'on' => 'change_pass'),
            array('old_password', 'changeOldPassword', 'on' => 'change_pass', 'skipOnError' => false),
            array('repassword', 'compare', 'compareAttribute' => 'password', 'on' => 'change_pass'),

        );
    }

    public function changeOldPassword()
    {
        if (!empty($this->user_email_id)){
            $email = UserEmail::model()->findByPk($this->user_email_id);
            if ($email !== null){
                if ($email->password !== $this->old_password){
                    $this->addError('old_password', 'Указан неправильный старый пароль');
                }
            }

        }
    }
}