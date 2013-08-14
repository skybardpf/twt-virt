<?php
/**
 * User: Forgon
 * Date: 04.02.13
 *
 * @var PublishedController $this
 * @var FLinks $link
 * @var Files $dir
 */
// чтобы в хлебные крошки не включать ссылки на папки выше изначально расшаренной папки
$after_root_dir = false;
foreach ($ancestors as $ancestor) {
	if (!$after_root_dir) {
		$after_root_dir = ($link->file_id == $ancestor->id);
	}
	if ($after_root_dir && $ancestor->lvl != 1) {
		$breadcrumbs[$ancestor->name] = ($link->file_id == $ancestor->id) ? $this->createUrl('', array('key' => $link->key)): $this->createUrl('', array('key' => $link->key, 'dir_id' => $ancestor->id));
	}
}
if ($dir->lvl != 1) $breadcrumbs[] = $dir->name;
$this->breadcrumbs = $breadcrumbs;
?>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
	'links' => $this->breadcrumbs,
	'homeLink' => false,
));?>

<div><h2 class="pull-left"><?=$dir->name?></h2> <span class="muted" style="top: 23px; left: 10px; position: relative;">(доступна до <?=$link->edate?>)</span><div class="clearfix"></div></div>
<?php
$criteria = new CDbCriteria();
$criteria->order = 'is_dir DESC, name ASC';
$files = $dir->children()->findAll($criteria);
if (!$files) :?>
	Данная директория пуста.
<?php else :?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'zip-download-form',
	'type' => 'inline',
	'enableAjaxValidation' => true,
	'action' => $this->createUrl('download', array('key' => $link->key, 'dir_id' => ($link->file_id == $dir->id) ? 0 : $dir->id))
));
	// Чтобы узнать, есть ли файлы в директории возьмем последний элемент, т.к. директории сверху.
	end($files);
	$last_file = current($files);
	reset($files);
	if (!$last_file->is_dir) Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/files/assets/js/archive_select.js'));
	?>
<table class="table table-striped table-hover table-condensed">
    <tr>
        <th><?php if (!$last_file->is_dir) :?><input type="checkbox" id="zip_all"><?php endif;?></th>
        <th>Имя</th>
        <th>Дата создания</th>
        <th>Размер</th>
    </tr>
	<?php foreach ($files as $file) :?>
    <tr>
        <td><?php if (!$file->is_dir) :?><input type="checkbox" name="Files[id][]" data-flag="arch_checkbox" value="<?=$file->id?>"><?php endif;?></td>
        <td>
			<?=($file->is_dir?'<i class="icon-folder-open"></i>':'')?>
			<?php
                if ($file->is_dir) echo CHtml::link($file->name, $this->createUrl('show', array('key' => $link->key, 'dir_id' => $file->id)));
				else echo CHtml::link($file->name, $this->createUrl('download', array('key' => $link->key, 'dir_id' => ($link->file_id == $dir->id) ? 0 : $dir->id, 'file_id' => $file->id)));
			?>
        </td>
        <td><?=$file->cdate?></td>
        <td><?=$file->size_human?></td>
    </tr>
	<?php endforeach;?>
</table>
<?php if (!$last_file->is_dir) {
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=> 'Скачать в архиве',
			'disabled' => 1,
			'htmlOptions' => array('id' => 'archive_dnld_btn')
			)
		);
	} ?>
<?php $this->endWidget();?>
<?php endif;?>