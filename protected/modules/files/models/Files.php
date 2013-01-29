<?php

/**
 * This is the model class for table "f_files".
 *
 * The followings are the available columns in table 'f_files':
 * @property string $id
 * @property string $root
 * @property string $lft
 * @property string $rgt
 * @property string $lvl
 * @property string $company_id
 * @property string $user_id
 * @property string $name
 * @property string $cdate
 * @property string $mdate
 * @property string $file
 * @property string $size
 * @property integer $deleted
 * @property integer $is_dir
 *
 * @method Files roots() Выборка всех корней
 * @method Files descendants(int $depth=NULL) Выборка всех потомков узла
 * @method Files children() Выборка прямых потомков узла
 * @method Files ancestors(int $depth=NULL) Выборка всех предков узла
 * @method Files parent() Выборка предка узла
 * @method Files prev() Выборка предыдущего узла
 * @method Files next() Выборка следующего узла
 *
 * @method boolean saveNode(boolean $runValidation=true, boolean $attributes=true) Сохранение узла
 * @method boolean deleteNode() Удаление узла
 *
 * @method boolean insertAfter(CActiveRecord $target, boolean $runValidation=true, boolean $attributes=true) Добавление дочерних узловв
 * @method boolean insertBefore(CActiveRecord $target, boolean $runValidation=true, array $attributes=true) Добавление дочерних узлов
 * @method boolean appendTo(CActiveRecord $target, boolean $runValidation=true, array $attributes=true) Добавление дочерних узлов
 * @method boolean append(CActiveRecord $target, boolean $runValidation=true, array $attributes=true) Добавление дочерних узлов
 * @method boolean prependTo(CActiveRecord $target, boolean $runValidation=true, array $attributes=true) Добавление дочерних узлов
 * @method boolean prepend(CActiveRecord $target, boolean $runValidation=true, array $attributes=true) Добавление дочерних узлов
 * @method boolean moveBefore(CActiveRecord $target) Перемещение узла перед $target
 * @method boolean moveAfter(CActiveRecord $target) Перемещение узла после $target
 * @method boolean moveAsFirst(CActiveRecord $target) Перемещение узла первым в $traget
 * @method boolean moveAsRoot() Перемещение узла
 * @method boolean isDescendantOf(CActiveRecord $subj) Является ли потомком
 * @method boolean isLeaf() Является ли узел листом
 * @method boolean isRoot() Является ли корнем
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property User $user
 */
class Files extends CActiveRecord
{
	public $size = 0;
	public $is_dir = 0;
	public $deleted = 0;
	public $parent_elem = null;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Files the static model class
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
		return 'f_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id', 'required'),
			array('deleted, is_dir', 'numerical', 'integerOnly' => true),
			array('company_id, user_id', 'length', 'max'=>10),
			array('size', 'length', 'max'=>20),

			array('name', 'required', 'except' => 'new_file'),
			array('name', 'length', 'except' => 'new_file', 'max' => 120),
			array('name', 'is_subdir_unique', 'on' => 'new_file, new_dir, rename'),

			array('name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lft, rgt, lvl, company_id, user_id, name, cdate, file, size, deleted, is_dir', 'safe', 'on'=>'search'),
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
			'company_id' => 'Компания',
			'user_id' => 'Пользователь',
			'name' => 'Имя',
			'cdate' => 'Дата создания',
			'file' => 'Файл',
			'size' => 'Размер',
			'deleted' => 'Удален',
			'is_dir' => 'Директория',
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
		$criteria->compare('lft',$this->lft,true);
		$criteria->compare('rgt',$this->rgt,true);
		$criteria->compare('lvl',$this->lvl,true);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('is_dir',$this->is_dir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors() {
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'cdate',
				'updateAttribute' => 'mdate',
				'setUpdateOnCreate' => true
			),
			'FileBehavior' => array(
				'class' => 'ext.FileBehavior',
				'fileTypes' => null
			),
			'NestedSetBehavior'=>array(
				'class'=>'ext.NestedSetBehavior',
				'leftAttribute'  => 'lft',
				'rightAttribute' => 'rgt',
				'levelAttribute' => 'lvl',
				'hasManyRoots'   => true,
			),
		);
	}

	public function getSize_human() {
		if (!$this->size) return '-';
		$labels = array(0 => 'B', 1 => 'KB', 2 => 'MB', 3 => 'GB', 4 => 'TB');
		$i = 0;
		$tmp = $this->size;
		while ($tmp > 1024) {
			$tmp = $tmp / 1024;
			$i++;
		}
		if (!isset($labels[$i])) return 'Очень много.';
		else return number_format($tmp, 2).' '.$labels[$i];
	}

	public function is_subdir_unique($attribute,$params) {
		$parent_dir = !$this->isNewRecord ? $this->parent()->find() : $this->parent_elem;

		$criteria = new CDbCriteria();
		if (!$this->isNewRecord) {
			$criteria->addCondition('t.id != :elem_id');
			$criteria->params[':elem_id'] = $this->id;
		}
		$criteria->addCondition('name = :new_name');
		$criteria->params[':new_name'] = $this->name;
		$elements = $parent_dir->children()->find($criteria);
		$labels = $this->attributeLabels();
		if ($elements) $this->addError($attribute, $labels[$attribute].' должно быть уникальным в своей папке.');
	}
}