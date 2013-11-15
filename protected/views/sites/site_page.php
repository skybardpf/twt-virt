<?php
/**
 * @var string $title
 * @var string $kind
 * @var integer $site_id
 * @var array $page
 */
Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/extensions/ckeditor/ckeditor.js');

echo CHtml::tag('h3', array(), $title);
?>

<script type="text/javascript">
$(document).ready(function(){
	CKEDITOR.replace('content');
	$('#add_file').live('click', function () {addFile(this)});
});

function addFile() {
	$('#add_file').before("<input type='file' name='files[]'><br><br>");
}

</script>

<?php
echo CHtml::link(
    Yii::t('app', 'Настройки сайта'),
    $this->createUrl('settings',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id
        )
    )
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Главная'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'main',
        )
    ),
    ($kind == "main") ? array('style' => 'color: black;') : array()
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'О компании'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'about',
        )
    ),
    ($kind == "about") ? array('style' => 'color: black;') : array()
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Партнёры'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'partners',
        )
    ),
    ($kind == "partners") ? array('style' => 'color: black;') : array()
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Услуги'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'services',
        )
    ),
    ($kind == "services") ? array('style' => 'color: black;') : array()
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Контакты'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'contacts',
        )
    ),
    ($kind == "contacts") ? array('style' => 'color: black;') : array()
);
echo '<br/><br/>';

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
));
?>

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
		<?php if(!empty($page['file'])):?>
			<div style='margin: 5px 0 0 180px; font-size: 12px; font-style: italic;'>
				<div>Размеры логотипа: <br /> Ширина - не больше 840px</div>
				<img src="http://<?= $_SERVER['HTTP_HOST'].$page['file']; ?>">
			</div>
		<?php endif; ?>
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