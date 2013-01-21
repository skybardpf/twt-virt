<?php
/**
 * @var $this Admin_usersController
 * @var $dataProvider CDataProvider
 */

$this->breadcrumbs=array(
	'Пользователи',
);
$this->pageTitle = 'Пользователи';
?>
<h1><?=$this->pageTitle?></h1>

<a href="<?=$this->createUrl('create')?>">Добавить пользователя</a>

<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'template' => "{pager}\n{items}\n{pager}",
	'ajaxUpdate' => false,
	'columns' => array(
		'id',
		'email',
		'fullName',
		'phone',
		array('name' => 'active', 'type' => 'boolean'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}',
			'deleteConfirmation' => false,
//			'htmlOptions'=>array('style'=>'width: 50px'),
		),
	)
));
?>