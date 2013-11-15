<?php
/**
 * Class SettingsAction
 */
class SettingsAction extends CAction
{
    /**
     * @param integer $site_id
     * @throws CHttpException
     */
    public function run($site_id)
    {
        if(!Yii::app()->user->checkAccess('settingsSite')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var SitesController $controller
         */
        $controller = $this->controller;

        $errors = array();
        if (isset($_POST) && !empty($_POST)){
            $errors = Sites::model()->updateSite($site_id, $_POST, $_FILES);
            if (empty($errors['error'])) {
                $controller->redirect($controller->createUrl(
                    'list',
                    array(
                        'cid' => $controller->company->primaryKey,
                    )
                ));
            }
        }

        $templates = Sites::model()->getTemplatesList();
        $site = Sites::model()->getSite($site_id);
        $controller->render(
            'site_settings',
            array(
                'site_id' => $site_id,
                'site' => $site,
                'company_id' => $controller->company->primaryKey,
                'templates' => $templates,
                'errors' => $errors
            )
        );
    }
}