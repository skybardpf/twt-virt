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

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'title' => \Yii::t('app', 'Название'),
        );
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 50),
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