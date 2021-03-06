<?php
/**
 * @var UsersController $this
 * @var User $user
 */
?>
<h3><?= CHtml::encode(Yii::t('app', 'Смена пароля')); ?></h3>

<div class="form">

    <?php /**
     * @var TbActiveForm $form
     */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'model-form-form',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,

    ));
    $buttons = $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => Yii::t('app', 'Сохранить'),
            ), true
        ) . '&nbsp';
    $buttons .= $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'label' => Yii::t('app', 'Отмена'),
            'url' => $this->createUrl('index')
        ), true
    );
    ?>

    <?php echo $form->errorSummary($user); ?>
    <div class="form-actions">
        <?= $buttons ?>
    </div>
    <fieldset>
        <?= $form->passwordFieldRow($user, 'old_password', array('class' => 'input-xxlarge')) ?>
        <?= $form->passwordFieldRow($user, 'password', array('class' => 'input-xxlarge')) ?>
        <?= $form->passwordFieldRow($user, 'repassword', array('class' => 'input-xxlarge')) ?>
    </fieldset>
    <div class="form-actions">
        <?= $buttons ?>
    </div>

    <?php $this->endWidget(); ?>

</div>