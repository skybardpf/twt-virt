<?php
/**
 * @var $this SitesController
 * @var $companies Company[]
*/

$this->pageTitle=Yii::app()->name;
?>

<h1>Создание сайта</h1>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'type'=>'horizontal',
//	'action'=>'/sites/create'
)); ?>

	<input type='hidden' name='company_id' value='<?= $company_id; ?>'>

	<div class="control-group ">
	<?php if(isset($errors['sitename'])):?>
	<div style='color: red; margin-left: 190px; font-size: 12px;'>
		<i><?= $errors['sitename']; ?></i>
	</div>
	<?php endif; ?>
		<label for="sitename" class="control-label required">Название сайта <span class="required">*</span></label>
		<div class="controls">
			<input type='text' name='sitename' id='sitename' value='<?= $page['sitename']; ?>'>
		</div>
	</div>
	<div class="control-group ">
	<?php if(isset($errors['domain'])):?>
	<div style='color: red; margin-left: 190px; font-size: 12px;'>
		<i><?= $errors['domain']; ?></i>
	</div>
	<?php endif; ?>
		<label for="domain" class="control-label required">Домен <span class="required">*</span></label>
		<div class="controls">
			<input type='text' name='domain' id='domain' value='<?= $page['domain']; ?>'>
		</div>
	</div>
	<div class="control-group ">
		<label for="template" class="control-label required">Шаблон <span class="required">*</span></label>
		<div class="controls">
			<select name='template' id="template">
				<?php foreach ($templates as $_templ) : ?>
					<option <?php if($page['template'] == $_templ['id']) echo "selected"; ?> value='<?= $_templ['id']; ?>'><?= $_templ['external_name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="control-group ">
		<label for="about" class="control-label">О компании</label>
		<div class="controls">
			<input type='checkbox' name='about' id='about' <?php if(isset($page['about'])) echo "checked"; ?>>
		</div>
	</div>
	<div class="control-group ">
		<label for="services" class="control-label">Услуги</label>
		<div class="controls">
			<input type='checkbox' name='services' id='services' <?php if(isset($page['services'])) echo "checked"; ?>>
		</div>
	</div>
	<div class="control-group ">
		<label for="partners" class="control-label">Партнёры</label>
		<div class="controls">
			<input type='checkbox' name='partners' id='partners' <?php if(isset($page['partners'])) echo "checked"; ?>>
		</div>
	</div>
	<div class="control-group ">
		<label for="contacts" class="control-label">Контакты</label>
		<div class="controls">
			<input type='checkbox' name='contacts' id='contacts' <?php if(isset($page['contacts'])) echo "checked"; ?>>
		</div>
	</div>
	<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=> 'Сохранить'
    )
);
?>

<?php $this->endWidget(); ?>