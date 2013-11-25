<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../../extensions/bootstrap');

Yii::setPathOfAlias('uploadDir', dirname(__FILE__) . '/../../../public/upload');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR .'..',
    'name' => 'Виртуальный офис',
    'sourceLanguage' => 'root',
    'language' => 'ru',

    // preloading 'log' component
    'preload' => array('log', 'bootstrap'),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.*',
    ),

    'modules' => array(
        'admin' => array(
            'startPage' => '/admin_companies/index'
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1', '192.168.0.*'),
        ),
        'support', 'files',
        'telephony' => array(
            'class' => '\application\modules\telephony\TelephonyModule',
            'controllerNamespace' => '\application\modules\telephony\controllers',
        ),
        'domain' => array(
            'class' => '\application\modules\domain\DomainModule',
            'controllerNamespace' => '\application\modules\domain\controllers',
        ),
    ),

    // application components
    'components' => array(
        'admin' => array(
            'class' => 'CWebUser',
            'loginUrl' => array('admin/admin_user/login'),
            'guestName' => 'Гость',
            'allowAutoLogin' => true
        ),
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'publishAssets' => false
        ),

        'cache' => array(
            'class' => 'CFileCache'
        ),

        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=twt-virt-office',
            'emulatePrepare' => true,
            'username' => 'acdbuser',
            'password' => 'ZCHGiwj7',
            'charset' => 'utf8',
            'schemaCachingDuration' => YII_DEBUG ? 5 : 3600,
            'enableParamLogging' => YII_DEBUG,
            'enableProfiling' => YII_DEBUG,
            'class' => 'CDbConnection',
        ),

        'db_mail' => array(
            'connectionString' => 'mysql:host=this.com.ua;dbname=mail',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '9aPzjTC0dz',
            'charset' => 'utf8',
            'schemaCachingDuration' => YII_DEBUG ? 5 : 3600,
            'enableParamLogging' => YII_DEBUG,
            'enableProfiling' => YII_DEBUG,
            'class' => 'CDbConnection',
        ),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'categories' => 'application',
                    'levels'=>'error, warning, trace, profile, info',
                ),
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('127.0.0.1', '192.168.0.*'),
                ),
            ),
        ),

        'user' => array(
            'class' => 'TWTWebUser',
            'loginUrl' => array('site/login'),
            'guestName' => 'Гость',
            'allowAutoLogin' => true
        ),

        'authManager' => array(
            'class' => 'TWTAuthManager',
            'defaultRoles' => array('guest'),
            // показываем ошибки только в режиме отладки
            'showErrors' => YII_DEBUG,
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<company_id:\d+>/users' => '/users/index',
                '<company_id:\d+>/users/update' => '/users/update',
                '<company_id:\d+>/users/create' => '/users/create',

                '<company_id:\d+>' => 'companies/view',
                '<company_id:\d+>/<action:\w+>_company' => 'companies/<action>',
                '<company_id:\d+>/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

                '/admin/' => '/admin_companies/index',
                'admin/helper/<action:\w+>' => 'admin/helper/<action>',

                '/admin/support/' => 'support/admin_support/index',
                '/admin/support/id/<id:\d+>' => 'support/admin_support/view',
                'support/create' => 'support/default/create',
                'support/id/<id:\d+>' => 'support/default/view',

                'admin/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin_<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>' => 'admin_<controller>/<action>',

            ),
        ),
    ),

    'params' => array(
        'adminEmail' => 'webmaster@example.com',

        'maxNumberSitesForCompany' => 3, /* Максимальное кол-во сайтов на компанию */
        'urlWebMail' => 'http://this.com.ua',
        'httpHostName' => (substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.') ? substr($_SERVER['HTTP_HOST'], 4) : $_SERVER['HTTP_HOST'],
        'IMAPHost' => 'this.com.ua',
        'IMAPPort' => '143',
    ),
);