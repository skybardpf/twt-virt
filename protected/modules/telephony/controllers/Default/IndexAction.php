<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Информация';

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'info',
                    array(),
                    true
                )
            )
        );
    }
}