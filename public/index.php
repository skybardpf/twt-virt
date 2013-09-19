<?php

$yii    = 'yii.php';
$config = dirname(__FILE__).'/../protected/config/devel.php';


if ($_SERVER['HTTP_HOST'] == 'ioffice-on.com') {
        $yii    = 'yii.php';
        $config = dirname(__FILE__).'/../protected/config/production.php';
        defined('YII_DEBUG') or define('YII_DEBUG',false);
}
elseif ($_SERVER['HTTP_HOST'] == 'twt-virt.twtconsult.ru') {
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    $config = dirname(__FILE__).'/../protected/config/production_twt-virt.php';
}
elseif ($_SERVER['HTTP_HOST'] == 'twt-virt.artektiv.ru') {
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    $config = dirname(__FILE__).'/../protected/config/demo_twt-virt.php';
}

defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

mb_internal_encoding('utf-8');
require_once($yii);
Yii::createWebApplication($config)->run();