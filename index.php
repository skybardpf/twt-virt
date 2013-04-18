<?php

// change the following paths if necessary
$yii    = 'framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';


if ($_SERVER['HTTP_HOST'] == 'twt-virt-office.local') {
	$yii    = 'yii-1.1.13/yii.php';
	$config = dirname(__FILE__).'/protected/config/borro.php';

	defined('YII_DEBUG') or define('YII_DEBUG',true);
} else if ($_SERVER['HTTP_HOST'] == 'local.twt-virt.ru') {
	$yii    = dirname(__FILE__).'/../../yii/framework/yii.php';
	$config = dirname(__FILE__).'/protected/config/local.php';

	defined('YII_DEBUG') or define('YII_DEBUG',true);
} else if ($_SERVER['HTTP_HOST'] == 'ioffice-on.com') {
	$yii    = dirname(__FILE__).'/yii/yii.php';
	$config = dirname(__FILE__).'/protected/config/production.php';

	defined('YII_DEBUG') or define('YII_DEBUG',false);
}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

mb_internal_encoding('utf-8');
require_once($yii);
Yii::createWebApplication($config)->run();
