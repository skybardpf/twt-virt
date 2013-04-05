<?php
/**
 * User: Forgon
 * Date: 07.02.13
 */
//** @var DefaultController $this */
$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Сохранить',
	'url'=>'#',
	'htmlOptions'=>array('data-save_button' => 'account', 'data-link' => $this->createUrl('update_account', array('company_id' => $company_id, 'resident' => $resident, 'account_id' => $account_id))),
));
$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Отмена',
	'url'=>'#',
	'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>