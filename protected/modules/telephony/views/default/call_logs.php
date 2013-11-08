<?php
/**
 * Логи звонков на внутренние номера.
 *
 * @var application\modules\telephony\controllers\DefaultController $this
 */

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Логи звонков')));

$data = array();

$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'  => new CArrayDataProvider($data),
    'template'      => "{items}{pager}",
    'columns'       => array(
        array(
            'name' => 'xxx',
            'header'=>'Тип'
        ),
        array(
            'name' => 'xxx',
            'header'=> 'Номер абонента',
        ),
        array(
            'name' => 'xxx',
            'header'=>'Страна абонента'
        ),
        array(
            'name' => 'xxx',
            'header'=>'Дата/время звонка'
        ),
        array(
            'name' => 'xxx',
            'header'=>'Продолжительность звонка'
        ),
    ),
));