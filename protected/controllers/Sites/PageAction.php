<?php
/**
 * Class PageAction
 */
class PageAction extends CAction
{
    /**
     * @param integer $site_id
     * @param string $kind
     * @throws CHttpException
     */
    public function run($site_id, $kind)
    {
        if(!Yii::app()->user->checkAccess('pagesSite')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var SitesController $controller
         */
        $controller = $this->controller;

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

//        $page = array('title_window' => "", 'title_page' => "");
        $page = Sites::model()->pageGet($site_id, $kind);

        $controller->render(
            $view,
            array(
                'site_id' => $site_id,
                'title' => $title,
                'kind' => $kind,
                'page' => $page,
                'company_id' => $controller->company->primaryKey,
            )
        );

    }
}