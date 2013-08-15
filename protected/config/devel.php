<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
		array(
			'db'=>array(
				'connectionString' => 'mysql:host=mysql-01.artektiv.local;dbname=twt-virt-office',
				'username' => 'twt',
				'password' => 'twt',
			),
		)
	)
);
