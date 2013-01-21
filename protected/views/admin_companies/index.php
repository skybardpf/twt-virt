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
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}',
			'deleteConfirmation' => false,
		),
	)
));
?>