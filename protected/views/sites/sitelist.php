<?php
/**
 * @var SitesController $this
 * @var array $sites
 * @var array $sign
 */

Yii::import('bootstrap.widgets.TbButton');

$this->pageTitle = Yii::app()->name;

Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/sites/list.js');

echo CHtml::tag('h3', array(), Yii::t('app', 'Список сайтов'));

if (Yii::app()->user->hasFlash('email_account')) {
    ?>
    <div style="color: green;">
        <?php
        echo Yii::t('app', 'Создан Email аккаунт') . ': ' . Yii::app()->user->getFlash('email_account');
        echo '<br/>';
        echo Yii::t('app', 'Пароль к Email аккаунту') . ': ' . Yii::app()->user->getFlash('email_account_pass');
        ?>
    </div>
<?php
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => new CArrayDataProvider($sites),
    'template' => "{items}{pager}",
    'columns' => array(
        array(
            'name' => 'name',
            'header' => 'Название сайта',
            'type' => 'raw',
            'value' => 'CHtml::link(
                CHtml::encode($data["name"]),
                Yii::app()->controller->createUrl("sites/settings",
                    array(
                        "cid" => Yii::app()->controller->company->primaryKey,
                        "site_id" => $data["id"],
                    )
                )
            )',
        ),
        array(
            'name' => 'domain',
            'header' => 'Домен'
        ),
        array(
            'name' => 'external_name',
            'header' => 'Шаблон',
        ),
        array(
            'name' => 'action',
            'header' => 'Действие',
            'type' => 'raw',
            'value' => 'Yii::app()->controller->widget(
                "bootstrap.widgets.TbButton",
                array(
                    "buttonType" => TbButton::BUTTON_LINK,
                    "type" => TbButton::TYPE_SUCCESS,
                    "url" => "#",
                    "label" => "Удалить",
                    "htmlOptions" => array(
                        "class" => "del-site",
                        "data-url" => Yii::app()->controller->createUrl(
                            "sites/delete",
                            array(
                                "cid" => Yii::app()->controller->company->primaryKey,
                                "id" => $data["site_id"]
                            )
                        ),
                        "data-redirect-url" => Yii::app()->controller->createUrl(
                            "sites/list",
                            array(
                                "cid" => Yii::app()->controller->company->primaryKey
                            )
                        ),
                        "data-site-name" => $data["name"],
                    ),
                ),
                true
            )',
        ),
    ),
));

$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => $sign['type'],
        'url' =>
        $this->createUrl(
            'createform',
            array(
                'cid' => $this->company->primaryKey,
            )
        ),
        'type' => 'primary',
        'label' => 'Создать сайт',
        'disabled' => $sign['disabled']
    )
);
?>
<?php if (isset($sign['text'])): ?>
    <br/><br/>
    <div style='font-size: 13px;'><i><?= $sign['text']; ?></i></div>
<?php endif; ?>