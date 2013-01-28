<?php
/*
 * @var $this DefaultController
 * @var $requests SRequest[]
 * @var $r SRequest
 */
$this->widget('ext.widgets.loading.LoadingWidget');
Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/support/assets/js/project_index.js'));
Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath.'/modules/support/assets/css/support.css'));
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
		<th>Закрыт</th>
	</tr>
	<?php foreach ($requests as $r) :?>
	<tr class="request_row<?=($r->opened?'':' success')?><?=(($r->opened && $r->l_message->to_admin)?' warning':'')?>" data-prev_class="<?=($r->l_message->to_admin?' warning':'')?>" data-url="<?=$this->createUrl('/support/admin_support/view/', array('id' => $r->id));?>">
		<td><?=$r->id?></td>
		<td><?=$r->title?></td>
		<td><?=$r->l_message->cdate?></td>
		<td><?=($r->l_message->to_admin?$r->user->FullName:'Администратор')?></td>
		<td><?=$r->l_message->message?></td>
		<td><?= CHtml::checkBox(
			'closed',
			!$r->opened,
			array(
				'class'=>'admin_support_closed',
				'id' => 'support_task_'.$r->id,
				'data-link' => $this->createUrl('/support/admin_support/close_switch/', array('id' => $r->id))
			)
		);?>
		</td>
	</tr>
	<?php endforeach?>
</table>