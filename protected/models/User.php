<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $role
 * @property string $email
 * @property string $salt
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property integer $active
 * @property integer $create_user_id
 *
 * @property string $fullName
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 * @property User2company[] $user2company
 * @property UserEmail[] $userEmails
 */
class User extends CActiveRecord
{
    const ROLE_ADMIN = 'administrator';
    const ROLE_COMPANY_ADMIN = 'company_admin';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';

	public $active = 1;
	public $repassword;
	public $old_password;

	public $rememberMe = false;
	private $_identity = NULL;

	public $isAdmin = false;

	public $companies_ids = array();
	public $companies_ids_string = '';

	public $admin_action = false; // Это для костыля. TODO Надо конкретно рефакторить companies_ids

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
			array('email, name, surname', 'required', 'on' => 'insert,update,owner_update,owner_create'),
			array('email, name, surname', 'required', 'on' => 'profile'),

			array('companies_ids_string', 'required', 'on' => 'insert,update'),

			array('companies_ids', 'required', 'on' => 'owner_update,owner_create'),
			array('companies_ids', 'safe', 'on' => 'owner_update,only_company,owner_create'),

			array('email', 'unique', 'on' => 'insert,update,owner_update,owner_create,profile'),
			array('email', 'email', 'on' => 'insert,update,owner_update,owner_create,profile'),
			array('active', 'numerical', 'integerOnly'=>true, 'on' => 'insert,update,owner_update,owner_create'),
			array('old_password', 'required', 'on' => 'change_pass'),
			array('password, repassword', 'required', 'on' => 'insert, change_pass,owner_create'),
			array('repassword', 'compare', 'compareAttribute' => 'password', 'on' => 'insert, change_pass, owner_create'),
			array('phone', 'safe', 'on' => 'insert,update,owner_update,owner_create,profile'),

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
			'admin2company' => array(self::HAS_MANY, 'Admin2company', 'user_id'),
			'adminCompanies' => array(self::HAS_MANY, 'Company', array('company_id' => 'id'), 'through' => 'admin2company'),
            'userEmails' => array(self::HAS_MANY, 'UserEmail', array('user_id' => 'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'                    => 'ID',
			'email'                 => 'E-mail',
			'old_password'          => 'Старый пароль',
			'password'              => 'Пароль',
			'repassword'            => 'Повтор пороля',
			'name'                  => 'Имя',
			'surname'               => 'Фамилия',
			'fullName'              => 'Полное имя',
			'phone'                 => 'Телефон',
			'salt'                  => 'Соль',
			'active'                => 'Активный',
			'companies_ids'         => 'Компании',
			'companies_ids_string'  => 'Компании'
		);
	}

	protected function afterFind()
	{
		$is_admin = false;
		foreach ($this->companies as $c) {
			$this->companies_ids[] = $c->id;
			if (!$is_admin) {
				$is_admin = $c->isAdmin($this->id);
			}
		}
		$this->isAdmin = $is_admin;
		$this->companies_ids_string = implode(', ',$this->companies_ids);

		parent::afterFind();
	}

	public function beforeSave()
	{
		if (in_array($this->scenario, array('insert', 'update')) && $this->admin_action) {
			$temp = explode(',', $this->companies_ids_string);
			$temp = array_unique($temp);
			$this->companies_ids = $temp;
		}

		if ($this->password && $this->repassword) {
			$this->salt = md5(microtime(true).rand().'my_strong_salt456564897521646');
			$this->password = self::createHash($this->password, $this->salt);
		}

		return parent::beforeSave();
	}

	protected function afterSave() {
		if (!in_array($this->scenario, array('profile', 'change_pass'))) {
			$companies_ids = array();
			if (in_array($this->scenario, array('insert', 'update'))) {
				User2company::model()->deleteAllByAttributes(array('user_id' => $this->id));
			} elseif (in_array($this->scenario, array('owner_update', 'only_company', 'owner_create'))) {
				foreach ($this->user2company as $u2c) {
					$companies_ids[] = $u2c->company_id;
					//TODO костыль :(
					if ($u2c->company->isAdmin(Yii::app()->user->id)) {
						$u2c->delete();
					}
				}
			}

			foreach ($this->companies_ids as $c_id) {
				$uc = new User2company();
				$uc->user_id = $this->id;
				$uc->company_id = $c_id;
				if ($this->isNewRecord || in_array($this->scenario, array('insert', 'update'))) {
					$uc->save();
				} elseif ($this->create_user_id == Yii::app()->user->id or in_array($c_id, $companies_ids)) { //TODO еще один
					$uc->save();
				}
			}
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
	 *
	 * @param integer $user_id
	 * @return Company[]
	 */
	public function getCompaniesList($user_id = NULL)
	{
		$model = Company::model();
		$criteria = new CDbCriteria();
		if ($user_id) {
			$criteria->addCondition('admin2company.user_id = :admin_user_id');
			$criteria->params[':admin_user_id'] = $user_id;
		}
		return $model->with('admin2company')->findAll($criteria);
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===NULL) {
			$this->_identity=new UserIdentity($this->email, $this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		} else {
			$this->addError('', $this->_identity->errorMessage);
			return false;
		}
	}

	/**
	 * Перед удалением пользователя нужно удалить его связи с компаниями и файлами,
	 * а так же удалить себя у всех пользователей, которых мы создали (где create_user_id совпадает с идентификатором пользователя)
	 * @throws Exception
	 * @return bool
	 */
	protected function beforeDelete()
	{
		$no_outer_transaction = true;
		$transaction = Yii::app()->db->getCurrentTransaction();
		if ($transaction === NULL) {
			$transaction = Yii::app()->db->beginTransaction();
		} else {
			$no_outer_transaction = false;
		}
		try {
			// Связи с компаниями
			User2company::model()->deleteAll('user_id = :user', array(':user' => $this->id));
			Admin2company::model()->deleteAll('user_id = :user', array(':user' => $this->id));

			// Файлы пользователя
			Yii::app()->getModule('files');
			Files::model()->deleteAll('user_id = :user', array(':user' => $this->id));

			// Техподдержка
			Yii::app()->getModule('support');
			SRequest::model()->deleteAll('uid = :user', array(':user' => $this->id));

			// удаление себя у всех пользователей, которых мы создали (где create_user_id совпадает с идентификатором данного пользователя)
			$created_users = User::model()->findAllByAttributes(array('create_user_id' => $this->id));
			if ($created_users) {
				foreach ($created_users as $user) {
					$user->create_user_id = null;
					$user->save();
				}
			}

			if ($no_outer_transaction) { $transaction->commit(); }
		} catch (Exception $e) {
			if ($no_outer_transaction) { $transaction->rollback(); }
			throw $e;
		}
		return parent::beforeDelete();
	}

	// Чтобы в массив companies_ids записать значиния из мултиселект2 инпута companies_ids_string
	public function parse_companies_string() {

	}
}