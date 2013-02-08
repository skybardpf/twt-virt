<?php
/**
 * @var $this Admin_companiesController
 * @var $model Company
 */

Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/../static/js/select2.min.js'));
Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath.'/../static/css/select2.css'));
Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/../static/js/admin/company_update.js'));

$this->breadcrumbs=array(
	'Компании'=>array('index'),
	'Редактирование',
);
$this->pageTitle = 'Редактирование компании «' . $model->name .'»';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<?php $this->renderPartial('form', array('model' => $model)) ?>