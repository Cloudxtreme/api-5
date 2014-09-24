<?php

class BaseController extends Controller 
{
	/**
	 * Defaults
	 */
	const display = 'full';
	
	protected static $inputRules = array
	(
		'display'=> '',
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

		if(!Input::get('display') && !isset($attributes['display']))
			
			$attributes['display'] = self::display;
		
		Input::merge($attributes);
		
		return Input::all();
	}
	
	/**
	 *	Dispatch
	 *	The basic controller action between API and Worker
	 */
	 public static function jobdispatch($job, $jobload)
	 {
		 global $app;
		 
		 // Add general data
		 $jobload->open = round(microtime(true), 3);
		 $jobload->access_token = Input::get('access_token');

		 return $app->jobserver->request($job, $jobload);
	 }
}
