<?php

class BaseController extends Controller 
{
	/**
	 * Defaults
	 */
	const format = 'full';
	
	protected static $inputRules = array
	(
		'format'=> '',
		'access_token'=> ''
	);


	/**
	 * Provide all required parameters to Input
	 * Returns all input attibutes in array
	 *
	 * @return array
	 */
	protected static function prepInput($attributes)
	{
		
		if(!Input::get('format') && !isset($attributes['format']))
			
			$attributes['format'] = self::format;
		
		Input::merge($attributes);
		
		return Input::all();
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
