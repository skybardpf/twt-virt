<?php
namespace application\modules\telephony\models;

/**
 * Форма управления настройками внутреннего номера пользователя.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FormInternalNumber extends \CFormModel
{
    const INCOMING_CALL_ALLOWED = 0;
    const INCOMING_CALL_DISALLOWED_IN_IVR = 1;
    const INCOMING_CALL_DISALLOWED_DROPS_CALL = 2;
    const INCOMING_CALL_DISALLOWED_PERSON_NOT_AVAILABLE = 3;

    public $forwarding = false;
    public $forwarding_number;
    public $pin;

    /**
     * Настройки уведомлений
     */
    public $sms_notification_when_fax = false;
    public $voice_notification_when_fax = false;
    public $email_notification_when_fax = false;
    public $email_notification_when_voice_mail = false;
    public $sms_notification_when_voice_mail = false;
    public $voice_notification_when_voice_mail = false;
    public $email_to_send_information_fax;
    public $email_to_send_information_voice_mail;

    public $do_not_disturb = false;
    public $do_not_disturb_start;
    public $do_not_disturb_end;

    public $incoming_call_action_id = self::INCOMING_CALL_ALLOWED;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'forwarding' => \Yii::t('app', 'Переадресация'),
            'forwarding_number' => \Yii::t('app', 'Переадресация на номер'),
            'pin' => \Yii::t('app', 'ПИН'),

            'sms_notification_when_fax' => \Yii::t('app', 'СМС уведомление о приходе факса'),
            'voice_notification_when_fax' => \Yii::t('app', 'Голосовое уведомление о приходе факса'),
            'sms_notification_when_voice_mail' => \Yii::t('app', 'СМС уведомление о приходе голосовой почты'),
            'voice_notification_when_voice_mail' => \Yii::t('app', 'Голосовое уведомление о приходе голосовой почты'),

            'email_notification_when_fax' => \Yii::t('app', 'Email уведомление о приходе факса'),
            'email_notification_when_voice_mail' => \Yii::t('app', 'Email уведомление о голосовой почты'),
            'email_to_send_information_fax' => \Yii::t('app', 'Email для уведомлений о приходе факса'),
            'email_to_send_information_voice_mail' => \Yii::t('app', 'Email для уведомлений о приходе голосовой почты'),

            'do_not_disturb' => \Yii::t('app', 'Не беспокоить'),
            'do_not_disturb_start' => \Yii::t('app', 'Не беспокоить с'),
            'do_not_disturb_end' => \Yii::t('app', 'Не беспокоить по'),

            'incoming_call_action_id' => \Yii::t('app', 'Действие с входящими вызовами'),
        );
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('forwarding', 'required'),
            array('forwarding', 'boolean'),

//            array('forwarding', 'required'),
            array('forwarding_number', 'length', 'max' => 20),

//            array('pin', 'required'),
            array('pin', 'length', 'max' => 5),

            array('sms_notification_when_fax', 'required'),
            array('sms_notification_when_fax', 'boolean'),

            array('voice_notification_when_fax', 'required'),
            array('voice_notification_when_fax', 'boolean'),

            array('voice_notification_when_fax', 'required'),
            array('voice_notification_when_fax', 'boolean'),

            array('email_notification_when_fax', 'required'),
            array('email_notification_when_fax', 'boolean'),

            array('email_notification_when_voice_mail', 'required'),
            array('email_notification_when_voice_mail', 'boolean'),

            array('sms_notification_when_voice_mail', 'required'),
            array('sms_notification_when_voice_mail', 'boolean'),

            array('voice_notification_when_voice_mail', 'required'),
            array('voice_notification_when_voice_mail', 'boolean'),

//            array('email_to_send_information_fax', 'required'),
            array('email_to_send_information_fax', 'email'),
//            array('email_to_send_information_voice_mail', 'required'),
            array('email_to_send_information_voice_mail', 'email'),

            array('do_not_disturb', 'required'),
            array('do_not_disturb', 'boolean'),

//            array('do_not_disturb_start', 'required'),
            array('do_not_disturb_start', 'date', 'format' => 'HH:mm'),
//            array('do_not_disturb_end', 'required'),
            array('do_not_disturb_end', 'date', 'format' => 'HH:mm'),

            array('incoming_call_action_id', 'required'),
            array('incoming_call_action_id', 'in', 'range' => array_keys(self::getIncomingCallActions())),
        );
    }

    /**
     * @return array
     */
    public static function getIncomingCallActions()
    {
        return array(
            self::INCOMING_CALL_ALLOWED => \Yii::t('app', 'Разрешены (звонок будет проходить)'),
            self::INCOMING_CALL_DISALLOWED_IN_IVR => \Yii::t('app', 'Запрещены, звонящий возращается в корень IVR'),
            self::INCOMING_CALL_DISALLOWED_DROPS_CALL => \Yii::t('app', 'Запрещены, звонок сбрасывается'),
            self::INCOMING_CALL_DISALLOWED_PERSON_NOT_AVAILABLE => \Yii::t('app', 'Запрещены, звонящий слышит сообщение "Абонент недоступен"'),
        );
    }
}