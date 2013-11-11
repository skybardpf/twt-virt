<?php
use application\modules\telephony\models as M;

/**
 * Добавление пункта голосового меню.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class CreateAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('createIvrMenuTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\Ivr_menuController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Добавление пункта голосового меню';

        $model = new M\FormIvrMenu();

        if(isset($_POST['ajax']) && $_POST['ajax']==='form-ivr-menu') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $data = Yii::app()->request->getPost(get_class($model));
        if ($data){
            $model->attributes = $data;
            if ($model->validate()){
                // Save & redirect

                $controller->redirect($controller->createUrl('index', array(
                    'cid' => $controller->company->primaryKey,
                )));
            }
        }

        $controller->render(
            '/default/tabs',
            array(
                'content' => $controller->renderPartial(
                    '/default/ivr_tabs',
                    array(
                        'content' => $controller->renderPartial(
                            'form',
                            array(
                                'model' => $model,
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