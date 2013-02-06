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
		' '.$this->company->name => $this->createUrl('index',array('company_id' => $this->company->id)),
		'Корзина'
	)
	: array(
		' '.$this->company->name => $this->createUrl('index',array('company_id' => $this->company->id)),
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
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Действия<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a class="recycle_restore" href="<?=$this->createUrl('restore', array('file_id' => $file->id, 'company_id' => $this->company->id))?>"><i class="icon-arrow-up"></i>&nbsp;Восстановить</a></li>
                </ul>
            </div>
        </td>
    </tr>
	<?php endforeach;?>
</table>
<?php endif;?>
