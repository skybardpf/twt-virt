<?php
/**
 * Class MailController
 */
class MailController extends Controller
{
	public $layout = '/layouts/owner';
	public $controller_name = "mail";
	
//	public function accessRules() {
//		return array();
//	}
//
//	public function actionIndex($site, $kind = null) {
//	}

//	public function actionTest() {
//		$this->render('error', array());
//	}
	
//	public function actionView($site, $kind = null) {
//		$server_name = $_SERVER['HTTP_HOST'];
//
//		if($kind == null) {
//			$kind = 'main';
//		}
//		$res = Sites::model()->domainExist($site);
//
//		if($res['count(*)'] == 0) {
//			$this->render('error', array());
//			exit();
//		}
//
//		$res = Sites::model()->getTemplate($site);
//		$page = Sites::model()->pageGet($res['id'], $kind);
//		$menu = Sites::model()->getMenu($res['id']);
//
//		$this->renderPartial("//templates/".$res['name'], array('page' => $page, 'menu' => $menu, 'kind' => $kind, 'path' => $server_name));
//	}
	
	/**
	 *
	 */
	public function actionLayout()
	{
		$this->render('layout');
	}

    public function actionIframe_layout()
    {
        $this->renderPartial('iframe_layout', null, false, true);
    }
}