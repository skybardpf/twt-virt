<h1><?= $title; ?></h1>
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#add_file').live('click', function () {addFile(this)});
});

function addFile() {
	$('#add_file').before("<input type='file' name='files[]' /><br />");
}

</script>
<br />
<a href="/sites/settings/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>">Настройки сайта</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/main" <? if($kind == "main") echo " style='color: black;'" ?>>Главная</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/about" <? if($kind == "about") echo " style='color: black;'" ?>>О компании</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/partners" <? if($kind == "partners") echo " style='color: black;'" ?>>Партнёры</a> |
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/services" <? if($kind == "services") echo " style='color: black;'" ?>>Услуги</a> | 
<a href="/sites/page/company_id/<?= $company_id; ?>/site_id/<?= $site_id; ?>/kind/contacts" <? if($kind == "contacts") echo " style='color: black;'" ?>>Контакты</a>
<br />
<br />
<form method='post' action='/sites/page_save' enctype="multipart/form-data">
	<input type='hidden' name='company_id' value='<?= $company_id; ?>' />
	<input type='hidden' name='site_id' value='<?= $site_id; ?>' />
	<input type='hidden' name='kind' value='<?= $kind; ?>' />
	<input type='text' name='title_window' style='width: 450px;' value='<?= $page['title_window']; ?>' /> - заголовок окна.<br />
	<input type='text' name='title_page' style='width: 450px;' value='<?= $page['title_page']; ?>' /> - заголовок страницы.<br />
	Баннер: <input type='file' name='userfile' /><br /><br />
	<textarea name='content' style='height: 300px;'><?= $page['content']; ?></textarea>
	<br /><br />
	<? if($kind == 'main'):?>
	<div>Загрузка файлов:</div><br />
	<div> 
		<input type='file' name='files[]' /><br />
		<input id='add_file' type='button' value='+'>
	</div>
	<? endif; ?>
	<br /><br />
	<input type='submit' value='Сохранить' />
</form>