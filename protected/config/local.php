<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
		array(
			'db'=>array(
				'connectionString' => 'mysql:host=server;dbname=twt-virt-office',
				'username' => 'root',
				'password' => 'ferthuk',
			)
		)
	)
);