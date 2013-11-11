<?php
/**
 * Показываем вкладки в зависимости от роли пользователя.
 *
 * @var application\modules\telephony\controllers\DefaultController $this
 */
?>
<div>
<?php
$cid = $this->company->primaryKey;
$role = Yii::app()->user->role;
$menu = array(
    array(
        'label' => Yii::t('app', 'Информация'),
        'url' => $this->createUrl('default/index', array('cid' => $cid)),
        'active' => ($this->tab_menu == 'info')
    ),
);

if (User::ROLE_USER === $role){
    $menu = array_merge($menu, array(
        array(
            'label' => 'Логи звонков',
            'url' => $this->createUrl(
                'call_log/index',
                array(
                    'cid' => $cid,
                    'uid' => Yii::app()->user->id
                )
            ),
            'active' => ($this->tab_menu == 'call_log'),
        ),
        array(
            'label' => 'SIP',
            'url' => $this->createUrl('sip/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'sip'),
        ),
        array(
            'label' => 'Факс',
            'url' => $this->createUrl('fax/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'fax'),
        ),
        array(
            'label' => 'Настройки внутреннего номера',
            'url' => $this->createUrl('internal_number/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'internal_number'),
        ),
    ));
}elseif (User::ROLE_COMPANY_ADMIN === $role){
    $menu = array_merge($menu, array(
        array(
            'label' => 'Голосовое меню',
            'url' => $this->createUrl('ivr_menu/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'ivr_menu'),
        ),
        array(
            'label' => 'Логи звонков',
            'url' => $this->createUrl('call_log/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'call_log'),
        ),
        array(
            'label' => 'Факс',
            'url' => $this->createUrl('fax/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'fax'),
        ),
        array(
            'label' => 'Привязка номеров',
            'url' => $this->createUrl('bind_phones/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'bind_phones'),
        ),
        array(
            'label' => 'Настройки номеров',
            'url' => $this->createUrl('internal_number/index', array('cid' => $cid)),
            'active' => ($this->tab_menu == 'internal_number'),
        ),
    ));
}elseif (User::ROLE_ADMIN === $role){

}

$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => $menu,
));
?>
</div>
<div>
    <?= $content; ?>
</div>
