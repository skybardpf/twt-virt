<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/company'); ?>
<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'    =>'tabs', // '', 'tabs', 'pills' (or 'list')
	'stacked' =>false, // whether this is a stacked menu
	'items'   =>array(
		array('label' => 'Файлы компании',     'url' => $this->createUrl('index', $_GET), 'active' => $this->action->id == 'index'),
		array('label' => 'Файлы пользователя', 'url' => $this->createUrl('user', $_GET), 'active' => $this->action->id == 'user'),
	),
)); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
