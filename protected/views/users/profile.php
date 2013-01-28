<?php
/**
 * @var $this UsersController
 * @var $user User
 */

$this->breadcrumbs=array(
	'Профиль'
);
$this->pageTitle = 'Профиль';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$user,
	'attributes'=>array(
		'email',
		'fullName',
		'phone',
	),
)); ?>

<div class="form-actions">
	<a href="<?=$this->createUrl('profile_edit')?>" class="btn">Редактировать</a>
	<a href="<?=$this->createUrl('change_pass')?>" class="btn">Сменить пароль</a>
</div>
