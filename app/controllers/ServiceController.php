<?php

/**
 *	Accounts Controller
 *	The accounts controller uses the Laravel RESTful Resource Controller method.
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
class ServiceController extends BaseController {

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
		'token'=> 'required|min:5'
	);	
	
	
	/**
	 *	RESTful actions
	 */
	 
	/**
	 *	Get Accounts
	 *
	 *	@return array
	 */
	public function index ($id, $secondid = null)
	{
		$input = array('id'=> $secondid?: $id);
		
		// Request Foreground Job
		$response = self::restDispatch ('index', 'ServiceController', $input, self::$getRules);
		
		return $response;
	}
	
	/**
	 *	Post Account
	 *
	 *	@return object
	 */
	public function store ($accountid = null, $token = null)
	{
		// Validation parameters
		$input = array();
		
		if ($accountid)
			$input['accountid'] = $accountid;
		
		if ($token)
			$input['token'] = $token;

		exit(json_encode($input));
		
		// Request Foreground Job
		$response = self::restDispatch ('store', 'ServiceController', $input, self::$postRules);
			
		return $response;
	}	
	
	/**
	 *	Get Account
	 *
	 *	@return object
	 */
	public function show ($id)
	{
		// Validation parameters
		$input = array ('id'=> $id);
		
		// Request Foreground Job
		$response = self::restDispatch ('show', 'ServiceController', $input, self::$getRules);
			
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
		$response = self::restDispatch ('update', 'ServiceController', $input, self::$updateRules);
		
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
		$response = self::restDispatch ('destroy', 'ServiceController', $input, self::$getRules);
		
		return $response;
	}
}
