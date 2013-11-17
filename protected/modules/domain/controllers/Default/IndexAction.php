<?php
use application\modules\domain\models as M;

/**
 * Список сайтов для компании
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('listSites')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var application\modules\domain\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Список сайтов';

        $domains = M\Domain::model()->with('template')->findAll(
            'company_id=:company_id',
            array(
                ':company_id' => $controller->company->primaryKey,
            )
        );

        $controller->render(
            'index',
            array(
                'data' => $domains,
            )
        );
    }
}