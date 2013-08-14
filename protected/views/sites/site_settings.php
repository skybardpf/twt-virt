<h1>Настройка сайта</h1>
<br />
<a href="/sites/settings/?site_id=<?= $site_id; ?>" style='color: black;'>Настройки сайта</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/main">Главная</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/about">О компании</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/partners">Партнёры</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/services">Услуги</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/contacts">Контакты</a>
<br />
<br />
<form method='post' action='/sites/settings_save'>
	<input type='hidden' name='company_id' value='<?= $company_id; ?>' />
	<input type='hidden' name='site_id' value='<?= $site_id; ?>' />
	<input type='text' name='sitename' value='<?= $site['name']; ?>'/> - название сайта.<br />
	<input type='text' name='domain' value='<?= $site['domain']; ?>' /> - домен.<br />
	<select name='template'>
<?php foreach ($templates as $_templ) : ?>
	<option <? if($site['template'] == $_templ['id']) echo "selected"; ?> value='<?= $_templ['id']; ?>'><?= $_templ['external_name']; ?></option>
<?php endforeach ?>
	</select><br />
	<input type='checkbox' name='about' <? if($site['about'] == "yes") echo "checked"; ?> /> - О компании<br />
	<input type='checkbox' name='services' <? if($site['services'] == "yes") echo "checked"; ?> /> - Услуги<br />
	<input type='checkbox' name='partners' <? if($site['partners'] == "yes") echo "checked"; ?> /> - Партнёры<br />
	<input type='checkbox' name='contacts' <? if($site['contacts'] == "yes") echo "checked"; ?> /> - Контакты<br />
	<br />
	<input type='submit' value='Сохранить'>
</form>