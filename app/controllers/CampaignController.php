<?php

/**
 *	Campaigns Controller
 *	The campaigns controller uses the Laravel RESTful Resource Controller method.
 *
 *	[http://laravel.com/docs/4.2/controllers#restful-resource-controllers]
 *
 *	Following routes are supported
 *	GET			/resource				index		resource.index
 *	POST		/resource				store		resource.store
 *	GET			/resource/{resource}	show		resource.show
 *	PUT/PATCH	/resource/{resource}	update		resource.update
 *	DELETE		/resource/{resource}	destroy		resource.destroy
 */
class CampaignController extends BaseController {

	/**
	 *	Validation Rules
	 *	Based on Laravel Validation
	 */
	protected static $getRules = array
	(
		'id'=> 'required|integer'
	);
	
	
	/**
	 *	RESTful actions
	 */
	 
	/**
	 *	Get Account Campaigns
	 *
	 *	@return array
	 */
	public function index ()
	{
        return 'index';
		// Request Foreground Job
		$response = self::restDispatch ('index', 'AccountController');
		
		return $response;
	}
	
	/**
	 *	Post Campaign
	 *
	 *	@return object
	 */
	public function store ()
	{
        return 'store';

		// Validation parameters
        Input::merge((array)json_decode(Input::getContent()));
		
		// Request Foreground Job
		$response = self::restDispatch ('store', 'AccountController', Input::all(), self::$postRules);
			
		return $response;
		
		// Return schema based response
		// return SchemaValidator::validate ($response, 'account')->intersect;
	}	
	
	/**
	 *	Get Campaign
	 *
	 *	@return object
	 */
	public function show ($id)
	{
        return 'show';
		// Validation parameters
		$input = array ('id'=> $id);

		// Request Foreground Job
		$response = self::restDispatch ('show', 'AccountController', $input, self::$getRules);
			
		return $response;
		
		// Return schema based response
		// return SchemaValidator::validate ($response, 'account')->intersect;
	}
	
	/**
	 *	Update Account
	 *
	 *	@return object
	 */
	public function update ($id)
	{
        return 'update';
		// Validation parameters
        Input::merge(array ('id'=> (int) $id));

        Input::merge((array)json_decode(Input::getContent()));

		// Request Foreground Job
		$response = self::restDispatch ('update', 'AccountController', Input::all(), self::$updateRules);
		
		return $response;
		
		// Return schema based response
		// return SchemaValidator::validate ($response, 'account')->intersect;
	}
	
	/**
	 *	Delete Accounts
	 *
	 *	@return boolean
	 */
	public function destroy ($id)
	{
        return 'destroy';
		// Validation parameters
		$input = array ('id'=> $id);
	
		// Request Foreground Job
		$response = self::restDispatch ('destroy', 'AccountController', $input, self::$getRules);
		
		return $response;
	}


}
