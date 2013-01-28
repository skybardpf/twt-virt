<?php
/*
 * @var $this DefaultController
 * @var $requests SRequest[]
 * @var $r SRequest
 */

Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/support/assets/js/project_index.js'));
Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath.'/modules/support/assets/css/support.css'));
$this->breadcrumbs=array('Техническая поддержка');
?>
<h1>Техническая поддержка</h1>
<a class="btn btn-success" href="<?=$this->createUrl('/support/create/')?>">Создать запрос</a>
<table class="table table-striped table-hover">
	<tr>
		<th>#</th>
		<th>Заголовок</th>
		<th>Дата сообщения</th>
		<th>Отправитель сообщения</th>
		<th>Текст сообщения</th>
		<th>Статус</th>
	</tr>
	<?php foreach ($requests as $r) :?>
	<tr class="request_row<?=($r->opened?'':' success')?><?=(($r->opened && !$r->l_message->to_admin)?' warning':'')?>" data-url="<?=$this->createUrl('/support/default/view/', array('id' => $r->id));?>">
		<td><?=$r->id?></td>
		<td><?=$r->title?></td>
		<td><?=$r->l_message->cdate?></td>
		<td><?=($r->l_message->to_admin?'Вы':'Администратор')?></td>
		<td><?=$r->l_message->message?></td>
		<td><?=($r->opened?'Открыт':'Закрыт')?></td>
	</tr>
	<?php endforeach?>
</table>