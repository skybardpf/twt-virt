<?php
/**
 * @var $this Admin_usersController
 * @var $model User
 */

$this->breadcrumbs=array(
	'Пользователи' => array('index'),
	'Удаление',
);
$this->pageTitle = 'Удаление пользователя «' . $model->name . ' ' . $model->surname .'»';
?>

Вы действительно хотите удалить пользователя «<?=CHtml::encode($model->name . ' ' . $model->surname)?>»?

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'news-delete-form',
	'type'=>'horizontal',
))?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit',
	'type'=>'danger',
	'label'=>'Да',
	'htmlOptions' => array('name' => 'result', 'value' => 'yes')
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit',
	'type'=>'success',
	'label'=>'Нет',
	'htmlOptions' => array('name' => 'result', 'value' => 'no')
)); ?>
<?php $this->endWidget(); ?>