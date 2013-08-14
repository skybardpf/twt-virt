<?php

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
	 * @return Company the static model class
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
		return 'sites';
	}

	public function getSites($company_id) {
		$sites = Yii::app()->db->createCommand()
						  ->select('site_id, sites.name, sites.domain, sites.template')
						  ->from('company2sites')
						  ->join('sites', 'sites.id=company2sites.site_id')
						  ->where('company_id=:id', array(':id'=>$company_id))
						  ->queryAll();

		return $sites;
	}
	
	public function getSite($site_id) {
		$site = Yii::app()->db->createCommand()
						  ->select('name, domain, template, page_main.show as main, page_about.show as about, page_partners.show as partners, page_services.show as services, page_contacts.show as contacts')
						  ->from('sites')
						  ->join('page_main', 'sites.id = page_main.site_id')
						  ->join('page_about', 'page_about.site_id = sites.id')
						  ->join('page_partners', 'page_partners.site_id = sites.id')
						  ->join('page_services', 'page_services.site_id = sites.id')
						  ->join('page_contacts', 'page_contacts.site_id = sites.id')
						  ->where('sites.id=:id', array(':id'=>$site_id))
						  ->queryRow();
	
		return $site;
	}
	
	public function createSite($post) {
		//проверить пост
		if(!preg_match("/^[a-z0-1]{1}[a-z0-1\-]{1,9}[a-z0-1]{1}$/", $post['domain']) || (strlen($post['domain']) < 3)) {
			return false;
		}
		$create_pages = array();
		$pages = array('about', 'services', 'partners', 'contacts');
		$company = $post['company_id'];
		foreach($pages as $_page) {
			if(isset($post[$_page])) {
				if($post[$_page] == "on") {
					$create_pages[$_page] = "yes";
				}
				else {
					$create_pages[$_page] = "no";
				}
			}
			else {
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
					  
		return true;
	}
	
	private function createPage($site_id, $page_kind, $show = "yes") {
		Yii::app()->db->createCommand()->insert('images', array());
		$banner_id = Yii::app()->db->getLastInsertID();
		Yii::app()->db->createCommand()->insert($page_kind, array('site_id' => $site_id, 'show' => $show, 'banner' => $banner_id));
	}
	
	public function updateSite($post) {
		//проверить пост
		$create_pages = array();
		$pages = array('about', 'services', 'partners', 'contacts');
		$site_id = $post['site_id'];
		foreach($pages as $_page) {
			if(isset($post[$_page])) {
				if($post[$_page] == "on") {
					$create_pages[$_page] = "yes";
				}
				else {
					$create_pages[$_page] = "no";
				}
			}
			else {
				$create_pages[$_page] = "no";
			}
		}
		
		$columns = array('name' => $post['sitename'], 'domain' => $post['domain'], 'template' => $post['template']);
		Yii::app()->db->createCommand()
					  ->update('sites', $columns, 'id=:id', array(':id'=>$site_id));
		
		Yii::app()->db->createCommand()->update('page_about', array('show' => $create_pages['about']), 'site_id=:id', array(':id'=>$site_id));
		Yii::app()->db->createCommand()->update('page_services', array('show' => $create_pages['services']), 'site_id=:id', array(':id'=>$site_id));
		Yii::app()->db->createCommand()->update('page_partners',array('show' => $create_pages['partners']), 'site_id=:id', array(':id'=>$site_id));
		Yii::app()->db->createCommand()->update('page_contacts',array('show' => $create_pages['contacts']), 'site_id=:id', array(':id'=>$site_id));		
					  
		return;
	}
	
	public function pageGet($site_id, $kind) {
		switch($kind) {
			case 'main':
				$table = "page_main";
				$files = $page = Yii::app()->db->createCommand("select * from files where site_id = $site_id")
											   ->queryAll();
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
		}
		
		if($kind != 'contacts') {
			$page = Yii::app()->db->createCommand()
							  ->select('title_window, title_page, content, images.file')
							  ->from($table)
							  ->join('images', $table.'.banner = images.id')
							  ->where($table.'.site_id=:id', array(':id'=>$site_id))
							  ->queryRow();
		}
		
		if(isset($files)) {
			$page['files'] = $files;
		}
		
		return $page;
	}
	
	public function pageSave($post, $files) {
		$bunner = true;
		$files_save = true;
		$columns = array('title_window' => $post['title_window'], 'title_page' => $post['title_page'], 'content' => $post['content']);
		switch($post['kind']) {
			case 'main':
				$table = "page_main";
				$files_save = true;
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
				$bunner = false;
				break;
		}
		
		if($bunner) {
			if(isset($files['userfile']['name'])) {
				$res = Yii::app()->db->createCommand("select `banner` from $table where site_id = {$post['site_id']}")->queryRow();
				$dir_path = "banners/";
				$file_name = $post['site_id']."_".$table;
				move_uploaded_file($files['userfile']['tmp_name'], $dir_path.$file_name);
				Yii::app()->db->createCommand()
							  ->update("images", array('file' => "/banners/".$file_name), 'id=:id', array(':id'=> $res['banner']));
			}
		}
		
		if($files_save) {
			if(isset($files['files']['name'])) {
				$dir_path = "upload/";
				foreach($files['files']['name'] as $_key => $_name) {
					$file_name = $_name;
					move_uploaded_file($files['files']['tmp_name'][$_key], $dir_path.$file_name);
					Yii::app()->db->createCommand()
							  ->insert("files", array('file' => "/upload/".$file_name, 'site_id' => $post['site_id']));
				}
			}
		}
		
		$res = Yii::app()->db->createCommand()
						 ->update($table, $columns, 'site_id=:id', array(':id'=>$post['site_id']));
		return true;
	}
	
	public function getTemplate($site) {
		$res = $sites = Yii::app()->db->createCommand()
						  		  ->select('templates.name, sites.id')
						  		  ->from('sites')
						  		  ->join('templates', 'sites.template=templates.id')
						  		  ->where('sites.domain=:domain', array(':domain'=>$site))
						  		  ->queryRow();
		
		return $res;
	}
	
	public function getTemplatesList() {
		$templates = Yii::app()->db->createCommand("select id, external_name from templates")->queryAll();
		return $templates;
	}
	
	public function getMenu($site_id) {
		$server_name = $_SERVER['HTTP_HOST'];
		$res = Yii::app()->db->createCommand("select domain from sites where id = $site_id")->queryRow();
		$domain = $res['domain'];
		
		$menu[] = array('page' => "http://".$domain.".".$server_name."/main", 'text' => 'Главная');
		foreach($this->pages as $_page => $_text) {
			$res = Yii::app()->db->createCommand("select page_$_page.show from page_$_page where site_id = $site_id")->queryRow();
			if($res['show'] == "yes") {
				$menu[] = array('page' => "http://".$domain.".".$server_name."/".$_page, 'text' => $_text);
			}
		}
		
		return $menu;
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