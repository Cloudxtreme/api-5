<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		'mysqlcw' => array(
			/*'read' => array(
				'host' => '192.168.56.1',
				'port'      => '3307'
				//'port'      => '13306'
			),
			'write' => array(
				'host' => '196.168.56.1',
				'port'      => '3307'
				//'port'      => '13306'
			),*/
				
			'driver'    => 'mysql',
			'host'      => '192.168.56.1',
			//'port'      => '3307',
			'port'      => '13306',
			'database'  => 'cloudwalkers',
			'username'  => 'myuser',
			'password'  => 'myuser_lo',
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
