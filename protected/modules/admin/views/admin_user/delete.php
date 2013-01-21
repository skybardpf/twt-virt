<?php
/**
 * @var $this Admin_userController
 * @var $admin AdminUser
 */

$this->breadcrumbs=array(
	'Администраторы'=>array('/admin/admin_user'),
	$admin->login => array('view', 'id' => $admin->id),
	'Удаление',
);
$this->pageTitle = 'Удаление администратора «' . $admin->login .'»';
?>

Вы действительно хотите удалить администратора «<?=CHtml::encode($admin->login)?>»?

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'admin-delete-form',
	'type'=>'horizontal',
))?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit',
	'type'=>'danger',
	'label'=>'Да',
	'htmlOptions' => array('name' => 'result', 'value' => 'yes')
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit',
	'type'=>'success',
	'label'=>'Нет',
	'htmlOptions' => array('name' => 'result', 'value' => 'no')
)); ?>
<?php $this->endWidget(); ?>