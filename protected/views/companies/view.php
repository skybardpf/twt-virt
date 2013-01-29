<?php
/**
 * @var $this CompaniesController
 * @var $company Company
 */

$this->breadcrumbs=array(
	'Компания '.$company->name,
);
$this->pageTitle = 'Компания '.$company->name;
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false, // whether this is a stacked menu
	'items'=>array(
		array('label'=>'Файлы', 'url'=>$this->createUrl('/files/default/index', array('company_id' => $company->id))),
		array('label'=>'Почта', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Телефония', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
		array('label'=>'Сайт', 'url'=>'#', 'linkOptions' => array('class' => 'muted')),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$company,
	'attributes'=>$company->resident ? array(
		'name',
		'legal_address',
		'actual_address',
		'phone',
		'email',
		'inn',
		'kpp',
		'okopf',
		'ogrn',
		'account_number',
		'bank',
		'bik',
		'correspondent_account',
	) : array(
		'name',
		'legal_address',
		'actual_address',
		'phone',
		'email',
		'vat',
		'registration_number',
		'registration_date',
		'registration_country',
		'account_number',
		'bank',
		'swift',
		'iban',
		'position_name1',
		'position_owner1',
		'position_name2',
		'position_owner2',
		'position_name3',
		'position_owner3',
	),
)); ?>