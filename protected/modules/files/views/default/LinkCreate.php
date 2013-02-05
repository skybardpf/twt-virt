<?php
/**
 * User: Forgon
 * Date: 04.02.13
 *
 * @var DefaultController $this
 */
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'link-create-form',
	'type' => 'inline',
	'enableAjaxValidation' => false,
))?>
	<fieldset>
		<?=$form->radioButtonListInlineRow($model, 'duration', $model->getDurationValues())?>
	</fieldset>
<?php $this->endWidget();?>