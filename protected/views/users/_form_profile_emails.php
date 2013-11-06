<?php
/**
 * @var UsersController $this
 * @var User $user
 * @var array $emails
 * @var FormAuthMail $formEmail
 */

if(Yii::app()->user->hasFlash('success')){
    ?>
    <div style="color: green;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <?php
}

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-login-emails',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnChange' => true,
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Сменить пароль к аккаунту'
));
if ($formEmail->hasErrors()) {
    echo '<br/><br/>' . $form->errorSummary($formEmail);
}
?>

<fieldset>
    <?php
    $emails[0] = Yii::t('app', '--- Выберите ---');

    echo $form->dropDownListRow($formEmail, 'user_email_id', $emails, array('class' => 'input-xxlarge'));
    echo $form->passwordFieldRow($formEmail, 'old_password', array('class' => 'input-xxlarge'));
    echo $form->passwordFieldRow($formEmail, 'password', array('class' => 'input-xxlarge'));
    echo $form->passwordFieldRow($formEmail, 'repassword', array('class' => 'input-xxlarge'));
    ?>
</fieldset>

<?php
$this->endWidget();
