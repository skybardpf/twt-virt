<?php /* @var $this Controller */

Yii::app()->bootstrap->registerAllCss();
Yii::app()->bootstrap->registerCoreScripts();

Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath.'/../static/css/main.css'));

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=Yii::app()->language?>" lang="<?=Yii::app()->language?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?=Yii::app()->language?>" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container">
	<div class="navbar">
		<div class="navbar-inner">
			<a class="brand" href="<?=Yii::app()->homeUrl?>"><?=Yii::app()->name?></a>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="span3 left-menu">
			<?php
			$this->widget('bootstrap.widgets.TbMenu', array(
				'type'      => 'tabs', // '', 'tabs', 'pills' (or 'list')
				'stacked'   => true, // whether this is a stacked menu
				'items'     => $this->menu
			)); ?>
		</div>
		<div class="span9">
				<?php
				$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links' => $this->breadcrumbs
				));?>
			<?=$content?>
		</div>
	</div>
</div>

</body>
</html>
