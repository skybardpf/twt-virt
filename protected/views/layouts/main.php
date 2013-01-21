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
	<?php $this->widget('bootstrap.widgets.TbNavbar', array(
		'brand'=>Yii::app()->name,
		'brandUrl'=>Yii::app()->homeUrl,
		'collapse'=>true,
		'fixed' => false,
		'items' => array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(!Yii::app()->user->isGuest ?
					array('label'=>Yii::app()->user->data->fullName, 'items'=>array(
//						'---',
						array('label'=>'Выход', 'url'=>array('/site/logout'))
					)) : array(),
				),
			)
		)
	));	?>

</div>
<div class="container">
	<div class="row">
		<div class="span12">
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
