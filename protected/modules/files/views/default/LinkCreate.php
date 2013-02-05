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
		<label><input type="radio" name="FLinks[duration]" value="3600" checked="checked"> на 1 час</label><br/>
		<label><input type="radio" name="FLinks[duration]" value="10800"> на 3 часа</label><br/>
		<label><input type="radio" name="FLinks[duration]" value="21600"> на 6 часов</label><br/>
		<label><input type="radio" name="FLinks[duration]" value="43200"> на 12 часов</label><br/>
		<label><input type="radio" name="FLinks[duration]" value="86400"> на 24 часа</label>
	</fieldset>
<?php $this->endWidget();?>