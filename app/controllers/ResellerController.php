<?php

/**
 *	Reseller Controller
 *	The reseller controller uses the Laravel RESTful Resource Controller method.
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
class ResellerController extends BaseController {

	/**
	 *	Validation Rules
	 *	Based on Laravel Validation
	 */
	protected static $getRules = array
	(
		'id'=> 'required|integer'
	);
	
	protected static $updateRules = array
	(
		'id'=> 'required|integer'
	);

	protected static $postRules = array
	(
		'accountid'=> 'required|integer',
		'token'=> 'required|min:5',
		'redirect'=> 'required|url',
		'state'=> 'required',
		'code'=> 'required'
	);	
	
	/**
	 *	RESTful actions
	 */
	 
	/**
	 *	Get Resellers
	 *
	 *	@return array
	 */
	public function index ()
	{
		// Request Foreground Job
		$response = self::restDispatch ('index', 'ResellerController', null, null);
		
		return $response;
	}
	
	/**
	 *	Store Reseller
	 *	On network redirect - STRICT
	 *
	 *	@return object
	 */
	public function store ($accountid, $token)
	{
		// Validation parameters
		$input = array('accountid' => $accountid, 'token' => $token);

		
		// Request Foreground Job
		$response = self::restDispatch ('store', 'ResellerController', $input, self::$postRules);
			

		return $response;
	}	
	
	/**
	 *	Get Reseller
	 *
	 *	@return object
	 */
	public function show ($id)
	{
		// Validation parameters
		$input = array ('id'=> $id);
		
		// Request Foreground Job
		$response = self::restDispatch ('show', 'ResellerController', $input, self::$getRules);
			
		return $response;
	}
	
	/**
	 *	Update Account
	 *
	 *	@return object
	 */
	public function update ($id)
	{
		// Validation parameters
		$input = array ('id'=> $id);
	
		// Request Foreground Job
		$response = self::restDispatch ('update', 'ResellerController', $input, self::$updateRules);
		
		return $response;
	}
	
	/**
	 *	Delete Accounts
	 *
	 *	@return boolean
	 */
	public function destroy ($id)
	{
		// Validation parameters
		$input = array ('id'=> $id);
	
		// Request Foreground Job
		$response = self::restDispatch ('destroy', 'ResellerController', $input, self::$getRules);
		
		return $response;
	}
}
