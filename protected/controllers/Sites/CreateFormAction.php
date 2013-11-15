<?php
/**
 * Class CreateFormAction
 */
class CreateFormAction extends CAction
{
    /**
     * @param array | null $page
     * @param bool $errors
     * @throws CHttpException
     */
    public function run($page = null, $errors = false)
    {
        if(!Yii::app()->user->checkAccess('createSite')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var SitesController $controller
         */
        $controller = $this->controller;

        if (isset($_POST) && !empty($_POST)){
            $errors = Sites::model()->createSite($_POST);

            if (empty($errors['error'])) {
                $controller->redirect($controller->createUrl(
                    'list',
                    array(
                        'cid' => $controller->company->primaryKey,
                    )
                ));
            }
            $page = $_POST;
        }

        $templates = Sites::model()->getTemplatesList();
        $controller->render(
            'sitecreate',
            array(
                'company_id' => $controller->company->primaryKey,
                'templates' => $templates,
                'page' => $page,
                'errors' => $errors
            )
        );
    }
}