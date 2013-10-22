<?php

/**
 * БД mail. Для управления доменными именами почтового сервера.
 *
 * @property string $domain
 */
class Domain extends CActiveRecord
{
    /**
     * @return CDbConnection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_mail;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Domain the static model class
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
        return 'domains';
    }
}