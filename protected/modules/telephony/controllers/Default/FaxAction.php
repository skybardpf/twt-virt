<?php
use application\modules\telephony\models as M;

/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FaxAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readFaxTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Факс';
        $controller->tab_menu = 'fax';

        $model = new M\FormSendFax();

        if(isset($_POST['ajax']) && $_POST['ajax']==='form-send-fax') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $data = Yii::app()->request->getPost($controller->getClassNameWithNamespace($model));
        if ($data){
            if(!Yii::app()->user->checkAccess('sendFaxTelephony')) {
                throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
            }
            $model->attributes = $data;
            if ($model->validate()){
                // Send fax

                Yii::app()->user->setFlash('success', Yii::t('app', 'Факс поставлен в очередь на отправку'));
                $controller->redirect($controller->createUrl('fax', array(
                    'cid' => $controller->company->primaryKey,
                )));
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'fax',
                    array(
                        'model' => $model,
                    ),
                    true
                )
            )
        );
    }
}