<?php
/**
 * @var ProfileController $this
 * @var User $user
 * @var array $emails
 * @var FormAuthMail $formEmail
 */
?>
<h3><?= CHtml::encode(Yii::t('app', 'Пароли к Email аккаунтам')); ?></h3>

<?php
if (empty($emails)){
    echo 'Не найдено Email аккаунтов';
} else {
    echo $this->renderPartial('_form_login_emails',
        array(
            'user' => $user,
            'emails' => $emails,
            'formEmail' => $formEmail,
        )
    );
}