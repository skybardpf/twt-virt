<?php
/* @var $this Controller */
?>
<?php $this->beginContent('//layouts/column1'); ?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array(
            'label' => 'Почта',
            'url' => Yii::app()->params->webMailUrl,
            'linkOptions' => array("target"=>"_blank")
        ),
        array(
            'label' => 'Почта (Макет)',
            'url' => $this->createUrl('/mail/layout',
                array(
                    'company_id' => $this->company->id
                )
            ),
            'active' => ($this->getId() == 'mail'),
        ),
        array('label' => 'Телефония', 'url' => '#', 'linkOptions' => array('class' => 'muted')),
        array(
            'label' => 'Сайт',
            'url' => $this->createUrl('/sites/list',
                array(
                    'company_id' => $this->company->id
                )
            ),
            'active' => ($this->getId() == 'sites')
        ),
        array('label' => 'Файлы', 'url' => $this->createUrl('/files/default/index', array('company_id' => $this->company->id)), 'active' => ($this->module && $this->module->id == 'files')),
        (
        $this->company->isAdmin(Yii::app()->user->id) ? array(
            'label' => 'Администрирование', 'url' => $this->createUrl('/companies/view', array('company_id' => $this->company->id)), 'active' => $this->id == 'companies'
        ) : array()
        ),
    ),
    'htmlOptions' => array('class' => 'company_nav_bar')
)); ?>
<div class="company_inner_content"><?php echo $content; ?></div>
<?php $this->endContent(); ?>
