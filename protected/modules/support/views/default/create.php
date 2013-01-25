<?php
/*
 * @var $this DefaultController
 * @var $request SRequest
 * @var $message SMessage
 */
$this->breadcrumbs=array(
	'Техническая поддержка' => $this->createUrl('/support/'),
	'Создать запрос'
);
?>
<h1>Создание запроса в техническую поддержку</h1>
<div class="form">

	<?php
	/** @var $form TbActiveForm */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'support-form-form',
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
	))?>

	<div class="form-actions">
		<?php $button = $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Создать'), true); ?>
		<?=$button?>
	</div>
	<fieldset>

		<?=$form->textFieldRow($request, 'title'); ?>
		<?=$form->textAreaRow($message, 'message', array('class'=>'span8', 'rows'=>5)); ?>
	</fieldset>
	<div class="form-actions">
		<?=$button?>
	</div>

	<?php $this->endWidget(); ?>

</div>