<?php
/**
 * @var $this DefaultController
 * @var $request SRequest
 * @var $message SMessage
 */
$this->breadcrumbs = array(
	'Техническая поддержка' => $this->createUrl('/support/'),
	$request->title
);?>
<h1><?=$request->title?></h1>
<table class="table table-striped table-hover">
	<tr>
		<th>Дата</th>
		<th>Отправитель</th>
		<th>Текст сообщения</th>
	</tr>
	<?php foreach ($messages as $m) :?>
	<tr>
		<td><?=$m->cdate?></td>
		<td><?=($m->to_admin?'Вы':'Администратор')?></td>
		<td><?=$m->message?></td>
	</tr>
	<?php endforeach?>
</table>
<?php // display pagination
$this->widget('CLinkPager', array(
	'pages' => $pager,
)) ?><div class="clearfix"></div><br/>
<?php
/** @var $form TbActiveForm*/
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'support-form-form',
'type'=>'vertical',
'enableAjaxValidation'=>false,
))?>
<fieldset>
	<?=$form->textAreaRow($message, 'message', array('class'=>'span8', 'rows'=>5)); ?>
</fieldset>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Отправить сообщение'));?>
</div>
<?php $this->endWidget(); ?>