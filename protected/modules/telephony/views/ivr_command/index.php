<?php
/**
 * @var application\modules\telephony\controllers\Ivr_commandController $this
 * @var application\modules\telephony\models\FormIvrCommand[] $data
 */

Yii::app()->clientScript->registerScriptFile($this->module->baseAssets . '/js/ivr_command/index.js');

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Голосовые команды')));

$tmp = array();
foreach ($data as $k=>$v){
    $tmp[] = array(
        'id' => $k,
        'title' => $v,
        'is_standard' => true,
    );
}

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'link',
    'type' => 'success',
    'label' => 'Добавить',
    'url' => $this->createUrl('create', array('cid' => $this->company->primaryKey)),
));

$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'  => new CArrayDataProvider($tmp),
    'template'      => "{items}{pager}",
    'columns'       => array(
        array(
            'name' => 'title',
            'header' => 'Название',
            'type' => 'raw',
            'value' => 'CHtml::link(
                $data["title"],
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
            'name' => 'is_standard',
            'header'=> 'Стандартная команда',
            'value' => '($data["is_standard"] == 1) ? "Да" : "Нет"',
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
                        "class" => "delete-ivr-command",
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