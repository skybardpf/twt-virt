<?php
/**
 * @var $this Admin_userController
 * @var $data AdminUser
 */
?>
<h3>
	<a href="<?=$this->createUrl('delete', array('id' => $data->id))?>" title="удалить" class="btn btn-mini btn-danger">
		<i class="icon-remove"></i>
	</a>
	<a href="<?=$this->createUrl('change_password', array('id' => $data->id))?>" title="сменить пароль" class="btn btn-mini">
		<i class="icon-lock"></i>
	</a>
	<a href="<?=$this->createUrl('update', array('id' => $data->id))?>" title="редактировать" class="btn btn-mini">
		<i class="icon-edit"></i>
	</a>
	<?php $this->createUrl('view', array('id' => $data->id)) ?>
	<?=CHtml::mailto($data->login, $data->email)?>
	<?php
	if ($data->block) {
		$this->widget('bootstrap.widgets.TbLabel', array(
			'type'=>'important', // 'success', 'warning', 'important', 'info' or 'inverse'
			'label'=>'Заблокирован',
		));
	}
	?>
</h3>
