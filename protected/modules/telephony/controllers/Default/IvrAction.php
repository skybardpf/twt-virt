<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IvrAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readIvrTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Голосовое меню';
        $controller->tab_menu = 'ivr';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'ivr',
                    array(),
                    true
                )
            )
        );
    }
}