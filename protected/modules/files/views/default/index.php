<?php
/*
 * @var $this Controller
 * @var $files Files[]
 * @var $new_file Files
 * @var $dir Files
 * @var $ancestors Files[]
 */

Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/files/assets/js/files.js'));
$this->widget('ext.widgets.loading.LoadingWidget');
$breadcrumbs = ($dir->lvl == 1)
	? array('Компания '.$this->company->name)
	: array('Компания '.$this->company->name => $this->createUrl('index',array('company_id' => $this->company->id)));
foreach ($ancestors as $ancestor) {
	if ($ancestor->lvl != 1) {
		$breadcrumbs[' '.$ancestor->name] = $this->createUrl('index',array('company_id' => $this->company->id, 'dir_id' => $ancestor->id));
	}
}
if ($dir->lvl != 1) $breadcrumbs[] = $dir->name;
$this->breadcrumbs = $breadcrumbs;
$this->renderPartial('create', array('new_file' => $new_file, 'new_dir' => $new_dir));
?>
<?php if (!$files) :?>
	Данная директория пуста.
<?php else: ?>
<table class="table table-striped table-hover table-condensed">
	<tr>
		<th>Имя</th>
		<th>Дата создания</th>
		<th>Размер</th>
		<th>Действия</th>
	</tr>
	<?php foreach ($files as $file) :?>
	<tr>
		<td>
			<?=($file->is_dir?'<i class="icon-folder-open"></i>':'')?>
			<?php if ($file->is_dir) echo CHtml::link($file->name, $this->createUrl('index', array('dir_id' => $file->id, 'company_id' => $this->company->id)));
			else echo CHtml::link($file->name, $this->createUrl('get_file', array('file_id' => $file->id, 'company_id' => $this->company->id)));
			?>
		</td>
		<td><?=$file->cdate?></td>
		<td><?=$file->size_human?></td>
		<td><a class="file_rename" data-name="<?=$file->name?>" href="<?=$this->createUrl('rename', array('file_id' => $file->id))?>"><i class="icon-pencil"></i></a></td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>