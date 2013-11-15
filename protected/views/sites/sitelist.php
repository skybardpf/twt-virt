<?php
/**
 * @var SitesController $this
 * @var array $sites
 * @var array $sign
 */

Yii::import('bootstrap.widgets.TbButton');

$this->pageTitle = Yii::app()->name;

Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/sites/list.js');
?>

    <h1>Список сайтов</h1>

    <table class="table table-striped table-hover table-condensed">
        <tr>
            <th>Название сайта</th>
            <th>Домен</th>
            <th>Шаблон</th>
            <th>Действие</th>
        </tr>
        <?php foreach ($sites as $_site) : ?>
            <tr>
                <td>
                    <?php
                    echo CHtml::link(
                        $_site['name'],
                        $this->createUrl('settings',
                            array(
                                'cid' => $this->company->primaryKey,
                                'site_id' => $_site['site_id'],
                            )
                        )
                    ); ?>
                </td>
                <td><?= $_site['domain']; ?></td>
                <td><?= $_site['external_name']; ?></td>
                <td>
                    <?php
                    $this->widget('bootstrap.widgets.TbButton',
                        array(
                            'buttonType' => TbButton::BUTTON_LINK,
                            'type' => TbButton::TYPE_LINK,
                            'url' => '#',
                            'label' => 'Удалить',
                            'htmlOptions' => array(
                                'class' => 'del-site',
                                'data-url' => $this->createUrl(
                                    'delete',
                                    array(
                                        'cid' => $this->company->primaryKey,
                                        'id' => $_site['site_id']
                                    )
                                ),
                                'data-redirect-url' => $this->createUrl(
                                    'list',
                                    array(
                                        'cid' => $this->company->primaryKey
                                    )
                                ),
                                'data-site-name' => $_site['name'],
                            ),
                        )
                    );
                    ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php
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