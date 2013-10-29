<?php
/**
 * Выбор email для авторизации
 * @var array $data
 * @var FormAuthMail $model
 */

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-login-email',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnChange' => true,
    ),
));

if ($model->hasErrors()) {
    echo $form->errorSummary($model);
}
?>

<fieldset>
    <?php
    $data[0] = Yii::t('app', '--- Выберите Email аккаунт ---');
    echo $form->dropDownListRow($model, 'user_email_id', $data);
    ?>
</fieldset>

<?php
Yii::import('bootstrap.widgets.TbButton');
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Войти',
    'buttonType' => 'submit',
    'type' => 'primary',
//    'size'  => 'normal',
//    'url' => $this->createUrl('layout'),
));
$this->endWidget();


