<?php
/**
 * @var application\modules\domain\controllers\DefaultController $this
 * @var application\modules\domain\models\Domain[] $data
 */

Yii::import('bootstrap.widgets.TbButton');

Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/sites/list.js');

echo CHtml::tag('h3', array(), Yii::t('app', 'Список сайтов'));

if (Yii::app()->user->hasFlash('email_account')) {
    echo CHtml::tag('div', array('style' => 'color: green;'),
        Yii::t('app', 'Создан Email аккаунт') . ': ' . Yii::app()->user->getFlash('email_account') . '<br/>' .
        Yii::t('app', 'Пароль к Email аккаунту') . ': ' . Yii::app()->user->getFlash('email_account_pass')
    );
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => new CArrayDataProvider($data),
    'template' => "{items}{pager}",
    'columns' => array(
        array(
            'name' => 'name',
            'header' => Yii::t('app', 'Название сайта'),
            'type' => 'raw',
            'value' => 'CHtml::link(
                CHtml::encode($data["name"]),
                Yii::app()->controller->createUrl("update",
                    array(
                        "cid" => Yii::app()->controller->company->primaryKey,
                        "sid" => $data["id"],
                    )
                )
            )',
        ),
        array(
            'name' => 'domain',
            'header' => Yii::t('app', 'Домен')
        ),
        array(
            'name' => 'external_name',
            'header' => Yii::t('app', 'Шаблон'),
            'value' => '$data->template->external_name',
        ),
        array(
            'name' => 'action',
            'header' => Yii::t('app', 'Действие'),
            'type' => 'raw',
            'value' => 'Yii::app()->controller->widget(
                "bootstrap.widgets.TbButton",
                array(
                    "buttonType" => TbButton::BUTTON_LINK,
                    "type" => TbButton::TYPE_SUCCESS,
                    "url" => "#",
                    "label" => Yii::t("app", "Удалить"),
                    "htmlOptions" => array(
                        "class" => "del-site",
                        "data-url" => Yii::app()->controller->createUrl(
                            "delete",
                            array(
                                "cid" => Yii::app()->controller->company->primaryKey,
                                "sid" => $data["id"]
                            )
                        ),
                        "data-redirect-url" => Yii::app()->controller->createUrl(
                            "index",
                            array(
                                "cid" => Yii::app()->controller->company->primaryKey
                            )
                        ),
                        "data-site-name" => CHtml::encode($data["name"]),
                    ),
                ),
                true
            )',
        ),
    ),
));

//if (count($data) < Yii::app()->params->maxNumberSitesForCompany) {
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => TbButton::BUTTON_LINK,
            'url' => $this->createUrl(
                'create',
                array(
                    'cid' => $this->company->primaryKey,
                )
            ),
            'type' => 'primary',
            'label' => Yii::t('app', 'Создать сайт'),
        )
    );
//}