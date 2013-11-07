<?php
/**
 * @var ProfileController $this
 * @var User $user
 * @var string $content
 */
?>
<div>
<?php
$menu = array(
    array(
        'label' => 'Профиль',
        'url' => $this->createUrl('index'),
        'active' => ($this->tab_menu == 'profile')
    ),
);
if(Yii::app()->user->checkAccess('changeLoginEmailsProfile')) {
    $menu[] = array(
        'label' => 'Email аккаунты',
        'url' => $this->createUrl('login_emails'),
        'active' => ($this->tab_menu == 'login_emails'),
    );
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
