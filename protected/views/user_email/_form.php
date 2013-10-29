<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 *
 * @var UsersController $this
 * @var UserEmail $model
 * @var Company $company
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
        $sites = CHtml::listData($company->sites, 'id', 'domain');
        $sites[0] = Yii::t('app', '--- Выберите площадку ---');

        echo $form->textFieldRow($model, 'login_email');
        echo $form->dropDownListRow($model, 'site_id', $sites);
//        if (!$model->isNewRecord){
//            echo $form->passwordFieldRow($model, 'old_password');
//        }
        echo $form->passwordFieldRow($model, 'password');
        echo $form->passwordFieldRow($model, 'repeat_password');
        ?>
    </fieldset>

<?php
$this->endWidget();