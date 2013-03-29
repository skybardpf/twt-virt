<?php
/**
 * @var $this SiteController
 * @var $companies Company[]
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Компании</h1>
<table class="table table-striped table-hover grid-view companies">
	<tr>
		<th class="name">Название</th>
		<th>Роль</th>
		<th>Почта</th>
		<th>Телефония</th>
		<th>Сайты</th>
		<th>Файлы</th>
	</tr>
	<?php foreach ($companies as $c) : ?>
		<tr class="<?=$c->deleted ? 'muted' : ''?>">
			<td>
				<a
					href="<?=$this->createUrl('/files/default/index', array('company_id' => $c->id)) /* /companies/view */?>"
					<?php if ($c->deleted) : ?>
					    class="deleted"
					    rel="tooltip"
					    title="Компания помечена на удаление <?=Yii::app()->dateFormatter->formatDateTime($c->deleted_date)?>"
					<?php endif ?>
				><?=$c->name?></a>
			</td>
			<td><?=$c->isAdmin(Yii::app()->user->id) ? 'Администратор' : 'Пользователь'?></td>
			<td>3 /53</td>
			<td>1 / 10</td>
			<td>0 / 2</td>
			<td><?=$c->getF_qoute_view()?></td>
		</tr>
	<?php endforeach ?>
</table>