<?php
/**
 * @var UsersController $this
 * @var User $user
 */
?>

<h3><?= CHtml::encode($this->pageTitle) ?></h3>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $user,
    'attributes' => array(
        'email',
        'fullName',
        'phone',
    ),
)); ?>

<div class="form-actions">
    <a href="<?= $this->createUrl('profile_edit') ?>" class="btn">Редактировать</a>
    <a href="<?= $this->createUrl('change_pass') ?>" class="btn">Сменить пароль</a>
</div>
