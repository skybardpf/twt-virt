<?php
/**
 * Управление паролями к Email аккаунтам.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class LoginEmailsAction extends CAction
{
    public function run()
    {
        /**
         * @var User $user
         */
        $user = Yii::app()->user->data;
        if ($user->isAdmin){
            throw new CHttpException(403, 'Админ не имеет Email аккаунтов');
        }

        /**
         * @var UsersController $controller
         */
        $controller = $this->controller;
        $controller->breadcrumbs = array(
            'Email аккаунты'
        );
        $controller->pageTitle = 'Пароли к Email аккаунтам';
        $controller->tab_menu = 'login_emails';

        $tmp = UserEmail::model()->with('site')->findAll('user_id=:user_id', array(
            ':user_id' => $user->primaryKey,
        ));
        $emails = array();
        /**
         * @var UserEmail[] $data_emails
         */
        $data_emails = array();
        foreach ($tmp as $val){
            $emails[$val->primaryKey] = $val->login_email.'@'.$val->site->domain.'.'.Yii::app()->params->httpHostName;
            $data_emails[$val->primaryKey] = $val;
        }

        $formEmail = new FormAuthMail();
        $formEmail->setScenario('change_pass');
        $formEmail->validatorList->add(
            CValidator::createValidator('in', $formEmail, 'user_email_id', array(
                'range' => array_keys($emails)
            ))
        );

        $data = Yii::app()->request->getPost(get_class($formEmail));
        if($data) {
            $formEmail->attributes = $data;
            if($formEmail->validate()){
                if (!isset($data_emails[$formEmail->user_email_id])){
                    $formEmail->addError('user_email_id', 'Выбран неправильный аккаунт');
                } else {
                    $email = $data_emails[$formEmail->user_email_id];
                    $email->setScenario('update');
                    $email->old_password = $email->password;
                    $email->password = $formEmail->password;
                    $email->save(false);

                    $email->old_email = $email->getFullDomain();
                    $email->changeLoginPassDevecot();

                    Yii::app()->user->setFlash('success', Yii::t('app', 'Пароль успешно изменен'));
                }
                $controller->redirect($controller->createUrl('login_emails'));
            }
        }

        $controller->render('/users/menu', array(
                'content' => $controller->renderPartial(
                    '/users/profile_emails',
                    array(
                        'user' => $user,
                        'emails' => $emails,
                        'formEmail' => $formEmail,
                    ),
                    true
                ),
                'user' => $user,
            )
        );
    }
}