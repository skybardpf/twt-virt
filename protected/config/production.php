<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
	      array(
		      'db'=>array(
			      'connectionString' => 'mysql:host=sql227.your-server.de;dbname=virt_office',
			      'emulatePrepare' => true,
			      'username' => 'ioffic_3',
			      'password' => 'Lb5RB98g',
			      'charset' => 'utf8',
			      'schemaCachingDuration' => YII_DEBUG ? 5 : 3600,
			      'enableParamLogging' => YII_DEBUG,
			      'enableProfiling' => YII_DEBUG
		      ),
	      )
	)
);