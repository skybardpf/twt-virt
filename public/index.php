<?php

// change the following paths if necessary
$yii    = 'yii.php';
$config = dirname(__FILE__).'/../protected/config/devel.php';


if ($_SERVER['HTTP_HOST'] == 'ioffice-on.com') {
	$yii    = dirname(__FILE__).'/yii/yii.php';
	$config = dirname(__FILE__).'/protected/config/production.php';

	defined('YII_DEBUG') or define('YII_DEBUG',false);
} elseif ($_SERVER['HTTP_HOST'] == 'twt-virt.twtconsult.ru') {
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    $config = dirname(__FILE__).'/../protected/config/production_twt-virt.php';
}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

mb_internal_encoding('utf-8');
require_once($yii);
Yii::createWebApplication($config)->run();
