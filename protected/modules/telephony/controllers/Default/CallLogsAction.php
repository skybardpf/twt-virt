<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class CallLogsAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readCallLogsTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Логи звонков';
        $controller->tab_menu = 'call_logs';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'call_logs',
                    array(),
                    true
                )
            )
        );
    }
}