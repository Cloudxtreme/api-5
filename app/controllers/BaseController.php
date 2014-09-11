<?php

class BaseController extends Controller 
{

	function __construct()
	{
		
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{

	}
	
	/**
	 *	Dispatch
	 *	The basic controller action between API and Worker
	 */
	 public static function jobdispatch($job, $payload)
	 {
		 global $app;
		 
		 // Add general data
		 $payload->open = round(microtime(true), 3);
		 $payload->access_token = Input::get('access_token');

		 return $app->jobserver->request($job, $payload);
	 }
}
