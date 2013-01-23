<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Виртуальный офис',
	'sourceLanguage' => 'root',
	'language' => 'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.*',
	),

	'modules'=>array(
		'admin',
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','192.168.0.*'),
		),
	),

	// application components
	'components'=>array(
		'admin'=>array(
			'class' => 'CWebUser',
			'loginUrl' => array('admin/admin_user/login'),
			'guestName' => 'Гость',
			'allowAutoLogin' => true
		),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap',
			'publishAssets' => false
		),
		
		'cache' => array(
			'class' => 'CFileCache'
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=twt-virt-office',
			'emulatePrepare' => true,
			'username' => 'acdbuser',
			'password' => 'ZCHGiwj7',
			'charset' => 'utf8',
			'schemaCachingDuration' => YII_DEBUG ? 5 : 3600,
			'enableParamLogging' => YII_DEBUG,
			'enableProfiling' => YII_DEBUG
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
					'ipFilters'=>array('127.0.0.1','192.168.0.*'),
				),
			),
		),

		'user'=>array(
			'class' => 'TWTWebUser',
			'loginUrl' => array('site/login'),
			'guestName' => 'Гость',
			'allowAutoLogin' => true
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<company_id:\d+>/<module:\w+>' => 'site/<module>',

				'admin/helper/<action:\w+>' => 'admin/helper/<action>',
				'admin/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/admin_<controller>/<action>',
				'admin/<controller:\w+>/<action:\w+>' => 'admin_<controller>/<action>',
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);