<?php
/**
 * @var UsersController $this
 * @var User $user
 * @var array $emails
 * @var FormAuthMail $formEmail
 */
?>
<h3><?= CHtml::encode($this->pageTitle); ?></h3>

<?php
if (empty($emails)){
    echo 'Не найдено Email аккаунтов';
} else {
    echo $this->renderPartial('_form_profile_emails',
        array(
            'user' => $user,
            'emails' => $emails,
            'formEmail' => $formEmail,
        )
    );
}