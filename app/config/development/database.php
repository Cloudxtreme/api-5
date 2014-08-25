<?php

return array(


	'connections' => array(

		'mysqlcw' => array(

			'driver'    => 'mysql',
			'host'      => 'db.cloudwalkers.be',
			'port'      => '3306',
			'database'  => 'cloudwalkers_dev',
			'username'  => 'workers',
			'password'  => 'dj99Pze!Ueh',
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
