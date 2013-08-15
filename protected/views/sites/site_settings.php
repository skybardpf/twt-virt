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

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'type'=>'horizontal',
	'action'=>'/sites/settings_save'
)); ?>

	<input type='hidden' name='company_id' value='<?= $company_id; ?>'>
	<input type='hidden' name='site_id' value='<?= $site_id; ?>'>


	<div class="control-group ">
		<label for="sitename" class="control-label required">Название сайта <span class="required">*</span></label>
		<div class="controls">
			<input type='text' name='sitename' id='sitename' value='<?= $site['name']; ?>'>
		</div>
	</div>
	<div class="control-group ">
		<label for="domain" class="control-label required">Домен <span class="required">*</span></label>
		<div class="controls">
			<input type='text' name='domain' id='domain' value='<?= $site['domain']; ?>'>
		</div>
	</div>
	<div class="control-group ">
		<label for="template" class="control-label required">Шаблон <span class="required">*</span></label>
		<div class="controls">
			<select name='template' id="template">
				<?php foreach ($templates as $_templ) : ?>
					<option <? if($site['template'] == $_templ['id']) echo "selected"; ?> value='<?= $_templ['id']; ?>'><?= $_templ['external_name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="control-group ">
		<label for="about" class="control-label">О компании</label>
		<div class="controls">
			<input type='checkbox' name='about' id='about' <? if($site['about'] == "yes") echo "checked"; ?>>
		</div>
	</div>
	<div class="control-group ">
		<label for="services" class="control-label">Услуги</label>
		<div class="controls">
			<input type='checkbox' name='services' id='services' <? if($site['services'] == "yes") echo "checked"; ?>>
		</div>
	</div>
	<div class="control-group ">
		<label for="partners" class="control-label">Партнёры</label>
		<div class="controls">
			<input type='checkbox' name='partners' id='partners' <? if($site['partners'] == "yes") echo "checked"; ?>>
		</div>
	</div>
	<div class="control-group ">
		<label for="contacts" class="control-label">Контакты</label>
		<div class="controls">
			<input type='checkbox' name='contacts' id='contacts' <? if($site['contacts'] == "yes") echo "checked"; ?>>
		</div>
	</div>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Сохранить'))?>

<?php $this->endWidget(); ?>