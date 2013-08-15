<?php

class DisplayController extends Controller
{
	public $company_id;
	public $layout = '/layouts/main';
	public $controller_name = "sites";
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function accessRules() {
		return array();
	}
	
	public function actionIndex($site, $kind = null) {
	}

	public function actionTest() {
		$this->render('error', array());
	}
	
	public function actionView($site, $kind = null) {
		$server_name = $_SERVER['HTTP_HOST'];
		
		if($kind == null) {
			$kind = 'main';
		}
		$res = Sites::model()->domainExist($site);
		
		if($res['count(*)'] == 0) {
			$this->render('error', array());
			
		}
		exit();
		$res = Sites::model()->getTemplate($site);
		$page = Sites::model()->pageGet($res['id'], $kind);
		$menu = Sites::model()->getMenu($res['id']);
		
		$this->renderPartial("//templates/".$res['name'], array('page' => $page, 'menu' => $menu, 'kind' => $kind, 'path' => $server_name));
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}