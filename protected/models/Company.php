<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property string $id
 * @property string $name

 * @property string $legal_address   // Юр адрес
 * @property string $actual_address  // Факт адрес
 * @property string $phone
 * @property string $email
 * @property string $resident
 * @property string $inn
 * @property string $kpp
 * @property string $okopf
 * @property string $ogrn
 * @property string $vat
 * @property string $registration_number
 * @property string $registration_date
 * @property string $registration_country
 * @property integer $f_quote                // Квота файлов в МБ
 *
 * @property string $position_name1
 * @property string $position_owner1
 * @property string $position_name2
 * @property string $position_owner2
 * @property string $position_name3
 * @property string $position_owner3
 *
 * @property integer $deleted
 * @property string $deleted_date
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property User2company[] $user2company
 * @property User[] $admins
 * @property Admin2company[] $admin2company

 * @property CBankAccount[] $res_banks
 * @property CBankAccount[] $nonres_banks
 */
class Company extends CActiveRecord
{
	public $deleted = 0;
	public $resident = 1;
	public $f_quote = 50;
	public $admin_ids = array(); // массив идентификаторов администраторов компании
	public $admin_ids_string = '';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, f_quote', 'required'),
			array('deleted, admin_ids_string, admin_ids', 'safe', 'on' => 'update, insert'),
			array('admin_ids_string, admin_ids, legal_address, actual_address, phone, email, resident, inn, kpp, okopf, ogrn, account_number, bank, bik, correspondent_account, vat, registration_number, registration_date, registration_country, swift, iban, position_name1, position_owner1, position_name2, position_owner2, position_name3, position_owner3', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, inn, kpp', 'safe', 'on'=>'search'),
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
			'user2company' => array(self::HAS_MANY, 'User2company', 'company_id'),
			'users' => array(self::HAS_MANY, 'User', array('user_id' => 'id'), 'through' => 'user2company'),
			'used_quote' => array(self::STAT, 'Files', 'company_id', 'select' => 'SUM(size)'),
			'admin2company' => array(self::HAS_MANY, 'Admin2company', 'company_id'),
			'admins' => array(self::HAS_MANY, 'User', array('user_id' => 'id'), 'through' => 'admin2company'),
		);
	}

	// вместо afterFind вызывается данная функция, так как в afterFind возникает бесконечный цикл
	/**
	 * Возвращает массив идентификаторов админов
	 * @return array
	 */
	public function getAdminIds() {
		$admins = Admin2company::model()->findAll(array(
			'condition' => 'company_id = :company_id',
			'params' => array(':company_id' => $this->id)
		));
		if ($admins) {
			foreach ($admins as $a) {
				$this->admin_ids[] = $a->user_id;
			}
			$this->admin_ids_string = implode(', ',$this->admin_ids);
		}
		return $this->admin_ids;
	}

	/**
	 * Проверяет, является ли пользователь админом (для блокирования удаления)
	 * @param $user_id
	 */
	public function isAdmin($user_id) {
		return in_array($user_id, $this->getAdminIds());
	}

	public function beforeSave()
	{
		$temp = explode(',', $this->admin_ids_string);
		$temp = array_unique($temp);
		$this->admin_ids = $temp;

		if ($this->deleted == 0) {
			$this->deleted_date = NULL;
		}
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// удалим всех администраторов компанииб не входящих в новый список
		foreach($this->admin2company as $ac) {
			if (!in_array($ac->user_id, $this->admin_ids)) {
				$ac->delete();
			}
		}
		// сохранение администраторов в таблицу связей администратор-компания
		foreach ($this->admin_ids as $admin_id) {
			if ($admin_id) {
				$criteria = new CDbCriteria;
				$criteria->addCondition('user_id = :user_id');
				$criteria->addCondition('company_id = :company_id');
				$criteria->params = array(':user_id' => $admin_id, ':company_id' => $this->id);
				$link = Admin2company::model()->find($criteria);
				if(!$link) {
					$ac = new Admin2company();
					$ac->user_id = $admin_id;
					$ac->company_id = $this->id;
					$ac->save();
				}
			}
		}
		// сохранение администратора в таблицу связей с пользователями
		foreach ($this->admins as $admin_user) {
			if ($admin_user) {
				$has_link = false;
				foreach ($admin_user->companies as $c) {
					if (!$has_link && $c->id == $this->id) {
						$has_link = true;
					}
				}
				if (!$has_link) {
					$u2c = new User2company();
					$u2c->company_id = $this->id;
					$u2c->user_id = $admin_user->id;
					$u2c->save();
				}

			}
		}
		parent::afterSave();
	}

	protected function beforeDelete()
	{
		foreach ($this->admin2company as $a2c) {
			$a2c->delete();
		}
		foreach ($this->user2company as $u2c) {
			$u2c->delete();
		}
		return parent::beforeDelete();
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'legal_address' => 'Юридический адрес',
			'actual_address' => 'Фактический адрес',
			'phone' => 'Телефон',
			'email' => 'E-mail',
			'resident' => 'Резидент РФ',
			'inn' => 'ИНН',
			'kpp' => 'КПП',
			'okopf' => 'ОКОПФ',
			'ogrn' => 'ОГРН',
			'vat' => 'VAT номер',
			'registration_number' => 'Регистрационный номер',
			'registration_date' => 'Дата регистрации',
			'registration_country' => 'Страна регистрации',
			'position_name1' => 'Должность',
			'position_owner1' => 'ФИО',
			'position_name2' => 'Должность',
			'position_owner2' => 'ФИО',
			'position_name3' => 'Должность',
			'position_owner3' => 'ФИО',
			'admin_ids' => 'Администраторы',
			'admin_ids_string' => 'Администраторы',
			'deleted' => 'Помечено на удаление',
			'deleted_date' => 'Дата отметки',
			'f_quote' => 'Квота файлового хранилица в МБ',
			'f_qoute_view' => 'Файлы'
		);
	}

	public function markDeleted()
	{
		$this->deleted = 1;
		$this->deleted_date = date('Y-m-d H:i:s');
		return $this->save(false);
	}

	public function unMarkDeleted()
	{
		$this->deleted = 0;
		$this->deleted_date = NULL;
		return $this->save(false);
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('inn',$this->inn,true);
		$criteria->compare('kpp',$this->kpp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Представляет нормальный вывод квоты в виде использовано/всего
	 * @return string
	 */
	public function getF_qoute_view(){
		return $this->HumanizeQuoteSize($this->used_quote).' / '.$this->HumanizeQuoteSize($this->f_quote, 2);
	}

	/**
	 * Приводит размер (файла или квоты к нормальному виду)
	 * @param $bytes
	 * @param int $lvl
	 * @return string
	 */
	protected function HumanizeQuoteSize($bytes, $lvl = 0) {
		if (!$bytes) return '—';
		$labels = array(0 => 'B', 1 => 'KB', 2 => 'MB', 3 => 'GB', 4 => 'TB');
		while ($bytes > 1024) {
			$bytes = $bytes / 1024;
			$lvl++;
		}
		if (!isset($labels[$lvl])) return 'Очень много.';
		else return number_format($bytes, 2).' '.$labels[$lvl];
	}
}