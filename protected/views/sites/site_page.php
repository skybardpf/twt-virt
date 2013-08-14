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
	'action'=>'/sites/page_save'
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
		<div class="controls">
			<input type='file' name='userfile' id='userfile'>
		</div>
	</div>
	<? if($kind == 'main'):?>
		<div class="control-group ">
			<label for="userfile" class="control-label">Загрузка файлов</label>
			<div class="controls">
				<input type='file' name='files[]'><br><br>
				<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'htmlOptions'=>array('id'=>'add_file'), 'type'=>'primary', 'label'=> 'Добавить ещё файл'))?>
			</div>
		</div>
	<? endif; ?>

	<textarea name='content' style='height: 300px;'><?= $page['content']; ?></textarea>
	<br>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Сохранить'))?>

<?php $this->endWidget(); ?>