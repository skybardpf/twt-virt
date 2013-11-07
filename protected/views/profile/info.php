<?php
/**
 * @var ProfileController $this
 * @var User $user
 */
?>

<h3><?= CHtml::encode(Yii::t('app', 'Личные данные')); ?></h3>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $user,
    'attributes' => array(
        'email',
        'fullName',
        'phone',
    ),
)); ?>

<div class="form-actions">
    <a href="<?= $this->createUrl('update') ?>" class="btn"><?= Yii::t('app', 'Редактировать'); ?></a>
    <a href="<?= $this->createUrl('change_pass') ?>" class="btn"><?= Yii::t('app', 'Сменить пароль'); ?></a>
</div>
