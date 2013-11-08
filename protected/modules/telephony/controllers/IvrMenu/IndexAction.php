<?php
/**
 * Голосовое меню.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readIvrMenuTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\Ivr_menuController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Голосовое меню';

        $controller->render(
            '/default/tabs',
            array(
                'content' => $controller->renderPartial(
                    '/default/ivr_tabs',
                    array(
                        'content' => $controller->renderPartial(
                            'index',
                            array(),
                            true
                        ),
                    ),
                    true
                )
            )
        );
    }
}