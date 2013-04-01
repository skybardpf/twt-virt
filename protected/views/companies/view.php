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
<?php if ($company->isAdmin(Yii::app()->user->id)) : ?>
	<?php if ($company->deleted) :?>
		<div class="alert">
			Компания помечена на удаление <?=Yii::app()->dateFormatter->formatDateTime($company->deleted_date)?>
		</div>
	<?php else : ?>
		<div class="pull-left">
			<a title="Редактировать" href="<?=$this->createUrl('/companies/update', array('company_id' => $company->id))?>" rel="tooltip" class="btn"><i class="icon-pencil"></i> Редактировать</a>
			<a title="Пометить на удаление" href="<?=$this->createUrl('/companies/delete', array('company_id' => $company->id))?>" rel="tooltip" class="btn"><i class="icon-trash"></i> Пометить на удаление</a>
		</div>

		<div class="pull-right">
			<a title="Пользователи" href="<?=$this->createUrl('/users/index', array('company_id' => $company->id))?>" rel="tooltip" class="btn btn-link"><i class="icon-user"></i> Пользователи</a>
		</div>

		<br><br>
	<?php endif ?>
<?php endif ?>
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
		'position_name1',
		'position_owner1',
		'position_name2',
		'position_owner2',
		'position_name3',
		'position_owner3',
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