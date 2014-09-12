<?php

class ContactController extends BaseController {

	/**
	 *	Get Contact by id.
	 *	The response validation is set in schemas.
	 *
	 *	@return array
	 */
	public function get($accountId = null, $contactId = null)
	{
		// Add path attributes
		$input = self::prepInput(array('id'=> $contactId, 'accountId'=> $accountId));
		
		// Validation rules
		$rules = array('id'=> 'required|integer');
		
		// Validate
		$validator = Validator::make($input, array_merge(self::$inputRules, $rules));

		//return $validator->getValidated();
		
		// Check if the validator failed
		if ($validator->fails())
		
			return Redirect::to(400)->withErrors($validator);
		
		
		// Request jobload
		$jobload = (object) array('controller'=> 'ContactController', 'action'=> 'get', 'payload'=> array_intersect_key(Input::all(), $rules));
		
		// Request Foreground Job
		$response = self::jobdispatch ('controllerDispatch', $jobload);
		
		// Return schema based response
		return SchemaValidator::validate (json_decode($response, true), 'contact')->intersect;
	}

}