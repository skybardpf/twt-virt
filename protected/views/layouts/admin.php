<?php
/**
 * @var $this CmsController
 * @var $content string
 */
Yii::app()->bootstrap->registerAllCss();
Yii::app()->bootstrap->registerCoreScripts();
?><!DOCTYPE html>
<html lang="<?=Yii::app()->language?>">
<head>
	<meta charset="<?=Yii::app()->charset?>"/>
	<meta name="language" content="<?=Yii::app()->language?>" />
	<title><?=CHtml::encode($this->pageTitle)?></title>
</head>

<body>
<header class="container">
	<?php $this->widget('bootstrap.widgets.TbNavbar', array(
		'type'=>'inverse', // null or 'inverse'
		'brand'=> Yii::app()->name,
		'brandUrl'=> Yii::app()->homeUrl,
		'fixed' => false,
		'collapse'=>true, // requires bootstrap-responsive.css
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items' => $this->menu,
			),
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(!Yii::app()->admin->isGuest ?
					array('label'=>Yii::app()->admin->username, 'items'=>array(
						array('label'=>'Администраторы', 'url'=>array('/admin/admin_user/index')),
						'---',
						array('label'=>'Выход', 'url'=>array('/admin/admin_user/logout'))
					)) : array(),
				),
			),
		),
	)) ?>
	<?php if(isset($this->breadcrumbs)):
	$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	));
endif?>
</header>
<section id="content" class="container">
	<section class="row-fluid">
		<?php if ($this->clips['column']) : ?>
		<section class="span2 sidebar">
			<?=$this->clips['column']?>
		</section>
		<section class="span10">
			<?php echo $content; ?>
		</section>
		<?php else: ?>
		<?php echo $content; ?>
		<?php endif ?>
	</section>
</section>
<footer class="container">
	<hr>
	© <?=Yii::app()->name?>, <?=date('Y')?>
</footer>

</body>
</html>
