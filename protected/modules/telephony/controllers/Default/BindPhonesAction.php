<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class BindPhonesAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readBindPhonesTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Привязка внутренних номеров';
        $controller->tab_menu = 'bind_phones';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'bind_phones',
                    array(),
                    true
                )
            )
        );
    }
}