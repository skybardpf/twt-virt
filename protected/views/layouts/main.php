<?php /* @var $this Controller */

Yii::app()->bootstrap->registerAllCss();
Yii::app()->bootstrap->registerCoreScripts();

Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');

Yii::app()->clientScript->registerCssFile(CHtml::asset(Yii::app()->basePath . '/../static/css/main.css'));

$this->widget('ext.loading.LoadingWidget');

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= Yii::app()->language ?>" lang="<?= Yii::app()->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?= Yii::app()->language ?>"/>
    <?= CHtml::linkTag('shortcut icon', 'image/vnd.microsoft.icon', CHtml::asset(Yii::app()->basePath . '/../favicon.ico')) ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container">
    <?php
    $brandName = CHtml::link(Yii::app()->name, Yii::app()->homeUrl, array('class' => 'a-brand'));
    if ($this->company) {
        $brandName .= ' → ' . (mb_strlen($this->company->name) > 30 ? mb_substr($this->company->name, 0, 30) . '…' : $this->company->name);
    }
    Yii::app()->getModule('support');
    $requests_count = SRequest::model()->countByAttributes(array('readed' => 0, 'uid' => Yii::app()->user->id)); // Количество непрочитанных ответов от техпод.
    $this->widget('bootstrap.widgets.TbNavbar', array(
        'brand' => $brandName,
        'brandUrl' => false,
        'collapse' => true,
        'fixed' => false,
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items' => (!Yii::app()->user->isGuest ?
                    array(
//						Yii::app()->user->data->isAdmin ? array('label' => 'Пользователи', 'url' => '/users/index') : array(),
                        array('label' => 'Поддержка' . ($requests_count ? ' (' . $requests_count . ')' : ''), 'url' => array('/support/'), 'itemOptions' => array('style' => 'font-weight: bold;')),
                        array('label' => Yii::app()->user->data->fullName, 'items' => array(
                            array(
                                'label' => 'Профиль',
                                'url' => $this->createUrl('/profile/index'),
                            ),
                            '---',
                            array(
                                'label' => 'Выход',
                                'url' => $this->createUrl('/site/logout'),
                            )
                        ))
                    ) : array()
                ),
            )
        )
    ));    ?>

</div>
<div class="container">
    <div class="row">
        <div class="span12">
            <?php /*
				$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links' => $this->breadcrumbs
				));*/
            ?>
            <?= $content ?>
        </div>
    </div>
</div>
<footer class="container">
    <hr>
    © <?= Yii::app()->name ?>, <?= date('Y') ?>
</footer>
</body>
</html>
