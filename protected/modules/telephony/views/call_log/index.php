<?php
/**
 * Логи звонков на внутренние номера.
 *
 * @var application\modules\telephony\controllers\DefaultController $this
 * @var array $data
 * @var User[] $users
 * @var application\modules\telephony\models\FormCallLog $model
 */

echo CHtml::tag('h3', array(), CHtml::encode(Yii::t('app', 'Логи звонков')));

/**
 * Фильтровать по пользователям может только админ компании.
 */
if (Yii::app()->user->role === User::ROLE_COMPANY_ADMIN){
    /**
     * @var TbActiveForm $form
     */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'form-log-user',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnChange' => true,
        ),
    ));
    if ($model->hasErrors()) {
        echo $form->errorSummary($model);
    }
    echo $form->dropDownListRow($model, 'user_id', CHtml::listData($users, 'id', 'fullName'), array('empty' => '--- Все пользователи ---'));

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Фильтр'
    ));

    $this->endWidget();
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => new CArrayDataProvider($data),
    'template' => "{items}{pager}",
    'columns' => array(
        array(
            'name' => 'xxx',
            'header' => 'Пользователь'
        ),
        array(
            'name' => 'xxx',
            'header' => 'Тип'
        ),
        array(
            'name' => 'xxx',
            'header' => 'Номер абонента',
        ),
        array(
            'name' => 'xxx',
            'header' => 'Страна абонента'
        ),
        array(
            'name' => 'xxx',
            'header' => 'Дата/время звонка'
        ),
        array(
            'name' => 'xxx',
            'header' => 'Продолжительность звонка'
        ),
    ),
));