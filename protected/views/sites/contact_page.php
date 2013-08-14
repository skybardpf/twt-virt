<h1><?= $title; ?></h1>
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>
<br />
<a href="/sites/settings/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>">Настройки сайта</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/main">Главная</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/about">О компании</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/partners">Партнёры</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/services">Услуги</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/contacts" style='color: black;'>Контакты</a>
<br />
<br />
<form method='post' action='/sites/page_save'>
	<input type='hidden' name='company_id' value='<?= $company_id; ?>' />
	<input type='hidden' name='site_id' value='<?= $site_id; ?>' />
	<input type='hidden' name='kind' value='<?= $kind; ?>' />
	<input type='text' name='title_window' style='width: 450px;' value='<?= $page['title_window']; ?>' /> - заголовок окна.<br />
	<input type='text' name='title_page' style='width: 450px;' value='<?= $page['title_page']; ?>' /> - заголовок страницы.<br /><br />
		<select name='map'>
		<option <? if($page['map'] == "google") echo "selected"; ?> value='google'>Google</option>
		<option <? if($page['map'] == "yandex") echo "selected"; ?> value='yandex'>Yandex</option>
	</select><br />
	<input type='text' name='address' style='width: 450px;' value='<?= $page['address']; ?>' /> - адрес.<br /><br />
	<textarea name='content' style='height: 300px;'><?= $page['content']; ?></textarea>
	<br />
	<input type='submit' value='Сохранить' />
</form>