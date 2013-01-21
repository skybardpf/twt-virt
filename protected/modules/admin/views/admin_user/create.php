<?php
/* @var $this Admin_userController */

$this->breadcrumbs=array(
	'Администраторы'=>array('/admin/admin_user'),
	'Добавление',
);
$this->pageTitle = 'Добавление администратора';
?>

<?php $this->renderPartial('form', array('admin' => $admin)) ?>