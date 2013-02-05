<?php
/**
 * User: Forgon
 * Date: 04.02.13
 *
 * @var PublishedController $this
 * @var FLinks $link
 */
?>
<?php /** @var $dir Files */$dir = $link->file; ?>
<h2><?=$dir->name?></h2> Доступна до <?=$link->edate?>
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
	'action' => $this->createUrl('download', array('key' => $link->key))
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
                if ($file->is_dir) echo $file->name;
				else echo CHtml::link($file->name, $this->createUrl('download', array('key' => $link->key, 'file_id' => $file->id)));
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
			'label'=> 'Загрузить архив',
			'disabled' => 1,
			'htmlOptions' => array('id' => 'archive_dnld_btn')
			)
		);
	} ?>
<?php $this->endWidget();?>
<?php endif;?>