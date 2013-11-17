<?php
use application\modules\domain\models as M;

/**
 * Создание нового поддомена для компании
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class CreateAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('createSite')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var application\modules\domain\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Создание сайтов';

        $model = new M\Domain();
        $model->company_id = $controller->company->primaryKey;

        $class = str_replace('\\', '_', get_class($model));
        $data = Yii::app()->request->getPost($class);
        if ($data){
            $model->attributes = $data;
            if ($model->validate()){
                $model->save(false);
                $controller->redirect($controller->createUrl('index', array('cid' => $controller->company->primaryKey)));
            }
        }

        $controller->render(
            'form',
            array(
                'model' => $model,
            )
        );
    }
}