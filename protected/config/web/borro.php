<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array('components'=>
		array(
			'db'=>array(
				'username' => 'root',
				'password' => '',
			)
		)
	)
);