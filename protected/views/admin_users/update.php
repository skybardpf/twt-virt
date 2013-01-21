<?php
/**
 * @var $this Admin_usersController
 * @var $model User
 */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Редактирование',
);
$this->pageTitle = 'Редактирование пользователя «' . $model->name . ' ' . $model->surname .'»';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<?php $this->renderPartial('form', array('model' => $model)) ?>