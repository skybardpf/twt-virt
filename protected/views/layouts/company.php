<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/column1'); ?>
<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false, // whether this is a stacked menu
	'items'=>array(
		array('label'=>'Файлы', 'url'=>$this->createUrl('', $_GET), 'active'=>true),
		array('label'=>'Почта', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Телефония', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Сайт', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
	),
)); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
