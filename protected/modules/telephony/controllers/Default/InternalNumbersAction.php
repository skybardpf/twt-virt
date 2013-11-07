<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class InternalNumbersAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readInternalNumbersTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Внутренние номера';
        $controller->tab_menu = 'internal_numbers';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'internal_numbers',
                    array(),
                    true
                )
            )
        );
    }
}