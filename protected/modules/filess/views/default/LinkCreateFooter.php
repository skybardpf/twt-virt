<?php
/**
 * User: Forgon
 * Date: 04.02.13
 */
/** @var DefaultController $this */
?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'type'=>'primary',
	'label'=>'Создать',
	'url'=>'#',
	'htmlOptions'=>array('id' => 'link-create-form-submit'),
)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Отмена',
	'url'=>'#',
	'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>