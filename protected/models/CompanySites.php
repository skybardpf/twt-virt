<?php

/**
 * This is the model class for table "CompanySites".
 *
 * @property string $site_id
 * @property string $company_id
 */
class CompanySites extends CActiveRecord
{
	public $admin = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanySites the static model class
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
		return 'company2sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
//	public function rules()
//	{
//		// NOTE: you should only define rules for those attributes that
//		// will receive user inputs.
//		return array(
//			array('user_id, company_id', 'required'),
//			array('user_id, company_id', 'length', 'max'=>10),
//			// The following rule is used by search().
//			// Please remove those attributes that should not be searched.
//			array('user_id, company_id', 'safe', 'on'=>'search'),
//		);
//	}

	/**
	 * @return array relational rules.
	 */
//	public function relations()
//	{
//		// NOTE: you may need to adjust the relation name and the related
//		// class name for the relations automatically generated below.
//		return array(
//			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
//			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
//		);
//	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
//	public function attributeLabels()
//	{
//		return array(
//			'user_id' => 'User',
//			'company_id' => 'Company',
//		);
//	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
//	public function search()
//	{
//		// Warning: Please modify the following code to remove attributes that
//		// should not be searched.
//
//		$criteria=new CDbCriteria;
//
//		$criteria->compare('user_id',$this->user_id,true);
//		$criteria->compare('company_id',$this->company_id,true);
//
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
//	}
}