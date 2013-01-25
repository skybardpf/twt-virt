<?php
/**
 * @var $this Admin_companiesController
 * @var $dataProvider CDataProvider
 */

$this->breadcrumbs=array(
	'Компании',
);
$this->pageTitle = 'Компании';
?>
<h1><?=$this->pageTitle?></h1>

<a href="<?=$this->createUrl('create')?>">Добавить компанию</a>

<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'template' => "{pager}\n{items}\n{pager}",
	'ajaxUpdate' => false,
	'columns' => array(
		'id',
		'name',
		'inn',
		'kpp',
		array('name' => 'deleted', 'value' => '$data->deleted ? "Да" : "Нет"'),
		array('name' => 'deleted_date', 'value' => 'Yii::app()->dateFormatter->formatDateTime($data->deleted_date)'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}',
			'deleteConfirmation' => false,
		),
	)
));
?>