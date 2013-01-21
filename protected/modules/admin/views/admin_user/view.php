<?php
/**
 * @var $this Admin_userController
 * @var $admin AdminUser
 */

$this->breadcrumbs=array(
	'Администраторы' => array('/admin/admin_user'),
	$admin->login
);
$this->pageTitle = $admin->login;
?>
<h1>
	<?=CHtml::encode($admin->login)?>
	<?php
	if ($admin->block) {
		$this->widget('bootstrap.widgets.TbLabel', array(
			'type'=>'important', // 'success', 'warning', 'important', 'info' or 'inverse'
			'label'=>'Заблокирован',
		));
	}
	?>
</h1>
<?=CHtml::mailto($admin->email, $admin->email)?>