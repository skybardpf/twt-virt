<?php
/**
 * @var $this Controller
 */
?>

<?php
$this->beginContent('//layouts/column1');

$menu = array(
    array(
        'label' => 'Почта',
        'url' => $this->createUrl('/mail/change_auth',
            array(
                'company_id' => $this->company->id
            )
        ),
        'active' => ($this->getId() == 'mail'),
    ),
    array(
        'label' => 'Телефония',
        'url' => $this->createUrl(
            '/telephony/default/index',
            array(
                'cid' => $this->company->id
            )
        ),
        'active' => ($this->module && $this->module->id == 'telephony'),
    ),
    array(
        'label' => 'Файлы',
        'url' => $this->createUrl(
            '/files/default/index',
            array('company_id' => $this->company->id)
        ),
        'active' => ($this->module && $this->module->id == 'files')
    ),
);
$role = Yii::app()->user->role;

if (User::ROLE_USER === $role) {
    //
} elseif (User::ROLE_COMPANY_ADMIN === $role) {
    $menu = array_merge($menu, array(
        array(
            'label' => 'Сайт',
            'url' => $this->createUrl('/sites/list',
                array(
                    'cid' => $this->company->id
                )
            ),
            'active' => ($this->getId() == 'sites')
        ),
        array(
            'label' => 'Администрирование',
            'url' => $this->createUrl(
                '/companies/view',
                array(
                    'company_id' => $this->company->id
                )
            ),
            'active' => $this->id == 'companies'
        )
    ));
}

$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => $menu,
    'htmlOptions' => array('class' => 'company_nav_bar')
));
?>
<div class="company_inner_content"><?php echo $content; ?></div>
<?php $this->endContent(); ?>
