<?php
namespace application\modules\telephony\models;

/**
 * Форма управления командами голосового меню.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FormIvrCommand extends \CFormModel
{
    public $title;
    public $isStandard = false;

    public $upload_sound_ru;
    public $upload_sound_en;

    public $filename_sound_ru;
    public $filename_sound_en;

    public $isNewRecord = true;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'title' => \Yii::t('app', 'Название'),
            'upload_sound_ru' => \Yii::t('app', 'Звук на русском'),
            'upload_sound_en' => \Yii::t('app', 'Звук на английском'),
        );
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('title', 'required','on'=>'insert,update'),
            array('title', 'length', 'max' => 50),

            array('upload_sound_ru, upload_sound_en', 'required','on'=>'insert'),
            array('upload_sound_ru, upload_sound_en', 'file', 'types'=>'wav, mp3',
                'allowEmpty'=>true,'on'=>'insert,update'),
        );
    }

    /**
     * @return array
     */
    public static function getStandardCommands()
    {
        return array(
            0 => \Yii::t('app', 'Сменить язык'),
            1 => \Yii::t('app', 'Отправить факс'),
            2 => \Yii::t('app', 'Голосовая почта'),
            3 => \Yii::t('app', 'Ввести внутренний номер'),
            4 => \Yii::t('app', 'Дождаться ответа оператора'),
        );
    }
}