<?php
/**
 * @var $this SiteController
 * @var $companies Company[]
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Компании</h1>
Выберите компанию
<table class="table table-striped table-hover grid-view">
	<tr>
		<th>Название</th>
		<th>ИНН</th>
		<th>КПП</th>
		<th class="button-column"></th>
	</tr>
	<?php foreach ($companies as $c) : ?>
		<tr>
			<td><a href="<?=$this->createUrl('/companies/view', array('company_id' => $c->id))?>"><?=$c->name?></a></td>
			<td><?=$c->inn?></td>
			<td><?=$c->kpp?></td>
			<td class="button-column">
				<?php if ($c->admin_user_id == Yii::app()->user->id) : ?>
					<a title="Редактировать" href="<?=$this->createUrl('/companies/update', array('company_id' => $c->id))?>" rel="tooltip"><i class="icon-pencil"></i></a>
					<a title="Пометить на удаление" href="<?=$this->createUrl('/companies/delete', array('company_id' => $c->id))?>" rel="tooltip"><i class="icon-trash"></i></a>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>