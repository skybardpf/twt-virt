<?php
/* @var $this Admin_companiesController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Компании'=>array('index'),
	'Добавление',
);
$this->pageTitle = 'Добавление компании';
?>
<h1><?=$this->pageTitle?></h1>

<?php $this->renderPartial('form', array('model' => $model)) ?>