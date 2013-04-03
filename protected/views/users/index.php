<?php
/**
 * @var $this UsersController
 * @var $users User[]
 * @var $company Company Компания, с которой перешли на страницу
 */

$this->breadcrumbs=array(
	'Пользователи',
);
$this->pageTitle = 'Пользователи';
?>
<h1><?=CHtml::encode($this->pageTitle)?></h1>
<a href="<?=$this->createUrl('/companies/view', array('company_id' => $company->id))?>">Вернуться к компании "<?=$company->name?>"</a>
<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
	'dataProvider' => new CArrayDataProvider($users),
	'template' => "{pager}\n{items}\n{pager}",
	'ajaxUpdate' => false,
	'columns' => array(
		array('name' => 'E-Mail', 'value' => '$data->email'),
		array('name' => 'Полное имя', 'value' => '$data->fullName'),
		array('name' => 'Телефон', 'value' => '$data->phone'),
		array('name' => 'Активный', 'value' => '$data->active ? "Да" : "Нет"'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey, "company_id"=>'.$company->id.'))',
			'template' => '{update}',
			'deleteConfirmation' => false,
		),
	)
));
?>

<a href="<?=$this->createUrl('create', array('company_id' => $company->id))?>" class="btn btn-info">Добавить пользователя</a>