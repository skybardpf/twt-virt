<?php

/**
 * This is the model class for table "admin".
 *
 * The followings are the available columns in table 'admin':
 * @property string $id
 * @property string $date_create
 * @property string $date_edit
 * @property string $login
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property integer $block
 */
class AdminUser extends CActiveRecord
{
	public $notRememberSession = 0;
	public $repassword;
	public $block = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminUser the static model class
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
		return 'admin_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, notRememberSession', 'required', 'on' => 'login'),
			array('login, email', 'required', 'on' => 'insert, update'),
			array('login, email', 'unique', 'on' => 'insert, update'),
			array('password, repassword', 'required', 'on' => 'insert, ch_pass'),
			array('repassword', 'compare', 'compareAttribute' => 'password', 'on' => 'insert, ch_pass'),
			array('email', 'email', 'on' => 'insert, update'),
			array('block', 'numerical', 'integerOnly'=>true, 'on' => 'insert, update'),
			array('block', 'blockLastUser', 'integerOnly'=>true, 'on' => 'update'),
			array('login', 'length', 'max'=>16, 'on' => 'insert, update'),
			array('password, salt', 'length', 'max'=>32, 'on' => 'insert, ch_pass'),
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
		);
	}

	public static function createHash($password, $salt)
	{
		return md5(md5($salt.$password).md5($salt.$password.$salt).md5($password.$salt));
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date_create' => 'Дата создания',
			'date_edit' => 'Дата редактирования',
			'login' => 'Логин',
			'password' => 'Пароль',
			'salt' => 'Соль',
			'email' => 'E-mail',
			'block' => 'Блокировка',
			'notRememberSession' => 'Чужой компьютер',
			'repassword' => 'Повторите пароль'
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->date_create = date('Y-m-d H:i:s');
		}
		$this->date_edit = date('Y-m-d H:i:s');

		if ($this->password && $this->repassword) {
			$this->salt = md5(microtime(true).rand().'my_strong_salt');
			$this->password = self::createHash($this->password, $this->salt);
		}
		return parent::beforeSave();
	}

	public function blockLastUser($attribute, $params = array())
	{
		if (self::model()->countByAttributes(array('block' => 0)) <= 1 && $this->block) {
			$this->addError($attribute, 'Невозможно заблокировать последнего пользователя');
		}
	}

	public function beforeDelete()
	{
		if (self::model()->countByAttributes(array('block' => 0)) < 2 and !$this->block) {
			return false;
		}
		return true;
	}
}