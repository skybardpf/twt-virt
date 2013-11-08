<?php
use application\modules\telephony\models as M;

/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class InternalNumberAction extends CAction
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
        $controller->pageTitle = Yii::app()->name .' | Телефония | Настройки внутреннего номера';
        $controller->tab_menu = 'internal_number';

        $model = new M\FormInternalNumber();

        if(isset($_POST['ajax']) && $_POST['ajax']==='form-internal-number') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $data = Yii::app()->request->getPost($controller->getClassNameWithNamespace($model));
        if ($data){
            if(!Yii::app()->user->checkAccess('updateInternalNumbersTelephony')) {
                throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
            }

            $model->attributes = $data;
            if ($model->validate()){
                // Save & redirect

                Yii::app()->user->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                $controller->redirect($controller->createUrl('internal_number', array(
                    'cid' => $controller->company->primaryKey,
                )));
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'internal_number',
                    array(
                        'model' => $model,
                    ),
                    true
                )
            )
        );
    }
}