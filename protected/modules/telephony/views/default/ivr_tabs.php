<?php
use application\modules\telephony\controllers as Ctrl;
/**
 * @var Ctrl\Ivr_menuController | Ctrl\Ivr_commandController $this
 */
?>
<div>
<?php
$cid = $this->company->primaryKey;
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => array(
        array(
            'label' => 'Меню',
            'url' => $this->createUrl('ivr_menu/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'ivr_menu'),
        ),
        array(
            'label' => 'Голосовые команды',
            'url' => $this->createUrl('ivr_command/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'ivr_command'),
        ),
    ),
));
?>
</div>
<div>
    <?= $content; ?>
</div>

