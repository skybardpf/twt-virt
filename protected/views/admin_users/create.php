<?php
/* @var $this Admin_usersController */
/* @var $model User */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Добавление',
);
$this->pageTitle = 'Добавление пользователя';
?>
<h1><?=$this->pageTitle?></h1>

<?php $this->renderPartial('form', array('model' => $model)) ?>