<?php
/**
 * @var CompanyController $this
 * @var string $content
 */

Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
$this->widget('ext.loading.LoadingWidget');

$this->beginContent('//layouts/company');
echo $content;
$this->endContent();