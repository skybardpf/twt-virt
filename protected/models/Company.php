<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property string $id
 * @property string $name
 * @property string $inn
 * @property string $kpp
 * @property integer $admin_user_id
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property User2company[] $user2company
 * @property User $admin_user
 */
class Company extends CActiveRecord
{
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
			array('name, inn, kpp', 'required'),
			array('admin_user_id', 'safe', 'on' => 'update, insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, inn, kpp', 'safe', 'on'=>'search'),
		);
	}

	protected function beforeSave()
	{
		if (!$this->admin_user_id) {
			$this->admin_user_id = null;
		}
		return parent::beforeSave();
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
			'admin_user' => array(self::BELONGS_TO, 'User', 'admin_user_id'),
		);
	}

	protected function afterSave()
	{
		if ($this->admin_user) {
			$has_link = false;
			foreach ($this->admin_user->companies as $c) {
				if (!$has_link && $c->id == $this->id) {
					$has_link = true;
				}
			}
			if (!$has_link) {
				$u2c = new User2company();
				$u2c->company_id = $this->id;
				$u2c->user_id = $this->admin_user_id;
				$u2c->save();
			}

		}
		parent::afterSave();
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'inn' => 'ИНН',
			'kpp' => 'КПП',
			'admin_user_id' => 'Администратор',
		);
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
}