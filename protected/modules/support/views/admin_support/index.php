<?php
/*
 * @var $this DefaultController
 * @var $requests SRequest[]
 * @var $r SRequest
 */

Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/support/assets/js/project_index.js'));
$this->breadcrumbs=array('Техническая поддержка');
?>
<h1>Техническая поддержка</h1>
<table class="table table-striped table-hover">
	<tr>
		<th>#</th>
		<th>Заголовок</th>
		<th>Дата сообщения</th>
		<th>Отправитель сообщения</th>
		<th>Текст сообщения</th>
		<th>Статус</th>
		<th></th>
	</tr>
	<?php foreach ($requests as $r) :?>
	<tr class="request_row<?=($r->opened?'':' success')?><?=(($r->opened && $r->l_message->to_admin)?' warning':'')?>" data-url="<?=$this->createUrl('/support/admin_support/view/', array('id' => $r->id));?>">
		<td><?=$r->id?></td>
		<td><?=$r->title?></td>
		<td><?=$r->l_message->cdate?></td>
		<td><?=($r->l_message->to_admin?$r->user->FullName:'Администратор')?></td>
		<td><?=$r->l_message->message?></td>
		<td><?php
			if ($r->opened) {
				echo 'Открыт&nbsp;<a href="'.$this->createUrl('/support/admin_support/close/', array('id' => $r->id)).'" class="icon-ok admin_support_close" title="Закрыть"></a>';
			} else echo 'Закрыт';?>
		</td>
	</tr>
	<?php endforeach?>
</table>