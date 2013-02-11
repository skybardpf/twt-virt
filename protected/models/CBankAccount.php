<?php
/**
 * User: Forgon
 * Date: 08.02.13
 */

/**
 * This is the model class for table "cbank_account".
 *
 * The followings are the available columns in table 'cbank_account':
 * @property integer $id
 * @property integer $company_id     // Компания
 * @property integer $resident     // Компания
 * @property string  $account_number // Номер счета
 * @property string  $bank           // Название банка
 * @property string  $swift          // SWIFT код
 * @property string  $iban           // IBAN
 * @property string  $bik            // БИК
 * @property string  $correspondent  // КоррСчет
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class CBankAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CBankAccount the static model class
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
		return 'cbank_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, account_number, bank', 'required'),
			array('company_id', 'length', 'max'=>10),
			array('swift, iban, bik, correspondent', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_id, account_number, bank, swift, iban, bik, correspondent', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'account_number' => 'Номер счета',
			'bank' => 'Банк',
			'swift' => 'Swift',
			'iban' => 'Iban',
			'bik' => 'БИК',
			'correspondent' => 'КоррСчет',
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
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('swift',$this->swift,true);
		$criteria->compare('iban',$this->iban,true);
		$criteria->compare('bik',$this->bik,true);
		$criteria->compare('correspondent',$this->correspondent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}