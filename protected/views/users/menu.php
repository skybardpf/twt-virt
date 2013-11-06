<?php
/**
 * @var UsersController $this
 * @var User $user
 * @var string $content
 */
?>
<div class="yur-tabs">
<?php
$menu = array(
    array(
        'label' => 'Профиль',
        'url' => $this->createUrl('profile/'),
        'active' => ($this->tab_menu == 'profile')
    ),
);
if (!$user->isAdmin){
    $menu[] = array(
        'label' => 'Email аккаунты',
        'url' => $this->createUrl('login_emails'),
        'active' => ($this->tab_menu == 'login_emails'),
    );
}
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'items' => $menu,
));
?>
</div>
<div class="yur-content">
    <?= $content; ?>
</div>
