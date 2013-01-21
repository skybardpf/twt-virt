<?php
/**
 * @var $this Admin_companiesController
 * @var $model Company
 */

$this->breadcrumbs=array(
	'Компании'=>array('index'),
	'Редактирование',
);
$this->pageTitle = 'Редактирование компании «' . $model->name .'»';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<?php $this->renderPartial('form', array('model' => $model)) ?>