<?php
/**
 * @var $this SitesController
 * @var $companies Company[]
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Список сайтов</h1>

<div style='display: inline-block; width: 250px;'>Название сайта</div>
<div style='display: inline-block; width: 250px;'>Домен</div>
<div style='display: inline-block; width: 150px;'>Шаблон</div>
<br /><br />
<?php foreach ($sites as $_site) : ?>
	<div style='display: inline-block; width: 250px;'><a href="/sites/settings/company_id/<?= $company_id; ?>/site_id/<?= $_site['site_id'] ?>"><?= $_site['name']; ?></a></div>
	<div style='display: inline-block; width: 250px;'><?= $_site['domain']; ?></div>
	<div style='display: inline-block; width: 150px;'><?= $_site['template']; ?></div>
	<br />
<?php endforeach ?>
<br />
<a href='/sites/createform/company_id/<?= $company_id; ?>'>Создать сайт</a>
