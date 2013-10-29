<?php

namespace application\models\Mail;

/**
 * БД mail. Для управления аккаунтами юзеров почтового сервера.
 *
 * @property string $email
 * @property string $password
 */
class User extends \CActiveRecord
{
    /**
     * @return \CDbConnection
     */
    public function getDbConnection()
    {
        return \Yii::app()->db_mail;
    }

    public function primaryKey()
    {
        return 'email';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }
}