<?php

// API Settings

return array(

	// api.settings
	
	'settings' => array(
		
		'base_url' => ( 
						(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
	  					|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
					  ) ? 
					  'https://cloudwalkers-api.local/' : 'http://cloudwalkers-api.local/'
	),
	
	/*
	|--------------------------------------------------------------------------
	| Engine path
	|--------------------------------------------------------------------------
	|
	| This path is used by the local Jobserver to sync a queue request
	|
	*/
	'engine' => array(
	
		'workerpath' => '/webroot/cloudwalkers/engine/workers/'
	
	)

);