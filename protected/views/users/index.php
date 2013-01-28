<?php
/**
 * @var $this UsersController
 * @var $users User[]
 */

$this->breadcrumbs=array(
	'Пользователи',
);
$this->pageTitle = 'Пользователи';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>
<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
	'dataProvider' => new CArrayDataProvider($users),
	'template' => "{pager}\n{items}\n{pager}",
	'ajaxUpdate' => false,
	'columns' => array(
		array('name' => 'E-Mail', 'value' => '$data->email'),
		array('name' => 'Полное имя', 'value' => '$data->fullName'),
		array('name' => 'Телефон', 'value' => '$data->phone'),
		array('name' => 'Активный', 'value' => '$data->active ? "Да" : "Нет"'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update}',
			'deleteConfirmation' => false,
		),
	)
));
?>

<a href="<?=$this->createUrl('create')?>" class="btn btn-info">Добавить пользователя</a>