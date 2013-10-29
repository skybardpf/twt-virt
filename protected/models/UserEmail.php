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
    public $repeat_password = '';
    public $old_password = '';
    public $site_id = 0;

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
            'site' => array(self::HAS_ONE, 'Sites', array('site_id')),
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
            'site_id' => 'Площадка',
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
    /**
     * @param $attribute
     */
    public function uniqueLogin($attribute)
    {
        $condition = 'user_id=:user_id AND site_id=:site_id AND login_email=:login_email';
        $params = array(
            ':login_email' => $this->$attribute,
            ':user_id' => $this->user_id,
            ':site_id' => $this->site_id,
        );
        if (!$this->isNewRecord){
            $condition .= ' AND id != :id';
            $params[':id'] = $this->primaryKey;
        }
        $model = $this->find($condition, $params);
        if ($model){
            $this->addError($attribute, Yii::t('app', 'Для данной площадки уже существует такой логин'));
        }
    }
}