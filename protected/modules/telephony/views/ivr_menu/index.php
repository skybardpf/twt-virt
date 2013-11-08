<?php
/**
 * @var application\modules\telephony\controllers\Ivr_menuController $this
 */

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Голосовое меню')));

$data = array();

$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'  => new CArrayDataProvider($data),
    'template'      => "{items}{pager}",
    'columns'       => array(
        array(
            'name' => 'xxx',
            'header'=>'Номер'
        ),
        array(
            'name' => 'xxx',
            'header'=> 'Команда',
        ),
        array(
            'name' => 'xxx',
            'header'=>'Внутренний номер'
        ),
    ),
));