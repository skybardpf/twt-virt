<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $email
 * @property string $salt
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property integer $active
 *
 * @property string $fullName
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 * @property User2company[] $user2company
 */
class User extends CActiveRecord
{
	public $active = 1;
	public $repassword;

	public $rememberMe = false;
	private $_identity = null;

	public $companies_ids = array();

	public function getFullName()
	{
		return $this->name . ' ' . $this->surname;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className)->with('companies');
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password', 'required', 'on' => 'login'),
			array('email, name, surname, companies_ids', 'required', 'on' => 'insert,update'),
			array('email', 'unique', 'on' => 'insert,update'),
			array('email', 'email'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('password', 'length', 'max'=>32),
			array('password, repassword', 'required', 'on' => 'insert, ch_pass'),
			array('repassword', 'compare', 'compareAttribute' => 'password', 'on' => 'insert, ch_pass'),
			array('phone', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, name, surname, phone, active', 'safe', 'on'=>'search'),
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
			'user2company' => array(self::HAS_MANY, 'User2company', 'user_id'),
			'companies' => array(self::HAS_MANY, 'Company', array('company_id' => 'id'), 'through' => 'user2company'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'E-mail',
			'password' => 'Пароль',
			'repassword' => 'Повтор пороля',
			'name' => 'Имя',
			'surname' => 'Фамилия',
			'fullName' => 'Полное имя',
			'phone' => 'Телефон',
			'salt' => 'Соль',
			'active' => 'Активный',
			'companies_ids' => 'Компании'
		);
	}

	protected function afterFind()
	{
		$this->companies_ids = array_keys(CHtml::listData($this->companies, 'id', 'name'));
		parent::afterFind();
	}


	public function beforeSave()
	{
		if ($this->password && $this->repassword) {
			$this->salt = md5(microtime(true).rand().'my_strong_salt456564897521646');
			$this->password = self::createHash($this->password, $this->salt);
		}
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		User2company::model()->deleteAllByAttributes(array('user_id' => $this->id));

		foreach ($this->companies_ids as $c_id) {
			$uc = new User2company();
			$uc->user_id = $this->id;
			$uc->company_id = $c_id;
			$uc->save();
		}
		parent::afterSave();
	}


	public static function createHash($password, $salt)
	{
		return md5(md5($salt.$password).md5($salt.$password.$salt).md5($password.$salt));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return Company[]
	 */
	public function getCompaniesList()
	{
		return Company::model()->findAll();
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->email, $this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}