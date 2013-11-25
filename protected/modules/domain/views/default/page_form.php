<?php
use \application\modules\domain\models as M;

/**
 * @var application\modules\domain\controllers\DefaultController $this
 * @var M\DomainPage $page
 */

Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/extensions/ckeditor/ckeditor.js');
?>

<script>
    $(document).ready(function () {
        CKEDITOR.replace("application\\modules\\domain\\models\\DomainPage_content");
    });
</script>

<?php
echo CHtml::tag('h3', array(), Yii::t('app', 'Страница сайта "' . $page->kindToString($page->kind) . '"'));

if (Yii::app()->user->hasFlash('success')) {
    echo CHtml::tag('div', array('style' => 'color: green;'),
        Yii::app()->user->getFlash('success')
    );
}

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

if ($page->hasErrors()) {
    echo $form->errorSummary($page);
}

echo '<fieldset>';

echo $form->checkBoxRow($page, 'is_show');
echo $form->textFieldRow($page, 'window_title');
echo $form->textFieldRow($page, 'page_title');

if ($page->logo) {
    echo '<p>' . CHtml::encode($page->logo) . '</p>';
}
echo $form->fileFieldRow($page, 'logo');

/**
 * В контактах нет баннеров
 */
if ($page->kind === M\DomainPage::KIND_CONTACTS){
    echo $form->dropDownListRow($page, 'map', $page->getMaps(), array('empty' => Yii::t('app', '--- Выберите ---')));
    echo $form->textFieldRow($page, 'adress');
    echo $form->textFieldRow($page, 'email');
} else {
    if ($page->banner) {
        echo '<p>' . CHtml::encode($page->banner) . '</p>';
    }
    echo $form->fileFieldRow($page, 'banner');
}

echo $form->textAreaRow($page, 'content');

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
//echo '&nbsp;&nbsp;';
//$this->widget(
//    'bootstrap.widgets.TbButton',
//    array(
//        'buttonType' => TbButton::BUTTON_LINK,
//        'url' => $this->createUrl(
//            'index',
//            array(
//                'cid' => $this->company->primaryKey
//            )
//        ),
//        'label' => Yii::t('app', 'Отмена'),
//    )
//);

$this->endWidget();