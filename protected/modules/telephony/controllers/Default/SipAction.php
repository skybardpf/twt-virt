<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class SipAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readSipTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | SIP';
        $controller->tab_menu = 'sip';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'sip',
                    array(),
                    true
                )
            )
        );
    }
}