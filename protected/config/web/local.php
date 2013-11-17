<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
		array(
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=twt-virt-office',
				'username' => 'root',
				'password' => 'yfh11rjv56fy',
			),
		)
	)
);
