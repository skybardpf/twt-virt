<?php
use \application\modules\domain\models as M;

/**
 * @var application\modules\domain\controllers\DefaultController $this
 * @var M\Domain $model
 * @var string $content
 * @var string $active_tab
 */
if (!$model->isNewRecord){
    $this->widget('bootstrap.widgets.TbMenu', array(
        'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
        'stacked' => false, // whether this is a stacked menu
        'items' => array(
            array(
                'label' => 'Настройки сайта',
                'url' => $this->createUrl('default/update', array(
                    'cid' => $this->company->primaryKey,
                    'sid' => $model->primaryKey,
                )),
                'active' => ($active_tab === 'site'),
            ),
            array(
                'label' => 'Страница "Главная"',
                'url' => $this->createUrl('default/page', array(
                    'cid' => $this->company->primaryKey,
                    'sid' => $model->primaryKey,
                    'kind' => M\DomainPage::KIND_MAIN,
                )),
                'active' => ($active_tab === 'page_main'),
            ),
            array(
                'label' => 'Страница "О компании"',
                'url' => $this->createUrl('default/page', array(
                    'cid' => $this->company->primaryKey,
                    'sid' => $model->primaryKey,
                    'kind' => M\DomainPage::KIND_ABOUT_COMPANY,
                )),
                'active' => ($active_tab === 'page_about'),
            ),
            array(
                'label' => 'Страница "Партнеры"',
                'url' => $this->createUrl('default/page', array(
                    'cid' => $this->company->primaryKey,
                    'sid' => $model->primaryKey,
                    'kind' => M\DomainPage::KIND_PARTNER,
                )),
                'active' => ($active_tab === 'page_partner'),
            ),
            array(
                'label' => 'Страница "Услуги"',
                'url' => $this->createUrl('default/page', array(
                    'cid' => $this->company->primaryKey,
                    'sid' => $model->primaryKey,
                    'kind' => M\DomainPage::KIND_SERVICES,
                )),
                'active' => ($active_tab === 'page_services'),
            ),
            array(
                'label' => 'Страница "Контакты"',
                'url' => $this->createUrl('default/page', array(
                    'cid' => $this->company->primaryKey,
                    'sid' => $model->primaryKey,
                    'kind' => M\DomainPage::KIND_CONTACTS,
                )),
                'active' => ($active_tab === 'page_contacts'),
            ),

        ),
    ));
}

echo '<div>'.$content.'</div>';