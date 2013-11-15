<?php

/**
 * This is the model class for table "user_emails".
 *
 * The followings are the available columns in table 'user_emails':
 * @property string $id
 * @property string $user_id
 * @property string $site_id
 * @property string $login_email
 * @property string $password
 *
 * Relations:
 * @var User $user
 * @var Sites $site
 */
class UserEmail extends CActiveRecord
{
    const DEFAULT_LOGIN_EMAIL_ADMIN = 'info';

    public $repeat_password = '';
    public $old_password = '';
    public $site_id = 0;

    public $old_email;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserEmail the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_emails';
    }

    /**
     * @return array validation rules for model attributes.
     */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive UserEmail inputs.
		return array(
			array('login_email, site_id', 'required'),
			array('password, repeat_password', 'required', 'on' => 'create'),

            array('login_email', 'length', 'max' => 100),
            array('password, repeat_password', 'length', 'max' => 30),
			array('repeat_password', 'compare', 'compareAttribute' => 'password', 'on' => 'create, update'),

			array('login_email', 'uniqueLogin'),
		);
	}

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::HAS_ONE, 'User', 'user_id'),
            'site' => array(self::HAS_ONE, 'Sites', array('id' => 'site_id')),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '#',
            'login_email' => 'Логин E-mail',
            'site_id' => 'Домен',
            'password' => 'Пароль',
            'repeat_password' => 'Повтор пароля',
            'old_password' => 'Старый пароль',
        );
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        if ($this->scenario === 'update' && empty($this->password)){
            $this->password = $this->old_password;
        }
        return parent::beforeSave();
    }


    public function afterDelete()
    {
        parent::afterDelete();

        \application\models\Mail\User::model()->deleteByPk(
            $this->login_email.'@'.$this->site->domain.'.'.Yii::app()->params->httpHostName
        );
    }
    /**
     * @param $attribute
     */
    public function uniqueLogin($attribute)
    {
//        $condition = 'user_id=:user_id AND site_id=:site_id AND login_email=:login_email';
        $condition = 'site_id=:site_id AND login_email=:login_email';
        $params = array(
            ':login_email' => $this->$attribute,
//            ':user_id' => $this->user_id,
            ':site_id' => $this->site_id,
        );
        if (!$this->isNewRecord){
            $condition .= ' AND id != :id';
            $params[':id'] = $this->primaryKey;
        }
        $model = $this->find($condition, $params);
        if ($model){
            $this->addError($attribute, Yii::t('app', 'Для данного домена уже существует такой Email аккаунт'));
        }
    }

    /**
     * @return string
     */
    public function getFullDomain()
    {
        $ret = '';
        if (!$this->isNewRecord){
            $ret = $this->login_email.'@'.$this->site->domain.'.'.Yii::app()->params->httpHostName;
        }
        return $ret;
    }

    /**
     * Изменяем email и/или пароль на Devecot.
     *
     * $this->old_email - должен содержать старое значение Email аккаунта. @see getFullDomain().
     * $this->old_password - должен содержать старый пароль
     */
    public function changeLoginPassDevecot()
    {
        if (!$this->isNewRecord){
            $user = new application\models\Mail\User();
            $new_email = $this->getFullDomain();
            $condition = array();
            $params = array();
            if ($this->old_email != $new_email){
                $condition[] = 'email=:email';
                $params[':email'] = $new_email;
            }
            if ($this->password != $this->old_password){
                $condition[] = 'password=ENCRYPT(:password)';
                $params[':password'] = $this->password;
            }
            if (!empty($condition)){
                $condition = implode(',', $condition);
                $params[':old_email'] = $this->old_email;
                $cmd = $user->getDbConnection()->createCommand('
                    UPDATE '.$user->tableName().' SET '.$condition.'
                    WHERE email=:old_email
                ');
                $cmd->execute($params);
            }
        }
    }

    public static function generatePassword($length = 8)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}