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
 * @property string $logo
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
        return array(
            array('template_id, domain, name', 'required'),
            array('domain, name', 'length', 'max' => 50),

            array('template_id', 'in', 'range' => array_keys(\CHtml::listData(
                Template::model()->findAll(), 'id', 'external_name'
            ))),

            array('domain', 'uniqueDomain'),

            array('logo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'template' => array(self::BELONGS_TO, 'application\modules\domain\models\Template', 'template_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'pages' => array(self::HAS_MANY, 'application\modules\domain\models\DomainPage', 'domain_id'),
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
            'logo' => 'Логотип',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Domain the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Перед сохранением модели загружаем файл.
     * @return bool
     */
    protected function beforeSave()
    {
        if (!parent::beforeSave())
            return false;
        if ($logo = \CUploadedFile::getInstance($this, 'logo')) {
            $this->deleteLogo();

            $dir = \Yii::getPathOfAlias('webroot.upload.site.logos');
            if (!file_exists($dir)){
                mkdir($dir, 0755, true);
            }

            $filename = md5(md5($logo->name).time().'site_logos');
            $logo->saveAs(
                \Yii::getPathOfAlias('webroot.upload.site.logos') . DIRECTORY_SEPARATOR . $filename
            );
            $this->logo = $filename;
        }
        return true;
    }

    /**
     * Удаляем ранее загруженный логотип сайта. Если есть.
     */
    public function deleteLogo()
    {
        $logoPath = \Yii::getPathOfAlias('webroot.upload.site.logos') . DIRECTORY_SEPARATOR . $this->logo;
        if (is_file($logoPath)) {
            unlink($logoPath);
        }
    }

    /**
     * Удалили модель, удаляем и файл
     * @return bool
     */
    protected function beforeDelete()
    {
        if (!parent::beforeDelete())
            return false;
        $this->deleteLogo();
        return true;
    }

    /**
     * Создаем почтовые аккаунт для админа, создавшего поддомен.
     * Создаем соответсвующую запись на Devecot сервере.
     */
    protected function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            /**
             * Добавляем почтовый домен на Devecot серевер.
             */
            $domain = new Devecot\Domain();
            $domain->domain = $this->domain . '.' . \Yii::app()->params->httpHostName;
            if (!$domain->insert()) {
                \Yii::log('Не создан домен на Devecot сервере для домена: ' . $domain->domain, \CLogger::LEVEL_ERROR);
            }

            /**
             * Создаем почтовый аккаунт и привязваем его к админу.
             */
            $model = new \UserEmail();
            $model->user_id = \Yii::app()->user->id;
            $model->site_id = $this->primaryKey;
            $model->login_email = \UserEmail::DEFAULT_LOGIN_EMAIL_ADMIN;
            $model->password = \UserEmail::generatePassword();
            if ($model->save()) {
                $user = new Devecot\User();
                $cmd = $user->getDbConnection()->createCommand('
                    INSERT INTO ' . $user->tableName() . ' (email, password) VALUES (:email, ENCRYPT(:password))
                ');
                $cmd->execute(array(
                    ':email' => $model->login_email . '@' . $domain->domain,
                    ':password' => $model->password,
                ));

                \Yii::app()->user->setFlash('email_account', $model->login_email . '@' . $domain->domain);
                \Yii::app()->user->setFlash('email_account_pass', $model->password);
            }
        }
    }

    /**
     * Удаляемм почтовые аккаунты и их связи на Devecot сервере.
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        /**
         * DELETE HERE
         */

        /**
         * TODO удаляем страницы сайта
         */
    }

    public function uniqueDomain($attribute)
    {
        $domain = $this->find('domain=:domain', array(
            ':domain' => $this->$attribute
        ));
        if ($domain && $domain->primaryKey != $this->primaryKey) {
            $this->addError($attribute, \Yii::t('app', 'Такой домен уже существует'));
        }
    }
}
