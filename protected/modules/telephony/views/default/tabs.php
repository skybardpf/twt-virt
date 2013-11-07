<?php
/**
 * @var application\modules\telephony\controllers\DefaultController $this
 */
?>
<div>
<?php
$cid = $this->company->primaryKey;

$menu = array(
    array(
        'label' => Yii::t('app', 'Информация'),
        'url' => $this->createUrl('index', array('cid' => $cid)),
        'active' => ($this->tab_menu == 'info')
    ),
    array(
        'label' => 'Логи звонков',
        'url' => $this->createUrl('call_logs', array('cid' => $cid)),
        'active' => ($this->tab_menu == 'call_logs'),
    ),
    array(
        'label' => 'SIP',
        'url' => $this->createUrl('sip', array('cid' => $cid)),
        'active' => ($this->tab_menu == 'sip'),
    ),
    array(
        'label' => 'Факс',
        'url' => $this->createUrl('fax', array('cid' => $cid)),
        'active' => ($this->tab_menu == 'fax'),
    ),
    array(
        'label' => 'Настройки',
        'url' => $this->createUrl('internal_numbers', array('cid' => $cid)),
        'active' => ($this->tab_menu == 'internal_numbers'),
    ),
);
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => $menu,
));
?>
</div>
<div>
    <?= $content; ?>
</div>
