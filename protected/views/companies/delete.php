<?php
/**
 * @var $this CompaniesController
 * @var $company Company
 */

$this->breadcrumbs=array(
	'Компания «' . $company->name .'»' => $this->createUrl('/companies/view', array('company_id' => $company->id)),
	'Удаление',
);
$this->pageTitle = 'Удаление компании «' . $company->name .'»';
?>

Вы действительно хотите пометить на удаление компанию «<?=CHtml::encode($company->name)?>»?

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