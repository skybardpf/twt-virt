<?php
use application\modules\domain\models as M;

/**
 * Редактирование поддомена для компании
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class UpdateAction extends CAction
{
    /**
     * @param integer $sid
     * @throws CHttpException
     */
    public function run($sid)
    {
        if(!Yii::app()->user->checkAccess('updateSite')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var application\modules\domain\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Редактирование сайта';

        $model = M\Domain::model()->findByPk($sid);
        if ($model === null){
            throw new CHttpException(404, Yii::t('app', 'Не найден поддомен компании'));
        }

//        $class = str_replace('\\', '_', get_class($model));
//        $data = Yii::app()->request->getPost($class);
        $data = Yii::app()->request->getPost(get_class($model));
        if ($data){
            $model->attributes = $data;
            if ($model->validate()){
                $model->save(false);
                $controller->redirect(
                    $controller->createUrl(
                        'index',
                        array(
                            'cid' => $controller->company->primaryKey
                        )
                    )
                );
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'form',
                    array(
                        'model' => $model,
                    ),
                    true
                ),
                'model' => $model,
                'active_tab' => 'site',
            )
        );
    }
}