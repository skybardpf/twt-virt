<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
        array(
            'db'=>array(
                'connectionString' => 'mysql:host=10.10.10.26;dbname=twt-virt',
                'username' => 'twt',
                'password' => 'twt',
                'emulatePrepare' => true,
                'charset' => 'utf8',
                'schemaCachingDuration' => YII_DEBUG ? 5 : 3600,
                'enableParamLogging' => YII_DEBUG,
                'enableProfiling' => YII_DEBUG
            ),
        )
	)
);