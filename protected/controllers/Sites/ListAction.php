<?php
/**
 * Class ListAction
 */
class ListAction extends CAction
{
    /**
     * @throws CHttpException
     */
    public function run()
    {
        if(!Yii::app()->user->checkAccess('listSites')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var SitesController $controller
         */
        $controller = $this->controller;

        $sites = Sites::model()->getSites($controller->company->primaryKey);
        $sites_num = Sites::model()->getSitesNumber($controller->company->primaryKey);
        $sign['disabled'] = false;
        $sign['type'] = "link";
        if ($sites_num['have'] == $sites_num['max']) {
            $sign['disabled'] = true;
            $sign['type'] = "button";
            $sign['text'] = "Вы уже создали максимальное для этой компании количество сайтов. Чтобы создать новый сайт – требуется удалить один из уже существующих.";
        }

        $controller->render(
            'sitelist',
            array(
                'sites' => $sites,
                'sign' => $sign
            )
        );
    }
}