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
		<th>Название</th>
		<th>Почта</th>
		<th>Телефония</th>
		<th>Сайты</th>
		<th>Файлы</th>
		<th class="button-column"></th>
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
			<td>53 письма / 3 непрочитанных</td>
			<td>10 звонков / 1 неотвеченный</td>
			<td>0 / 2</td>
			<td>Занято 2,3 Гб / 6 Гб</td>
			<td class="button-column">
				<?php if ($c->admin_user_id == Yii::app()->user->id) : ?>
					<?php if ($c->deleted) :
					?>
						<a title="Компания помечена на удаление <?=Yii::app()->dateFormatter->formatDateTime($c->deleted_date)?>" rel="tooltip"><i class="icon-pencil icon-white"></i></a>
						<a title="Компания помечена на удаление <?=Yii::app()->dateFormatter->formatDateTime($c->deleted_date)?>" rel="tooltip"><i class="icon-trash icon-white"></i></a>
					<?php else : ?>
						<a title="Редактировать" href="<?=$this->createUrl('/companies/update', array('company_id' => $c->id))?>" rel="tooltip"><i class="icon-pencil"></i></a>
						<a title="Пометить на удаление" href="<?=$this->createUrl('/companies/delete', array('company_id' => $c->id))?>" rel="tooltip"><i class="icon-trash"></i></a>
					<?php endif ?>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>