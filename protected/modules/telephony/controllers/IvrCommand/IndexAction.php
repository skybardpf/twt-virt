<?php
use \application\modules\telephony\models as M;

/**
 * Голосовые команды.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readIvrCommandTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\Ivr_commandController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Голосовые команды';

        $data = M\FormIvrCommand::getStandardCommands();

        $controller->render(
            '/default/tabs',
            array(
                'content' => $controller->renderPartial(
                    '/default/ivr_tabs',
                    array(
                        'content' => $controller->renderPartial(
                            'index',
                            array(
                                'data' => $data,
                            ),
                            true
                        ),
                    ),
                    true
                )
            )
        );
    }
}