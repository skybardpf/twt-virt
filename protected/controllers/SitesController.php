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
            'settings' => 'application.controllers.Sites.SettingsAction',
            'createform' => 'application.controllers.Sites.CreateFormAction',
            'delete' => 'application.controllers.Sites.DeleteAction',
        );
    }

    public function actionCreate()
    {

    }

    public function actionSettings_save()
    {
        $errors = Sites::model()->updateSite($_POST, $_FILES);
        $this->actionSettings($_POST['company_id'], $_POST['site_id'], $errors);
    }

    public function actionPage($company_id, $site_id, $kind)
    {
        $view = "site_page";
        switch ($kind) {
            case 'main':
                $title = "Страница 'Главная'";
                break;
            case 'about':
                $title = "Страница 'О компании'";
                break;
            case 'partners':
                $title = "Страница 'Партнёры'";
                break;
            case 'services':
                $title = "Страница 'Услуги'";
                break;
            case 'contacts':
                $title = "Страница 'Контакты'";
                $view = "contact_page";
                break;
        }

        $page = array('title_window' => "", 'title_page' => "");
        $page = Sites::model()->pageGet($site_id, $kind);

        $this->render($view, array('site_id' => $site_id, 'title' => $title, 'kind' => $kind, 'page' => $page, 'company_id' => $company_id));
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