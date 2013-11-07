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
         * @var ProfileController $controller
         */
        $controller = $this->controller;
        if(!Yii::app()->user->checkAccess('changeLoginEmailsProfile')) {
            $controller->redirect($controller->createUrl('index'));
        }

        $controller->pageTitle = Yii::app()->name .' | ' .Yii::t('app', 'Пароли к Email аккаунтам');
        $controller->tab_menu = 'login_emails';

        /**
         * @var User $user
         */
        $user = Yii::app()->user->data;
        /**
         * @var UserEmail[] $tmp
         */
        $tmp = UserEmail::model()->with('site')->findAll('user_id=:user_id', array(
            ':user_id' => $user->primaryKey,
        ));
        $emails = array();
        $data_emails = array();
        foreach ($tmp as $val){
            $emails[$val->primaryKey] = $val->getFullDomain();
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
                    $formEmail->addError('user_email_id', Yii::t('app', 'Выбран неправильный аккаунт'));
                } else {
                    /**
                     * @var UserEmail $email
                     */
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

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'login_emails',
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