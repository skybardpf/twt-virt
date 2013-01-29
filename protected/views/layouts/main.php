<?php /* @var $this Controller */

Yii::app()->bootstrap->registerAllCss();
Yii::app()->bootstrap->registerCoreScripts();

Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath.'/../static/css/main.css'));

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=Yii::app()->language?>" lang="<?=Yii::app()->language?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?=Yii::app()->language?>" />
	<?=CHtml::linkTag('shortcut icon', 'image/vnd.microsoft.icon', CHtml::asset(Yii::app()->basePath.'/../favicon.ico'))?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container">
	<?php
	$brandName = CHtml::link(Yii::app()->name, Yii::app()->homeUrl, array('class' => 'a-brand'));
	if ($this->company) {
		$brandName .= ' → ' . (	mb_strlen($this->company->name) > 30 ? mb_substr($this->company->name, 0, 30) . '…': $this->company->name);
	}
	$this->widget('bootstrap.widgets.TbNavbar', array(
		'brand'=> $brandName,
		'brandUrl'=> false,
		'collapse'=>true,
		'fixed' => false,
		'items' => array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>(!Yii::app()->user->isGuest ?
					array(
//						Yii::app()->user->data->isAdmin ? array('label' => 'Пользователи', 'url' => '/users/index') : array(),
						array('label' => 'Поддержка', 'url' => array('/support/')),
						array('label' => Yii::app()->user->data->fullName, 'items'=>array(
							array('label'=>'Профиль', 'url'=>array('/users/profile')),
							'---',
							array('label'=>'Выход', 'url'=>array('/site/logout'))
						))
					) : array()
				),
			)
		)
	));	?>

</div>
<div class="container">
	<div class="row">
		<div class="span12">
				<?php /*
				$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links' => $this->breadcrumbs
				));*/ ?>
			<?=$content?>
		</div>
	</div>
</div>

</body>
</html>
