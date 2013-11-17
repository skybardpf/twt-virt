<?php
namespace application\modules\domain\models;

use \application\models\Mail as Devecot;

/**
 * This is the model class for table "site".
 *
 * The followings are the available columns in table 'site':
 * @property integer $id
 * @property string $company_id
 * @property string $template_id
 * @property string $domain
 * @property string $name
 *
 * The followings are the available model relations:
 * @property \application\modules\domain\models\Template $template
 * @property \Company $company
 */
class Domain extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'domain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_id, domain, name', 'required'),
            array('domain, name', 'length', 'max'=>50),

            array('template_id', 'in', 'range' => array_keys(\CHtml::listData(
                Template::model()->findAll(), 'id', 'external_name'
            ))),

            array('domain', 'uniqueDomain'),
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
			'template' => array(self::BELONGS_TO, 'application\modules\domain\models\Template', 'template_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'template_id' => 'Шаблон',
			'domain' => 'Поддомен',
			'name' => 'Внутренее название сайта',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Domain the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Создаем почтовые аккаунт для админа, создавшего поддомен.
     * Создаем соответсвующую запись на Devecot сервере.
     */
    protected function afterSave()
    {
        \Yii::log('afterSave', \CLogger::LEVEL_ERROR);
        parent::afterSave();

        \Yii::log('isNewRecord: '.($this->isNewRecord ? 'YES' : 'No'), \CLogger::LEVEL_ERROR);

        if ($this->isNewRecord){
            /**
             * Добавляем почтовый домен на Devecot серевер.
             */
            $domain = new Devecot\Domain();
            $domain->domain = $this->domain . '.' . \Yii::app()->params->httpHostName;
            if (!$domain->insert()){
                \Yii::log('Не создался домен на Devecot сервере для домена: '.$domain->domain, \CLogger::LEVEL_ERROR);
            }

            /**
             * Создаем почтовый аккаунт и привязваем его к админу.
             */
            $model = new \UserEmail();
            $model->user_id = \Yii::app()->user->id;
            $model->site_id = $this->primaryKey;
            $model->login_email = \UserEmail::DEFAULT_LOGIN_EMAIL_ADMIN;
            $model->password = \UserEmail::generatePassword();
            if($model->save()){
                $user = new Devecot\User();
                $cmd = $user->getDbConnection()->createCommand('
                    INSERT INTO '.$user->tableName().' (email, password) VALUES (:email, ENCRYPT(:password))
                ');
                $cmd->execute(array(
                    ':email' => $model->login_email.'@'.$domain->domain,
                    ':password' => $model->password,
                ));

                \Yii::app()->user->setFlash('email_account', $model->login_email.'@'.$domain->domain);
                \Yii::app()->user->setFlash('email_account_pass', $model->password);
            } else {
                echo 'Not save email account';die;
            }
        }
    }

    /**
     * Удаляемм почтовые аккаунты и их связи на Devecot сервере.
     */
    protected function afterDelete()
    {
        parent::afterDelete();


    }

    public function uniqueDomain($attribute)
    {
        $domain  = $this->find('domain=:domain', array(
            ':domain' => $this->$attribute
        ));
        if ($domain){
            $this->addError($attribute, \Yii::t('app', 'Такой домен уже существует'));
        }
    }
}
