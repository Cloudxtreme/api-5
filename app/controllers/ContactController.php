<?php

class ContactController extends BaseController {
	
	/**
	 *	Get Contact
	 *	Based on ID
	 */
	public function get($accountId = null, $contactId = null)
	{
		// Add path attributes
		Input::merge(array('accountId'=> $accountId, 'id'=> $contactId));
		
		// Validation rules
		$rules = array('id'=> 'required|integer');
		
		// Validate
		$validator = Validator::make(Input::all(), $rules);
		
		// Check if the validator failed
		if ($validator->fails())
		
			return Redirect::to(400)->withErrors($validator);
		
		// Request Foreground Job
		$payload = (object) array('controller'=> 'ContactController', 'action'=> 'get', 'payload'=> array_intersect_key(Input::all(), $rules));
		
		$response = self::jobdispatch ('controllerDispatch', $payload);
		
		return SchemaValidator::validate (json_decode($response, true), 'contact')->intersect;
	}

}