<?php
/**
 * Class SettingsAction
 */
class SettingsAction extends CAction
{
    /**
     * @param integer | null $company_id
     * @param integer | null $site_id
     * @param bool $errors
     * @throws CHttpException
     */
    public function run($company_id = null, $site_id = null, $errors = false)
    {
        if(!Yii::app()->user->checkAccess('settingsSite')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var SitesController $controller
         */
        $controller = $this->controller;

        $templates = Sites::model()->getTemplatesList();
        $site = Sites::model()->getSite($site_id);
        $controller->render(
            'site_settings',
            array(
                'site_id' => $site_id,
                'site' => $site,
                'company_id' => $company_id,
                'templates' => $templates,
                'errors' => $errors
            )
        );
    }
}