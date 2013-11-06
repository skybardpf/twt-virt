<?php

class SitesController extends Controller
{
    public $company_id;
    public $layout = '/layouts/owner';
    public $controller_name = "sites";

    public function actions()
    {
        return array(
            'list' => 'application.controllers.Sites.ListAction',
            'delete' => 'application.controllers.Sites.DeleteAction',
        );
    }

    public function actionCreateform($company_id = null, $page = null, $errors = false)
    {
        $templates = Sites::model()->getTemplatesList();
        $this->render('sitecreate', array('company_id' => $company_id, 'templates' => $templates, 'page' => $page, 'errors' => $errors));
    }

    public function actionCreate()
    {
        $errors = Sites::model()->createSite($_POST);

        if ($errors['error']) {
            $this->actionCreateform($_POST['company_id'], $_POST, $errors);
            exit();
        }
        $this->redirect($this->createUrl('list', array('company_id' => $_POST['company_id'])));
    }

    public function actionSettings($company_id = null, $site_id = null, $errors = false)
    {
        $templates = Sites::model()->getTemplatesList();
        $site = Sites::model()->getSite($site_id);
        $this->render('site_settings', array('site_id' => $site_id, 'site' => $site, 'company_id' => $company_id, 'templates' => $templates, 'errors' => $errors));
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

    public function actionReg()
    {
        $text = "1t1-est";

        var_dump(preg_match("/^[a-z0-1]{1}[a-z0-1\-]{1,9}[a-z0-1]{1}$/", $text));
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

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionMail()
    {
        Sites::model()->mail($_POST['self_email'], $_POST['fio'], $_POST['email'], $_POST['text']);

    }
}