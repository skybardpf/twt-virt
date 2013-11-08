<?php
/**
 * Общая информация для разных ролей пользователей.
 *
 * @var application\modules\telephony\controllers\DefaultController $this
 */

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Общая информация')));

$data = array();

$attributes = array();
$role = Yii::app()->user->role;

if (User::ROLE_USER === $role){
    $attributes = array(
        array(
            'name' => 'xx',
            'label' => 'Внешний номер'
        ),
        array(
            'label' => 'Внутрений номер'
        ),
        array(
            'label' => 'URL сервиса'
        ),
    );
} elseif (User::ROLE_USER === $role){
    $attributes = array(
        array(
            'label' => 'Внешний номер'
        ),
        array(
            'label' => 'Входящий номер'
        ),
        array(
            'label' => 'Номер факса'
        ),
        array(
            'label' => 'Остаток минут'
        ),
    );
} elseif (User::ROLE_USER === $role){

}

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => new CArrayDataProvider($data),
    'attributes' => $attributes,
));