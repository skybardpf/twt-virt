<?php
$yii    = 'yii.php';
$config = dirname(__FILE__).'/../protected/config/web/devel.php';

if (strpos($_SERVER['HTTP_HOST'], 'ioffice-on.com') !== FALSE) {
        $yii    = 'yii.php';
        $config = dirname(__FILE__).'/../protected/config/web/production.php';
        defined('YII_DEBUG') or define('YII_DEBUG',false);
}
elseif ($_SERVER['HTTP_HOST'] == 'twt-virt.twtconsult.ru') {
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    $config = dirname(__FILE__).'/../protected/config/web/production_twt-virt.php';
}
elseif ($_SERVER['HTTP_HOST'] == 'twt-virt.artektiv.ru') {
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    $config = dirname(__FILE__).'/../protected/config/web/demo_twt-virt.php';
} elseif ($_SERVER['HTTP_HOST'] == 'twt-virt.skybardpf.devel') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    $yii = '/home/skybardpf/projects/twt-virt/yii/yii.php';
    $config = dirname(__FILE__).'/../protected/config/web/devel.php';
}

defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

mb_internal_encoding('utf-8');
require_once($yii);
Yii::createWebApplication($config)->run();