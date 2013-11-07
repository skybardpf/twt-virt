<?php
/**
 * Редактирование профиля
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class UpdateAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('updateProfile')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | ' .Yii::t('app', 'Редактирование профиля');

        /**
         * @var User $user
         */
        $user =  Yii::app()->user->data;
        $user->setScenario('profile');

        if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
            echo CActiveForm::validate($user);
            Yii::app()->end();
        }

        $data = Yii::app()->request->getPost(get_class($user));
        if ($data) {
            $user->attributes = $data;
            if ($user->save()) {
                $controller->redirect($controller->createUrl('index'));
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'update',
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