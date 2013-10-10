<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
		array(
			'db'=>array(
				'connectionString' => 'mysql:host=10.10.10.26;dbname=twt-virt',
				'username' => 'twt',
				'password' => 'twt',
			)
		)
	)
);
