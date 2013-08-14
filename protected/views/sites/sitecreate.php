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
	<input type='hidden' name='company_id' value='<?= $company_id; ?>' />
	<input type='text' name='sitename' value='<?= $page['sitename']; ?>'/> - название сайта.<br />
	<input type='text' name='domain' value='<?= $page['domain']; ?>' /> - домен.<br />
	<select name='template'>
<?php foreach ($templates as $_templ) : ?>
	<option <? if($page['template'] == $_templ['id']) echo "selected"; ?> value='<?= $_templ['id']; ?>'><?= $_templ['external_name']; ?></option>
<?php endforeach ?>
	</select><br />
	<input type='checkbox' name='about' <? if($page['about'] == "yes") echo "checked"; ?> /> - О компании<br />
	<input type='checkbox' name='services' <? if($page['services'] == "yes") echo "checked"; ?> /> - Услуги<br />
	<input type='checkbox' name='partners' <? if($page['partners'] == "yes") echo "checked"; ?> /> - Партнёры<br />
	<input type='checkbox' name='contacts' <? if($page['contacts'] == "yes") echo "checked"; ?> /> - Контакты<br />
	<br />
	<input type='submit' value='Сохранить'>
</form>