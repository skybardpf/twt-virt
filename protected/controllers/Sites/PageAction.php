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

        if (isset($_POST) && !empty($_POST)){
            if (Sites::model()->pageSave($site_id, $_POST, $_FILES)) {
                $controller->redirect($controller->createUrl(
                    'page',
                    array(
                        'cid' => $controller->company->primaryKey,
                        'site_id' => $site_id,
                        'kind' => $_POST['kind'],
                    )
                ));
            }
            $kind = $_POST['kind'];
        }

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
            default: {
                $title = "Страница 'Главная'";
                $kind = 'main';
                break;
            }
        }

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