<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FaxAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readFaxTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Факс';
        $controller->tab_menu = 'fax';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'fax',
                    array(),
                    true
                )
            )
        );
    }
}