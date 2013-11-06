<?php
/**
 * Class Sites
 *
 * Relations:
 * @property CompanySites[] $company2sites
 * @property Company $company
 */
class Sites extends CActiveRecord
{
    private $pages = array('about' => "О компании", 'services' => "Услуги", 'partners' => "Партнёры", 'contacts' => "Контакты");

    public $deleted = 0;
    public $resident = 1;
    public $f_quote = 50;
    public $admin_ids = array(); // массив идентификаторов администраторов компании
    public $admin_ids_string = '';
    public $bank_accounts2show = '';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Sites the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sites';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            /**
             * Компания для площадки.
             */
            'company2sites' => array(self::HAS_MANY, 'CompanySites', 'site_id'),
            'company' => array(self::HAS_ONE, 'Company', array('company_id' => 'id'), 'through' => 'company2sites'),
        );
    }

    public function getSitesNumber($company_id)
    {
        if (isset(Yii::app()->params['sites'][$company_id])) {
            $sites_max = Yii::app()->params['sites'][$company_id];
        } else {
            $sites_max = 3;
        }

        $res = Yii::app()->db->createCommand("select count(*) from company2sites where  company_id = $company_id")
            ->queryRow();

        return array('max' => $sites_max, 'have' => $res['count(*)']);
    }

    public function getSites($company_id)
    {
        $sites = Yii::app()->db->createCommand()
            ->select('site_id, sites.name, sites.domain, sites.template, templates.external_name')
            ->from('company2sites')
            ->join('sites', 'sites.id=company2sites.site_id')
            ->join('templates', 'templates.id=template')
            ->where('company_id=:id', array(':id' => $company_id))
            ->queryAll();

        return $sites;
    }

    public function getSite($site_id)
    {
        $site = Yii::app()->db->createCommand()
            ->select('name, domain, template, page_main.show as main, page_about.show as about, page_partners.show as partners, page_services.show as services, page_contacts.show as contacts')
            ->from('sites')
            ->join('page_main', 'sites.id = page_main.site_id')
            ->join('page_about', 'page_about.site_id = sites.id')
            ->join('page_partners', 'page_partners.site_id = sites.id')
            ->join('page_services', 'page_services.site_id = sites.id')
            ->join('page_contacts', 'page_contacts.site_id = sites.id')
            ->where('sites.id=:id', array(':id' => $site_id))
            ->queryRow();

        $site['logo'] = "/upload/" . $site_id . "_logo";

        return $site;
    }

    public function createSite($post)
    {
        //проверить пост
        $errors = false;
//		$company_id = $_POST['company_id'];
        if (strlen($post['sitename']) == 0) {
            $errors['sitename'] = "Название не может быть пустым.";
        }
        if (strlen($post['domain']) < 3) {
            $errors['domain'] = "Слишком короткое доменное имя.";
        } elseif (strpos($post['domain'], ".")) {
            $errors['domain'] = "Функционал по подключению внешних доменов не реализован.";
        } elseif (!preg_match("/^[a-z]{1}[a-z0-9\-_]{1,15}$/", $post['domain']) || (strlen($post['domain']) < 3)) {
            $errors['domain'] = "Доменное имя некорректно.";
        } else {
            $res = Yii::app()->db->createCommand("select count(*) from sites where domain = '{$post['domain']}'")->queryRow();
            if ($res['count(*)'] > 0) {
                $errors['domain'] = "Такой домен уже существует.";
            }
        }
        if ($errors) {
            $errors['error'] = true;
            return $errors;
        }
        $create_pages = array();
        $pages = array('about', 'services', 'partners', 'contacts');
        $company = $post['company_id'];
        foreach ($pages as $_page) {
            if (isset($post[$_page])) {
                if ($post[$_page] == "on") {
                    $create_pages[$_page] = "yes";
                } else {
                    $create_pages[$_page] = "no";
                }
            } else {
                $create_pages[$_page] = "no";
            }
        }

        $columns = array('name' => $post['sitename'], 'domain' => $post['domain'], 'template' => $post['template']);
        Yii::app()->db->createCommand()
            ->insert('sites', $columns);
        $site_id = Yii::app()->db->getLastInsertID();
        Yii::app()->db->createCommand()
            ->insert('company2sites', array('company_id' => $company, 'site_id' => $site_id));

        $this->createPage($site_id, 'page_main', "yes");
        $this->createPage($site_id, 'page_about', $create_pages['about']);
        $this->createPage($site_id, 'page_services', $create_pages['services']);
        $this->createPage($site_id, 'page_partners', $create_pages['partners']);
        //у страницы контактов баннера нет
        Yii::app()->db->createCommand()->insert('page_contacts', array('site_id' => $site_id, 'show' => $create_pages['contacts']));

        /**
         * Добавляем почтовый домен на Devecot серевер.
         */
        $domain = new \application\models\Mail\Domain();
        $domain->domain = $post['domain'] . '.' . Yii::app()->params->httpHostName;
        $domain->insert();

        return array('error' => false);
    }

    private function createPage($site_id, $page_kind, $show = "yes")
    {
        Yii::app()->db->createCommand()->insert('images', array());
        $banner_id = Yii::app()->db->getLastInsertID();
        Yii::app()->db->createCommand()->insert($page_kind, array('site_id' => $site_id, 'show' => $show, 'banner' => $banner_id));
    }

    public function updateSite($post, $files)
    {
        //проверить пост
        $errors = false;
        $company_id = $_POST['company_id'];
        if (strlen($post['sitename']) == 0) {
            $errors['sitename'] = "Название не может быть пустым.";
        }
        if (strlen($post['domain']) < 3) {
            $errors['domain'] = "Слишком короткое доменное имя.";
        } elseif (strpos($post['domain'], ".")) {
            $errors['domain'] = "Функционал по подключению внешних доменов не реализован.";
        } elseif (!preg_match("/^[a-z]{1}[a-z0-9\-_]{1,15}$/", $post['domain']) || (strlen($post['domain']) < 3)) {
            $errors['domain'] = "Доменное имя некорректно.";
        } else {
            $res = Yii::app()->db->createCommand("select count(*), domain from sites where domain = '{$post['domain']}'")->queryRow();
            if (($res['domain'] != $post['domain']) && ($res['count(*)'] > 0)) {
                $errors['domain'] = "Такой домен уже существует.";
            }
        }
        if ($errors) {
            $errors['error'] = true;
            return $errors;
        }

        $create_pages = array();
        $pages = array('about', 'services', 'partners', 'contacts');
        $site_id = $post['site_id'];
        foreach ($pages as $_page) {
            if (isset($post[$_page])) {
                if ($post[$_page] == "on") {
                    $create_pages[$_page] = "yes";
                } else {
                    $create_pages[$_page] = "no";
                }
            } else {
                $create_pages[$_page] = "no";
            }
        }

        if (!empty($files['logo']['name'])) {
            $dir_path = "upload/";
            $file_name = $post['site_id'] . "_logo";
            $res = move_uploaded_file($files['logo']['tmp_name'], $dir_path . $file_name);
        }

        $columns = array('name' => $post['sitename'], 'domain' => $post['domain'], 'template' => $post['template']);
        Yii::app()->db->createCommand()
            ->update('sites', $columns, 'id=:id', array(':id' => $site_id));

        Yii::app()->db->createCommand()->update('page_about', array('show' => $create_pages['about']), 'site_id=:id', array(':id' => $site_id));
        Yii::app()->db->createCommand()->update('page_services', array('show' => $create_pages['services']), 'site_id=:id', array(':id' => $site_id));
        Yii::app()->db->createCommand()->update('page_partners', array('show' => $create_pages['partners']), 'site_id=:id', array(':id' => $site_id));
        Yii::app()->db->createCommand()->update('page_contacts', array('show' => $create_pages['contacts']), 'site_id=:id', array(':id' => $site_id));

        return;
    }

    public function pageGet($site_id, $kind)
    {
        switch ($kind) {
            case 'main':
                $table = "page_main";
                break;
            case 'about':
                $table = "page_about";
                break;
            case 'partners':
                $table = "page_partners";
                break;
            case 'services':
                $table = "page_services";
                break;
            case 'contacts':
                $table = "page_contacts";
                $page = Yii::app()->db->createCommand("select * from $table where site_id = '$site_id'")->queryRow();
                break;
            default: {
                $kind = 'main';
                $table = "page_main";
            } break;
        }

        $cmd = Yii::app()->db->createCommand(
            "select * from files where site_id = :site_id and page_kind = :page_kind"
        );
        $files = $cmd->queryAll(true, array(
            ':site_id' => $site_id,
            ':page_kind' => 'page_'.$kind,
        ));

        foreach ($files as $_key => $_value) {
            $files[$_key]['filename'] = substr($_value['file'], (strrpos($_value['file'], "/") + 1));
        }

        if ($kind != 'contacts') {
            $page = Yii::app()->db->createCommand()
                ->select('title_window, title_page, content, images.file')
                ->from($table)
                ->leftJoin('images', $table . '.banner = images.id')
                ->where($table . '.site_id=:id', array(':id' => $site_id))
                ->queryRow();
        }

        if (isset($files)) {
            $page['files'] = $files;
        }

        $page['logo'] = "/upload/" . $site_id . "_logo";

        return $page;
    }

    public function pageSave($post, $files)
    {
        $bunner = true;
        $logo = true;
        $files_save = false;
        $columns = array('title_window' => $post['title_window'], 'title_page' => $post['title_page'], 'content' => $post['content']);
        switch ($post['kind']) {
            case 'main':
                $table = "page_main";
                break;
            case 'about':
                $table = "page_about";
                break;
            case 'partners':
                $table = "page_partners";
                break;
            case 'services':
                $table = "page_services";
                break;
            case 'contacts':
                $table = "page_contacts";
                $columns['map'] = $post['map'];
                $columns['address'] = $post['address'];
                $columns['email'] = $post['email'];
                $bunner = false;
                $logo = false;
                break;
        }
        /*
                if($logo) {
                    if(!empty($files['logo']['name'])) {
                        $dir_path = "upload/";
                        $file_name = $post['site_id']."_".$table."_logo";
                        move_uploaded_file($files['userfile']['tmp_name'], $dir_path.$file_name);
                    }
                }
        */
        if ($bunner) {
            if (!empty($files['userfile']['name'])) {
                $res = Yii::app()->db->createCommand("select `banner` from $table where site_id = {$post['site_id']}")->queryRow();
//				$dir_path = "upload/banners/";
                $dir_path = "upload/";
                $file_name = $post['site_id'] . "_" . $table;
                move_uploaded_file($files['userfile']['tmp_name'], $dir_path . $file_name);
                Yii::app()->db->createCommand()
                    ->update("images", array('file' => "/upload/" . $file_name), 'id=:id', array(':id' => $res['banner']));
                /*
                                Yii::app()->db->createCommand()
                                              ->update("images", array('file' => "/upload/banners/".$file_name), 'id=:id', array(':id'=> $res['banner']));
                */
            }
        }

//-------------------------------- загрузка файлов begin		
        $dir_path = "upload/";
        foreach ($files['files']['name'] as $_key => $_name) {
            if (empty($_name)) continue;
            $file_name = $_name;
            move_uploaded_file($files['files']['tmp_name'][$_key], $dir_path . $file_name);
            Yii::app()->db->createCommand()
                ->insert("files", array('file' => "/upload/" . $file_name, 'site_id' => $post['site_id'], 'page_kind' => $table));
        }
//-------------------------------- загрузка файлов end

        $res = Yii::app()->db->createCommand()
            ->update($table, $columns, 'site_id=:id', array(':id' => $post['site_id']));
        return true;
    }

    public function domainExist($site)
    {
        $res = $sites = Yii::app()->db->createCommand("select count(*) from sites where domain = '$site'")
            ->queryRow();
        return $res;
    }

    public function getTemplate($site)
    {
        $res = $sites = Yii::app()->db->createCommand()
            ->select('templates.name, sites.id')
            ->from('sites')
            ->join('templates', 'sites.template=templates.id')
            ->where('sites.domain=:domain', array(':domain' => $site))
            ->queryRow();

        return $res;
    }

    public function getTemplatesList()
    {
        $templates = Yii::app()->db->createCommand("select id, external_name from templates")->queryAll();
        return $templates;
    }

    public function getMenu($site_id)
    {
        $server_name = $_SERVER['HTTP_HOST'];
        $res = Yii::app()->db->createCommand("select domain from sites where id = $site_id")->queryRow();
        $domain = $res['domain'];

        $menu[] = array('page' => "http://" . $domain . "." . $server_name . "/", 'text' => 'Главная');
        foreach ($this->pages as $_page => $_text) {
            $res = Yii::app()->db->createCommand("select page_$_page.show from page_$_page where site_id = $site_id")->queryRow();
            if ($res['show'] == "yes") {
                $menu[] = array('page' => "http://" . $domain . "." . $server_name . "/" . $_page, 'text' => $_text);
            }
        }

        return $menu;
    }

    public function mail($self_email, $fio, $email, $text)
    {
        $headers = "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: no_reply@twt-virt.ru";

        $message = "Сообщение от $fio ($email): <br />";
        $message .= $text;

        $res = mail($self_email, "Сообщение от пользователя с сайта twt-virt.artektiv.ru", $message, $headers);
    }

    /**
     * @return array validation rules for model attributes.
     */
    /*
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('name, f_quote', 'required'),
                array('deleted, admin_ids_string, admin_ids', 'safe', 'on' => 'update, insert'),
                array('admin_ids_string, admin_ids, legal_address, actual_address, phone, email, resident, inn, kpp, okopf, ogrn, account_number, bank, bik, correspondent_account, vat, registration_number, registration_date, registration_country, swift, iban, position_name1, position_owner1, position_name2, position_owner2, position_name3, position_owner3', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, name, inn, kpp', 'safe', 'on'=>'search'),
            );
        }
    */
    /**
     * @return array relational rules.
     */
    /*
        public function relations()
        {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                'user2company' => array(self::HAS_MANY, 'User2company', 'company_id'),
                'users' => array(self::HAS_MANY, 'User', array('user_id' => 'id'), 'through' => 'user2company'),
                'used_quote' => array(self::STAT, 'Files', 'company_id', 'select' => 'SUM(size)'),
                'files' => array(self::HAS_MANY, 'Files', 'company_id'),
                'admin2company' => array(self::HAS_MANY, 'Admin2company', 'company_id'),
                'admins' => array(self::HAS_MANY, 'User', array('user_id' => 'id'), 'through' => 'admin2company'),
                'bankAccounts' => array(self::HAS_MANY, 'CBankAccount', 'company_id'),
            );
        }
    */
    // вместо afterFind вызывается данная функция, так как в afterFind возникает бесконечный цикл
    /**
     * Возвращает массив идентификаторов админов
     * @return array
     */
}