<?php
namespace application\modules\domain\models;

/**
 * This is the model class for table "domain_page".
 *
 * The followings are the available columns in table 'domain_page':
 * @property string $id
 * @property string $domain_id
 * @property string $kind
 * @property integer $is_show
 * @property string $page_title
 * @property string $window_title
 * @property string $content
 * @property string $banner
 * @property string $logo
 * @property string $email
 * @property string $adress
 * @property string $map
 *
 * The followings are the available model relations:
 * @property Domain $domain
 */
class DomainPage extends \CActiveRecord
{
    const KIND_MAIN = 'main';
    const KIND_ABOUT_COMPANY = 'about';
    const KIND_PARTNER = 'partner';
    const KIND_SERVICES = 'services';
    const KIND_CONTACTS = 'contacts';

    const MAP_GOOGLE = 'google';
    const MAP_YANDEX = 'yandex';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'domain_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('page_title, window_title', 'required'),
            array('page_title, window_title', 'length', 'max'=>100),

            array('content', 'required'),

            array('map', 'required', 'on' => 'contacts'),
            array('map', 'in', 'range' => array_keys(self::getMaps()), 'on' => 'contacts'),

            array('adress', 'required', 'on' => 'contacts'),
            array('adress', 'length', 'max' => 200, 'on' => 'contacts'),

            array('email', 'email', 'on' => 'contacts'),
            array('email', 'length', 'max' => 100, 'on' => 'contacts'),

            array('logo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),

            array('banner', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true, 'except' => 'contacts'),
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
			'domain' => array(self::BELONGS_TO, 'Domain', 'domain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'domain_id' => 'Поддомен',
			'kind' => 'Тип страницы',
			'is_show' => 'Показывать страницу',
			'page_title' => 'Заголовок страницы',
			'window_title' => 'Заголовок окна',
			'content' => 'Содержимое',
			'banner' => 'Баннер',
			'logo' => 'Логотип',
			'email' => 'Email',
			'adress' => 'Адрес',
			'map' => 'Карта',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DomainPage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @static
     * @param string $kind
     * @return bool
     */
    public static function existsKind($kind)
    {
        $kinds = self::getKinds();
        return isset($kinds[$kind]);
    }

    /**
     * @static
     * @param string $kind
     * @return string
     */
    public static function kindToString($kind)
    {
        $kinds = self::getKinds();
        return isset($kinds[$kind]) ? $kinds[$kind] : '';
    }

    /**
     * @static
     * @return array
     */
    public static function getKinds()
    {
        return array(
            self::KIND_MAIN => \Yii::t('app', 'Главная'),
            self::KIND_ABOUT_COMPANY => \Yii::t('app', 'О компании'),
            self::KIND_PARTNER => \Yii::t('app', 'Партнеры'),
            self::KIND_SERVICES => \Yii::t('app', 'Услуги'),
            self::KIND_CONTACTS => \Yii::t('app', 'Контакты'),
        );
    }

    /**
     * @static
     * @return array
     */
    public static function getMaps()
    {
        return array(
            self::MAP_GOOGLE => \Yii::t('app', 'Google'),
            self::MAP_YANDEX => \Yii::t('app', 'Яндекс-карты'),
        );
    }

    /**
     * Перед сохранением модели загружаем файлы логотипов и баннеров.
     * @return bool
     */
    protected function beforeSave()
    {
        if (!parent::beforeSave()){
            return false;
        }

        /**
         * Логотипы
         */
        if ($logo = \CUploadedFile::getInstance($this, 'logo')) {
            $this->deleteLogo();

            $dir = \Yii::getPathOfAlias('webroot.upload.site_page.logos');
            if (!file_exists($dir)){
                mkdir($dir, 0755, true);
            }

            $filename = md5(md5($logo->name).time().'site_page_logos');
            $logo->saveAs($dir . DIRECTORY_SEPARATOR . $filename);
            $this->logo = $filename;
        }

        /**
         * Баннеры
         */
        if (($this->kind !== self::KIND_CONTACTS) && ($banner = \CUploadedFile::getInstance($this, 'banner'))) {
            $this->deleteBanner();

            $dir = \Yii::getPathOfAlias('webroot.upload.site_page.banners');
            if (!file_exists($dir)){
                mkdir($dir, 0755, true);
            }

            $filename = md5(md5($banner->name).time().'site_page_banners');
            $banner->saveAs($dir . DIRECTORY_SEPARATOR . $filename);
            $this->banner = $filename;
        }

        return true;
    }

    /**
     * Удаляем ранее загруженный логотип страницы сайта. Если есть.
     */
    public function deleteLogo()
    {
        $logoPath = \Yii::getPathOfAlias('webroot.upload.site_page.logos') . DIRECTORY_SEPARATOR . $this->logo;
        if (is_file($logoPath)) {
            unlink($logoPath);
        }
    }

    /**
     * Удаляем ранее загруженный баннер страницы сайта. Если есть.
     */
    public function deleteBanner()
    {
        $path = \Yii::getPathOfAlias('webroot.upload.site_page.banners') . DIRECTORY_SEPARATOR . $this->banner;
        if (is_file($path)) {
            unlink($path);
        }
    }

    /**
     * Удалили модель, удаляем и файлы, логотипы баннеры
     * @return bool
     */
    protected function beforeDelete()
    {
        if (!parent::beforeDelete()){
            return false;
        }
        $this->deleteLogo();
        $this->deleteBanner();
        return true;
    }
}
