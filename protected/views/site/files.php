<?php
/**
 * @var $this SiteController
 * @var $company Company
 */
?>
<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false, // whether this is a stacked menu
	'items'=>array(
		array('label'=>'Файлы', 'url'=>$this->createUrl('', $_GET), 'active'=>true),
		array('label'=>'Почта', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Телефония', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Сайт', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
	),
)); ?>

<table class="table table-striped table-hover table-condensed">
	<tr>
		<th>Имя</th>
		<th>Дата</th>
		<th>Размер</th>
	</tr>
	<tr>
		<td>Договор №123</td>
		<td>20 января 2013</td>
		<td>256 КБ</td>
	</tr>
	<tr>
		<td>Договор №564</td>
		<td>20 декабря 2012</td>
		<td>652 КБ</td>
	</tr>
	<tr>
		<td>Счет №548</td>
		<td>22 декабря 2012</td>
		<td>898 КБ</td>
	</tr>
	<tr>
		<td>Акт №87</td>
		<td>24 ноября 2012</td>
		<td>566 КБ</td>
	</tr>
</table>