<?php
/**
 * @var $this Admin_userController
 * @var $adminsDataProvider CDataProvider
 */

$this->breadcrumbs = array('Администраторы');
$this->pageTitle = 'Администраторы';
?>
<h1>Администраторы</h1>

<?php if (!Yii::app()->admin->isGuest): ?>
	<a href="<?=$this->createUrl('create')?>">Добавить администратора</a>
<?php endif ?>

<?php
$this->widget('ext.bootstrap.widgets.TbListView', array(
	'dataProvider' => $adminsDataProvider,
	'itemView' => 'show_index_item',
	'separator' => '<hr>',
	'template' => "{pager}\n{items}\n{pager}",
	'ajaxUpdate' => false
));
?>