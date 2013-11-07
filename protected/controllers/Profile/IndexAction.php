<?php
/**
 * Просмотр профиля
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readProfile')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | ' .Yii::t('app', 'Просмотр профиля');

        $user =  Yii::app()->user->data;
        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'info',
                    array(
                        'user' => $user,
                    ),
                    true
                ),
                'user' => $user,
            )
        );
    }
}