<?php

return array(


	'connections' => array(

		'mysqlcw' => array(

			'driver'    => 'mysql',
			'host'      => 'stagingdb.cloudwalkers.be',
			'port'      => '3306',
			'database'  => 'cloudwalkers_staging',
			'username'  => 'cwstaging',
			'password'  => '!.^$3Lt;NVahvg2$/7>zMF5)pXN.Bf-<',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'options'   => array(
					//PDO::ATTR_PERSISTENT => true, // Optimization with the connection pool
					//PDO::FETCH_ASSOC
			),
		)
	),

);
