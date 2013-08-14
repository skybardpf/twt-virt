<?php

/**
 * This is the model class for table "f_links".
 *
 * The followings are the available columns in table 'f_links':
 * @property string $id
 * @property string $key Ключ для доступа к файлу/папке извне
 * @property string $cdate Дата создания
 * @property string $edate Дата окончания действия
 * @property string $file_id Файл
 * @property string $user_id Пользователь, создавший ссылку
 *
 * The followings are the available model relations:
 * @property Files $file Файл
 * @property User $user Пользователь, создавший ссылку
 */
class FLinks extends CActiveRecord
{
	public $duration = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FLinks the static model class
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
		return 'f_links';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key, edate, file_id, user_id', 'required', 'except' => 'create'),
			array('key', 'length', 'max'=>32),
			array('file_id, user_id', 'length', 'max'=>10),

			array('duration', 'required', 'on' => 'create'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, key, cdate, edate, file_id, user_id', 'safe', 'on'=>'search'),
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
			'file' => array(self::BELONGS_TO, 'Files', 'file_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'key' => 'Ключ',
			'cdate' => 'Создана',
			'edate' => 'Заканчивается',
			'file_id' => 'Файл',
			'user_id' => 'Пользователь',
			'duration' => 'Время действия'
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
		$criteria->compare('key',$this->key,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('edate',$this->edate,true);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Возвращает допустимые значения для длительности действия временной ссылки
	 */
	public function getDurationValues() {
		return array(
			3600  => '1 час',
			10800 => '3 часа',
			21600 => '6 часов',
			43200 => '12 часов',
			86400 => '24 часа');
	}
	/** Генерирует ключ для файла */
	public function generateKey() {
		$rand = sprintf('%08x%08x%08x%08x',mt_rand(),mt_rand(),mt_rand(),mt_rand());
		return md5($rand.md5($rand.mt_rand()).md5(mt_rand().$rand));
	}


	public function behaviors() {
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'cdate',
			)
		);
	}
}