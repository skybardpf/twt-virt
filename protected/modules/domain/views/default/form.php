<?php
use \application\modules\domain\models as M;

/**
 * @var application\modules\domain\controllers\DefaultController $this
 * @var M\Domain $model
 */
$t = (($model->isNewRecord) ? 'Добавление' : 'Редактирование') . ' сайта';
echo CHtml::tag('h3', array(), Yii::t('app', $t));

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'form-domain',
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));

if ($model->hasErrors()) {
    echo $form->errorSummary($model);
}

echo '<fieldset>';

echo $form->textFieldRow($model, 'name');
echo $form->textFieldRow($model, 'domain');
echo $form->dropDownListRow(
    $model,
    'template_id',
    CHtml::listData(
        M\Template::model()->findAll(), 'id', 'external_name'
    ),
    array('empty' => '--- Выберите шаблон ---')
);
if($model->logo){
    echo '<p>'.CHtml::encode($model->logo).'</p>';
}
echo $form->fileFieldRow($model, 'logo');

echo '</fieldset>';

/**
 * Кнопки управления
 */
Yii::import('bootstrap.widgets.TbButton');
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'type' => TbButton::TYPE_PRIMARY,
        'label' => Yii::t('app', 'Сохранить'),
    )
);
echo '&nbsp;&nbsp;';
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => TbButton::BUTTON_LINK,
        'url' => $this->createUrl(
            'index',
            array(
                'cid' => $this->company->primaryKey
            )
        ),
        'label' => Yii::t('app', 'Отмена'),
    )
);

$this->endWidget();