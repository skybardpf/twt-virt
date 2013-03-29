<?php
/**
 * User: Forgon
 * Date: 05.02.13
 */
/** @var $this DefaultController */
/** @var $ancestors Files[] */

Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::app()->basePath.'/modules/files/assets/js/recycle.js'));
$this->widget('ext.widgets.loading.LoadingWidget');
$breadcrumbs = ($dir->lvl == 1)
	? array(
		'Папка компании' => $this->createUrl('index',array('company_id' => $this->company->id)),
		'Корзина'
	)
	: array(
		'Папка компании' => $this->createUrl('index',array('company_id' => $this->company->id)),
		'Корзина' => $this->createUrl('recycle',array('company_id' => $this->company->id)),
	);
foreach ($ancestors as $ancestor) {
	if ($ancestor->lvl != 1) {
		$breadcrumbs[' '.$ancestor->name] = $this->createUrl('recycle',array('company_id' => $this->company->id, 'dir_id' => $ancestor->id));
	}
}
if ($dir->lvl != 1) $breadcrumbs[] = $dir->name;
$this->breadcrumbs = $breadcrumbs;
?>
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
	<?php if ($this->company->isAdmin(Yii::app()->user->id)) :?>
	<div class="span2"><div class="pull-right" style="margin-top: 25px;">
		<i class="icon-remove-circle"></i>&nbsp;<a id="recycle_remove_all" data-recycle="<?=$this->createUrl('recycle', array('company_id' => $this->company->id))?>" href="<?=$this->createUrl('remove_all', array('company_id' => $this->company->id, 'user_dir' => false))?>">Очистить корзину</a></div><div class="clearfix">
	</div></div>
	<?php endif; ?>
</div>

<?php
$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
	'links' => $this->breadcrumbs,
	'homeLink' => false,
));
?>
<?php if (!$files) :?>
	Данная директория пуста.
<?php else: ?>
<table class="table table-striped table-hover table-condensed">
    <tr>
        <th>Имя</th>
        <th>Дата создания</th>
        <th>Дата перемещения в корзину</th>
        <th>Размер</th>
        <th>Действия</th>
    </tr>
	<?php foreach ($files as $file) :?>
    <tr>
        <td>
			<?=($file->is_dir?'<i class="icon-folder-open"></i>':'')?>
			<?php if ($file->is_dir) echo CHtml::link($file->name, $this->createUrl('recycle', array('dir_id' => $file->id, 'company_id' => $this->company->id)));
				else echo $file->name;
			?>
        </td>
        <td><?=$file->cdate?></td>
        <td><?=$file->deldate?></td>
        <td><?=$file->size_human?></td>
        <td>
            <div class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Действия<span class="caret" style="border-top: 4px solid rgb(0, 136, 204);"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a class="recycle_restore" href="<?=$this->createUrl('restore', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-arrow-up"></i>&nbsp;Восстановить</a></li>
                </ul>
            </div>
        </td>
    </tr>
	<?php endforeach;?>
</table>
<?php endif;?>
