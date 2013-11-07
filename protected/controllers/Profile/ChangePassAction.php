<?php
/**
 * Смена пароля для профиля
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class ChangePassAction extends CAction
{
    public function run()
    {
        if(!Yii::app()->user->checkAccess('changePassProfile')) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | ' .Yii::t('app', 'Смена пароля для профиля');

        /**
         * @var User $user
         */
        $user = clone Yii::app()->user->data;
        $user->password = NULL;
        $user->setScenario('change_pass');

        if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
            echo CActiveForm::validate($user);
            Yii::app()->end();
        }

        $data = Yii::app()->request->getPost(get_class($user));
        if ($data) {
            $user->attributes = $data;
            if (User::createHash($user->old_password, Yii::app()->user->data->salt)== Yii::app()->user->data->password) {
                if ($user->save()) {
                    $controller->redirect($controller->createUrl('index'));
                }
            } else {
                $user->addError('old_password', 'Старый пароль введен неверно');
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'change_pass',
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