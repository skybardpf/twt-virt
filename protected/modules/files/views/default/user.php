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
	? array('Личная папка')
	: array('Личная папка' => $this->createUrl('user',array('company_id' => $this->company->id)));
foreach ($ancestors as $ancestor) {
	if ($ancestor->lvl != 1) {
		$breadcrumbs[' '.$ancestor->name] = $this->createUrl('user',array('company_id' => $this->company->id, 'dir_id' => $ancestor->id));
	}
}
if ($dir->lvl != 1) $breadcrumbs[] = $dir->name;
$this->breadcrumbs = $breadcrumbs;
?>
<?php $this->renderPartial('create', array('new_file' => $new_file, 'new_dir' => $new_dir));?>
<div class="row-fluid">
    <div class="span10">
		<?php $this->widget('bootstrap.widgets.TbMenu', array(
		'type'=> 'pills', // '', 'tabs', 'pills' (or 'list')
		'stacked'=>false, // whether this is a stacked menu
		'items'=>array(
			array('label'=>'Папка компании', 'url' => $this->createUrl('index',array('company_id' => $this->company->id))),
			array('label'=>'Личная папка', 'url'=>$this->createUrl('user',array('company_id' => $this->company->id)), 'active'=>true),
		),
	));?>
    </div>
    <div class="span2"><div class="pull-right" style="margin-top: 25px;">
        <i class="icon-trash"></i>&nbsp;<a href="<?=$this->createUrl('user_recycle', array('company_id' => $this->company->id))?>">Личная корзина</a></div><div class="clearfix">
    </div></div>
</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
	'links' => $this->breadcrumbs,
	'homeLink' => false,
));?>

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
			<?php if ($file->is_dir) echo CHtml::link($file->name, $this->createUrl('user', array('dir_id' => $file->id, 'company_id' => $this->company->id)));
		else echo CHtml::link($file->name, $this->createUrl('get_file', array('file_id' => $file->id, 'company_id' => $this->company->id)));
			?>
		</td>
		<td><?=$file->cdate?></td>
		<td><?=$file->size_human?></td>
		<td>
            <div class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Действия<span class="caret" style="border-top: 4px solid rgb(5, 95, 255);"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a class="file_rename" data-name="<?=$file->name?>" data-link="<?=$this->createUrl('rename', array('file_id' => $file->id, 'company_id' => $this->company->id))?>" href="#"><i class="icon-pencil"></i>&nbsp;Переименовать</a></li>
                    <li><a class="file_link"   href="<?=$this->createUrl('publish_link', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-share-alt"></i>&nbsp;Временная ссылка</a></li>
                    <li><a class="file_delete" href="<?=$this->createUrl('delete', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-trash"></i>&nbsp;В корзину</a></li>
                </ul>
            </div>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'ModalWindow')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4 id="modal-header"></h4>
</div>
<div class="modal-body" id="modal-body"></div>
<div class="modal-footer" id="modal-footer"></div>
<?php $this->endWidget(); ?>
