<?php
use application\modules\telephony\models as M;

/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class SipAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('readSipTelephony')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | SIP';
        $controller->tab_menu = 'sip';

        $model = new M\FormSIP();

        if(isset($_POST['ajax']) && $_POST['ajax']==='form-sip') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $data = Yii::app()->request->getPost(get_class($model));
        if ($data){
            $model->attributes = $data;
            if ($model->validate()){
                // Save & redirect

                Yii::app()->user->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                $controller->redirect($controller->createUrl('sip', array(
                    'cid' => $controller->company->primaryKey,
                )));
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'sip',
                    array(
                        'model' => $model
                    ),
                    true
                )
            )
        );
    }
}