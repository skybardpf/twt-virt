<?php
/**
 * @var $this SiteController
 * @var $companies Company[]
 */

$this->pageTitle=Yii::app()->name;
?>

<h1>Компании</h1>
Выберите компанию
<ul class="unstyled">
	<?php foreach ($companies as $c) : ?>
	<li>
		<h2><a href="<?=$this->createUrl('files', array('company_id' => $c->id))?>"><?=CHtml::encode($c->name)?></a></h2>
	</li>
	<?php endforeach ?>
</ul>