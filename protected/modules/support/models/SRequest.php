<?php

/**
 * This is the model class for table "s_request".
 *
 * The followings are the available columns in table 's_request':
 * @property string $id
 * @property string $uid
 * @property integer $opened
 * @property integer $readed
 * @property string $cdate
 * @property string $title
 * @property string $l_message_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property SMessage[] $messages
 * @property SMessage $l_message
 */
class SRequest extends CActiveRecord
{
	public $opened = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SRequest the static model class
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
		return 's_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, title', 'required'),
			array('opened', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, opened, cdate, title', 'safe', 'on'=>'search'),
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
			'messages'  => array(self::HAS_MANY, 'SMessage', 'request_id', 'order' => 'messages.cdate DESC'),
			'user'      => array(self::BELONGS_TO, 'User', 'uid'),
			'l_message' => array(self::BELONGS_TO, 'SMessage', 'l_message_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'uid' => 'Пользователь',
			'opened' => 'Открыт',
			'cdate' => 'Дата создания',
			'title' => 'Тема'
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
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('opened',$this->opened);
		$criteria->compare('cdate',$this->cdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Действия перед удалением группы записей.
	 * @param string $condition
	 * @param array $params
	 *
	 * @throws Exception
	 * @return int
	 */
	public function deleteAll($condition = '', $params = array())
	{
		$no_outer_transaction = true;
		$transaction = Yii::app()->db->getCurrentTransaction();
		if ($transaction === NULL) {
			$transaction = Yii::app()->db->beginTransaction();
		} else {
			$no_outer_transaction = false;
		}
		try {
			$builder  = $this->getCommandBuilder();
			$criteria = $builder->createCriteria($condition,$params);
			$requests = $this->findAll($criteria);
			$ids      = array();
			if ($requests) { foreach ($requests as $request) { $ids[] = $request->id; } }
			if ($ids) {
				$criteria = new CDbCriteria();
				$criteria->addInCondition('request_id', $ids);
				SMessage::model()->deleteAll($criteria);
			}
			if ($no_outer_transaction) { $transaction->commit(); }
		} catch (Exception $e) {
			if ($no_outer_transaction) { $transaction->rollback(); }
			throw $e;
		}
		return parent::deleteAll($condition, $params);
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
}