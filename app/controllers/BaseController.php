<?php

class BaseController extends Controller 
{
	/**
	 * Defaults
	 */
	const display = 'full';
	
	protected static $baseValidationRules = array
	(
		'display'=> ''
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
	 * Validate Input
	 * Returns Laravel Validator object
	 *
	 * @throws Exception
	 */
	public static function validate ($input, $rules = array ())
	{
		// Add path attributes
		$input = self::prepInput ($input);
		
		
		// Perform validation
		$validator = Validator::make ($input, array_merge ($rules, self::$baseValidationRules));
		
		
		//exit(json_encode($validator->fails()));
		
		// Check if the validator failed
        if ($validator->fails())

		    throw new InvalidParameterException ( 'Parameters validation failed!', $validator->messages()->all() );

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
	
	 
	/**
	 *	REST Dispatch
	 *	Jobdispatch extension with validation
	 *
	 *	@return Job response
	 */
	public static function restDispatch ($method, $controller, $input = null, $rules = null)
	{
		# Validation
		if (is_array ($input))
		{
			self::validate ($input, $rules);
			$payload = array_intersect_key (Input::all(), array_merge ($rules, self::$baseValidationRules));
		}
		
		
		# Request Foreground Job
		$response = self::jobdispatch ( 'controllerDispatch', (object) array
		(
			'action'=> $method,
			'controller'=> $controller, 
			'payload'=> isset ($payload)? $payload: self::prepInput (array ())
		));
		
		# Error catching
		if (preg_match ('/error/', substr ($response, 2, 8)))
			
			throw new WorkerException ($response);
		
		# Return	
		return $response;
	}
}
