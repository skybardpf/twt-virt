<?php
use application\modules\telephony\models as M;

/**
 * Редактирование пункта голосового меню.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class UpdateAction extends CAction
{
    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function run($id)
    {
        if(!Yii::app()->user->checkAccess('updateIvrMenuTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\Ivr_menuController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Редактирование пункта голосового меню';

        $model = new M\FormIvrMenu();
        $model->isNewRecord = false;

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