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
	 * @return Validator
	 */
	public static function validate ($input, $rules = null)
	{
		// Add path attributes
		$input = self::prepInput ($input);
		
		
		// Perform validation
		$validator = Validator::make ($input, array_merge ($rules ?: self::$inputRules, self::$baseValidationRules));
		
		
		//exit(json_encode($validator->fails()));
		
		// Check if the validator failed
		return $validator->fails()?
		
			App::abort(400, $validator->messages()) :
			$validator;
	}
	
	/**
	 * Validate Input
	 * Retruns Laravel Validator object
	 *
	 * @return Validator
	 
	public static function validate ($input)
	{
		// Add path attributes
		$input = self::prepInput ($input);
		
		// Perform validation
		$validator = Validator::make ($input, array_merge(self::$inputRules, self::$validationRules));
		
		
		// Check if the validator failed
		return $validator->fails()?
		
			Redirect::to(400)->withErrors($validator) :
			$validator;
	}
	*/
	
	
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
		// Validation
		if (is_array ($input))
		{
			self::validate ($input, $rules);
			$payload = array_intersect_key (Input::all(), array_merge ($rules, self::$baseValidationRules));
		}
		

		// Request Foreground Job
		return self::jobdispatch ( 'controllerDispatch', (object) array
		(
			'action'=> $method,
			'controller'=> $controller, 
			'payload'=> isset ($payload)? $payload: self::prepInput (array ())
		));
	}
}
