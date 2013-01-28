<?php
/*
 * @var $this Controller
 * @var $files Files[]
 * @var $new_file Files
 * @var $dir Files
 * @var $ancestors Files[]
 */
$this->breadcrumbs = array(
	'Компания '.$this->company->name => $this->createUrl('/companies/view',array('company_id' => $this->company->id)),
	'Файлы'
);
$this->renderPartial('create', array('new_file' => $new_file, 'new_dir' => $new_dir));
?>
<div class="breadcrumbs breadcrumb">
	<?php
	echo CHtml::link($this->company->name, $this->createUrl('index',array('company_id' => $this->company->id))).' :/ ';
	foreach ($ancestors as $ancestor) {
		if ($ancestor->lvl != 1) {
			echo CHtml::link($ancestor->name, $this->createUrl('index',array('company_id' => $this->company->id, 'dir_id' => $ancestor->id))).' / ';
		}
	}
	echo ($dir->lvl != 1 ? $dir->name.' / ' : '')?>
</div>
<?php if (!$files) :?>
	Данная директория пуста.
<?php else: ?>
<table class="table table-striped table-hover table-condensed">
	<tr>
		<th>Имя</th>
		<th>Дата</th>
		<th>Размер</th>
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
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>