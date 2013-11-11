<?php
/**
 * @var application\modules\telephony\controllers\Ivr_menuController $this
 */

Yii::app()->clientScript->registerScriptFile($this->module->baseAssets . '/js/ivr_menu/index.js');

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Голосовое меню')));

$data = array(
    array(
        'id' => 1,
        'number' => 111,
        'command_id' => 1,
        'internal_number_id' => 1,
    )
);

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'link',
    'type' => 'success',
    'label' => 'Добавить',
    'url' => $this->createUrl('create', array('cid' => $this->company->primaryKey)),
));

$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'  => new CArrayDataProvider($data),
    'template'      => "{items}{pager}",
    'columns'       => array(
        array(
            'name' => 'number',
            'header'=>'Номер',
            'type' => 'raw',
            'value' => 'CHtml::link(
                $data["number"],
                Yii::app()->controller->createUrl(
                    "update",
                    array(
                        "cid" => Yii::app()->controller->company->primaryKey,
                        "id" => $data["id"]
                    )
                )
            )',
        ),
        array(
            'name' => 'command_id',
            'header'=> 'Команда',
        ),
        array(
            'name' => 'internal_number_id',
            'header'=>'Внутренний номер'
        ),
        array(
            'name' => 'delete',
            'header'=>'Удалить',
            'type' => 'raw',
            'value' => 'Yii::app()->controller->widget("bootstrap.widgets.TbButton",
                array(
                    "buttonType" => "link",
                    "type" => "success",
                    "label" => "Удалить",
                    "url" => "#",
                    "htmlOptions" => array(
                        "class" => "delete-ivr-menu",
                        "data-url" => Yii::app()->controller->createUrl(
                            "delete",
                            array(
                                "cid" => Yii::app()->controller->company->primaryKey,
                                "id" => $data["id"]
                            )
                        ),
                        "data-redirect" => Yii::app()->controller->createUrl(
                            "index",
                            array(
                                "cid" => Yii::app()->controller->company->primaryKey,
                            )
                        ),
                    ),
                ),
                true
            )',
        ),
    ),
));