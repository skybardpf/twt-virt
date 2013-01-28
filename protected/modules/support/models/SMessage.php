<?php

/**
 * This is the model class for table "s_message".
 *
 * The followings are the available columns in table 's_message':
 * @property string $id
 * @property string $request_id
 * @property integer $to_admin
 * @property string $cdate
 * @property string $message
 *
 * The followings are the available model relations:
 * @property SRequest $request
 */
class SMessage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SMessage the static model class
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
		return 's_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, message', 'required'),
			array('to_admin', 'numerical', 'integerOnly'=>true),
			array('request_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, request_id, to_admin, cdate, message', 'safe', 'on'=>'search'),
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
			'request' => array(self::BELONGS_TO, 'SRequest', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'         => 'ID',
			'request_id' => 'Запрос',
			'to_admin'   => 'Администратору',
			'cdate'      => 'Дата создания',
			'message'    => 'Сообщение'
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
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('to_admin',$this->to_admin);
		$criteria->compare('cdate',$this->cdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'cdate',
				'updateAttribute' => NULL,
				'setUpdateOnCreate' => true
			)
		);
	}

	protected function afterSave()
	{
		$this->request->l_message_id = $this->id;
		$this->request->save();
		parent::afterSave();
	}


}