<?php

class AccountController extends BaseController {

	/**
	 * Defaults
	 */
	protected static $validationRules = array
	(
		'id'=> 'required|integer'
	);
	
	/**
	 *	Get Account by id.
	 *	The response validation is set in schemas.
	 *
	 *	@return array
	 */
	public function get($id = null)
	{	
		// Validate
		self::validate (array ('id'=> $id));
	
		// Request Foreground Job
		$response = self::jobdispatch ( 'controllerDispatch', (object) array
		(
			'action'=> 'get',
			'controller'=> 'AccountController', 
			'payload'=> array_intersect_key (Input::all(), array_merge(self::$validationRules, self::$inputRules))
		));
		
		return $response;
		
		// Return schema based response
		// return SchemaValidator::validate ($response, 'account')->intersect;
	}
	
	/**
	 * Validate Input
	 * Retruns Laravel Validator object
	 *
	 * @return Validator
	 */
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

}