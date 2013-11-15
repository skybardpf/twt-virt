<?php

class SitesController extends \CompanyController
{
    public $company_id;
    public $layout = '/layouts/owner';
    public $controller_name = "sites";

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'list' => 'application.controllers.Sites.ListAction',
            'page' => 'application.controllers.Sites.PageAction',
            'settings' => 'application.controllers.Sites.SettingsAction',
            'createform' => 'application.controllers.Sites.CreateFormAction',
            'delete' => 'application.controllers.Sites.DeleteAction',
        );
    }

    public function actionPage_save()
    {
        $res = Sites::model()->pageSave($_POST, $_FILES);
        $this->actionPage($_POST['company_id'], $_POST['site_id'], $_POST['kind']);
    }

    public function actionView($site, $kind = 'main')
    {
        $res = Sites::model()->getTemplate($site);
        if ($res === false){
            throw new CHttpException(404, 'Страница не найдена');
        }
        $page = Sites::model()->pageGet($res['id'], $kind);
        $menu = Sites::model()->getMenu($res['id']);
        $this->renderPartial("//templates/" . $res['name'], array('var' => "тестовое значение переменной var", 'path' => $this->asset_static, 'page' => $page, 'menu' => $menu, 'kind' => $kind));
    }

    public function actionMail()
    {
        Sites::model()->mail($_POST['self_email'], $_POST['fio'], $_POST['email'], $_POST['text']);
    }
}