<?php
/**
 * User: Forgon
 * Date: 07.02.13
 */
//** @var DefaultController $this */
$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>$button_text,
	'url'=>'#',
	'htmlOptions'=>array('class' => 'btn btn-primary', 'data-dismiss' => 'modal'),
));