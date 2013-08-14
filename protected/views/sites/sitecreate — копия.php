<?php
/**
 * @var $this SitesController
 * @var $companies Company[]
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Создание сайта</h1>
<br />
<form method='post' action='/sites/create'>
	<input type='text' name='sitename' /> - название сайта.<br />
	<input type='text' name='domain' /> - домен.<br />
	<select name='template'>
<?php foreach ($templates as $_templ) : ?>
	<option value='<?= $_templ['id']; ?>'><?= $_templ['external_name']; ?></option>
<?php endforeach ?>
	</select><br />
	<input type='hidden' name='company_id' value='<?= $company_id; ?>' />
	<input type='checkbox' name='about'/> - О компании<br />
	<input type='checkbox' name='services'/> - Услуги<br />
	<input type='checkbox' name='partners'/> - Партнёры<br />
	<input type='checkbox' name='contacts'/> - Контакты<br />
	<br />
	<input type='submit' value='Создать'>
</form>