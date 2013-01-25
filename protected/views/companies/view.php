<?php
/**
 * @var $this CompaniesController
 * @var $company Company
 */

$this->breadcrumbs=array(
	'Компания '.$company->name,
);
$this->pageTitle = 'Компания '.$company->name;
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false, // whether this is a stacked menu
	'items'=>array(
		array('label'=>'Файлы', 'url'=>$this->createUrl('/site/files', array('company_id' => $company->id))),
		array('label'=>'Почта', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Телефония', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Сайт', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$company,
	'attributes'=>array(
		'inn',
		'kpp',
	),
)); ?>