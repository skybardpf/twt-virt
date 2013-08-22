<h1><?= $title; ?></h1>
<script src="/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
mode : "textareas",
theme : "modern",
plugins : "table,save,image",
theme_advanced_buttons1_add_before : "save,separator",
theme_advanced_buttons1_add : "fontselect,fontsizeselect",
theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
theme_advanced_buttons3_add_before : "tablecontrols,separator",
theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_path_location : "bottom",
plugin_insertdate_dateFormat : "%Y-%m-%d",
plugin_insertdate_timeFormat : "%H:%M:%S",
extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
external_link_list_url : "example_data/example_link_list.js",
external_image_list_url : "example_data/example_image_list.js",
flash_external_list_url : "example_data/example_flash_list.js"
});
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
        //tinymce.init({selector:'textarea'});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#add_file').live('click', function () {addFile(this)});
});

function addFile() {
	$('#add_file').before("<input type='file' name='files[]'><br><br>");
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

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'type'=>'horizontal',
	'action'=>'/sites/page_save',
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>

	<input type='hidden' name='company_id' value='<?= $company_id; ?>' />
	<input type='hidden' name='site_id' value='<?= $site_id; ?>' />
	<input type='hidden' name='kind' value='<?= $kind; ?>' />

	<div class="control-group ">
		<label for="title_window" class="control-label required">Заголовок окна <span class="required">*</span></label>
		<div class="controls">
			<input type='text' name='title_window' id='title_window' value='<?= $page['title_window']; ?>'>
		</div>
	</div>
	<div class="control-group ">
		<label for="title_page" class="control-label required">Заголовок страницы <span class="required">*</span></label>
		<div class="controls">
			<input type='text' name='title_page' id='title_page' value='<?= $page['title_page']; ?>'>
		</div>
	</div>
	<div class="control-group ">
		<label for="userfile" class="control-label">Баннер</label>
		<? if(!empty($page['file'])):?>
			<div style='margin: 5px 0 0 180px; font-size: 12px; font-style: italic;'>
				<div>Размеры логотипа: <br /> Ширина - не больше 840px</div>
				<img src="http://<?= $_SERVER['HTTP_HOST'].$page['file']; ?>">
			</div>
		<? endif; ?>
		<div class="controls">
			<input type='file' name='userfile' id='userfile'>
		</div>
	</div>
	<div class="control-group ">
		<label for="userfile" class="control-label">Загрузка файлов</label>
		<?php foreach ($page['files'] as $_file) : ?>
			<a style='margin-left: 20px;' href='<?= $_file['file']; ?>'><?= $_file['file']; ?></a><br />
		<?php endforeach ?>
		<div class="controls">
			<input type='file' name='files[]'><br><br>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'htmlOptions'=>array('id'=>'add_file'), 'type'=>'primary', 'label'=> 'Добавить ещё файл'))?>
		</div>
	</div>
	<textarea name='content' style='height: 300px;'><?= $page['content']; ?></textarea>
	<br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Сохранить'))?>

<?php $this->endWidget(); ?>