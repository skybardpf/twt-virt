<?php
/**
 * User: Forgon
 * Date: 07.02.13
 */
//** @var DefaultController $this */
$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Переместить',
	'url'=>'#',
	'disabled' => true,
	'htmlOptions'=>array('id' => 'move_button', 'data-link' => $this->createUrl('move_to', array('company_id' => $this->company->id, 'file_id' => $file->id))),
));
$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Отмена',
	'url'=>'#',
	'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>