<?php
/*
 * @var $this DefaultController
 * @var $files Files[]
 * @var $new_file Files
 * @var $dir Files
 * @var $ancestors Files[]
 * @var $links FLinks[]
 */
Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/files/assets/js/files.js'));
Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath.'/modules/files/assets/css/move.css'));
$this->widget('ext.widgets.loading.LoadingWidget');

$breadcrumbs = ($dir->lvl == 1)
	? array('Папка компании')
	: array('Папка компании' => $this->createUrl('index',array('company_id' => $this->company->id)));
foreach ($ancestors as $ancestor) {
	if ($ancestor->lvl != 1) {
		$breadcrumbs[' '.$ancestor->name] = $this->createUrl('index',array('company_id' => $this->company->id, 'dir_id' => $ancestor->id));
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
				array('label'=>'Папка компании', 'url' => $this->createUrl('index',array('company_id' => $this->company->id)), 'active'=>true),
				array('label'=>'Личная папка', 'url'=>$this->createUrl('user',array('company_id' => $this->company->id))),
			),
		));?>
	</div>
	<div class="span2"><div class="pull-right" style="margin-top: 25px;">
		<i class="icon-trash"></i>&nbsp;<a href="<?=$this->createUrl('recycle', array('company_id' => $this->company->id))?>">Корзина компании</a></div><div class="clearfix">
	</div></div>
</div>

<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
	'links' => $this->breadcrumbs,
	'homeLink' => false,
));?>
<div id="alerts_container"></div>
<?php if (!$files) :?>
	Данная директория пуста.
<?php else: ?>
<table class="table table-striped table-hover table-condensed">
	<tr>
		<th>Имя</th>
		<th>Дата создания</th>
		<th>Размер</th>
		<th>Действия</th>
		<th>Временные ссылки</th>
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
		<td>
            <div class="dropdown" data-file_id="<?=$file->id?>">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Действия<span class="caret" style="border-top: 4px solid rgb(0, 136, 204);"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a class="file_rename" data-name="<?=$file->name?>" data-link="<?=$this->createUrl('rename', array('file_id' => $file->id, 'company_id' => $this->company->id))?>" href="#"><i class="icon-pencil"></i>&nbsp;Переименовать</a></li>
                    <li><a class="file_move"   href="<?=$this->createUrl('move', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-share"></i>&nbsp;Переместить в</a></li>
                    <li><a class="file_delete" href="<?=$this->createUrl('delete', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-trash"></i>&nbsp;В корзину</a></li>
	                <li><a class="file_link"   href="<?=$this->createUrl('publish_link', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-share-alt"></i>&nbsp;Временная ссылка</a></li>
	                <?php if (isset($links[$file->id])) :?>
	                    <li><a data-action="delete_link" class="link_delete" href="<?=$this->createUrl('delete_link', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-remove"></i>&nbsp;Удалить временную ссылку</a></li>
	                <?php endif; ?>
                </ul>
            </div>
		</td>
		<td style="max-width: 20px;" data-td_file_id="<?=$file->id?>">
			<?php if (isset($links[$file->id])) :?>
				<div>
					<a class="file_link"   href="<?=$this->createUrl('publish_link', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-share-alt"></i>&nbsp;</a>
					<a data-action="delete_link" class="link_delete" href="<?=$this->createUrl('delete_link', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-remove"></i>&nbsp;</a>
				</div>
			<?php endif; ?>
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

