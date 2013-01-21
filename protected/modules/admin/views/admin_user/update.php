<?php
/**
 * @var $this Admin_userController
 * @var $admin AdminUser
 */

$this->breadcrumbs=array(
	'Администраторы'=>array('/admin/admin_user'),
	$admin->login => array('view', 'id' => $admin->id),
	'Редактирование',
);
?>
<?php $this->renderPartial('form', array('admin' => $admin)) ?>