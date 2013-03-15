<?php
/**
 * @var $this Admin_usersController
 * @var $dataProvider CDataProvider
 */

$jui_asset = CHtml::asset(YII_PATH.'/web/js/source/');
Yii::app()->clientScript->registerCssFile($jui_asset.'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');

$this->breadcrumbs=array(
	'Пользователи',
);
$this->pageTitle = 'Пользователи';
?>
<h1><?=$this->pageTitle?></h1>

<?php
	/** @var $form CActiveForm */
	$form = $this->beginWidget('CActiveForm', array(
		'action'                    => $this->createUrl(''), // Иначе гет стакается ?company=2&company=5&company=4
		'id'                        => 'user-list-form',
		'method'                    => 'get',
		'enableAjaxValidation'      => false,
		'enableClientValidation'    => false,
	));
	echo CHtml::label('Компания:', 'user_filter_text_field');
	echo CHtml::textField('', $company ? $company->name : '', array('id' => 'user_filter_text_field'));
	Yii::app()->clientScript->registerScript('admin_users_filter', 'js:
	$(document).ready(function(){
		$(document.getElementById("user_filter_text_field")).autocomplete({
			source: '.CJavaScript::encode($companies).',
			minLength: 2,
			select: function (event, ui) {
				$(event.target).val(ui.item.label);
				$(document.getElementById("company_filter_field")).val(ui.item.value).trigger("change");
				return false;
			},
			focus: function (event, ui) {
				return false;
			}
		});
		$(document).on("change", "#company_filter_field", function(event){
			$(this.form).trigger("submit");
		});
		$(document).on("change", "#user_filter_text_field", function(event) {
			if (!$(this).val()) {
				$(document.getElementById("company_filter_field")).val("").trigger("change");
			}
		});
	});
');
	echo CHtml::hiddenField('company', $company ? $company->id : '', array('id' => 'company_filter_field'));
	$this->endWidget();
//$this->widget('zii.widgets.jui.CJuiAutocomplete', array('name' => 'asd'));
?>
	<a href="<?=$this->createUrl('create')?>">Добавить пользователя</a>
<?php
$this->widget('ext.bootstrap.widgets.TbGridView', array(
	'dataProvider' => $dataProvider,
	'template' => "{pager}\n{items}\n{pager}",
	'ajaxUpdate' => false,
	'columns' => array(
		'id',
		'email',
		'fullName',
		'phone',
		array('name' => 'active', 'type' => 'boolean'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}',
			'deleteConfirmation' => false,
//			'htmlOptions'=>array('style'=>'width: 50px'),
		),
	)
));
?>