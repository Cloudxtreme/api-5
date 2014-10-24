<?php

/**
 *	ResellerAccounts Nested Controller
 *	The reseller controller uses the Laravel RESTful Resource Controller method.
 *
 *	[http://laravel.com/docs/4.2/controllers#restful-resource-controllers]
 *
 *	Following routes are supported
 *	GET			/resource/{resource}/resource		                index		resource.index
 *	POST		/resource/{resource}/resource		                store		resource.store
 *	GET			/resource/{resource}/resource/{resource}            show		resource.show
 *	PUT/PATCH	/resource/{resource}/resource/{resource}	        update		resource.update
 *	DELETE		/resource/{resource}/resource/{resource}	        destroy		resource.destroy
 */
class ResellerAccountsController extends BaseController {

	/**
	 *	Validation Rules
	 *	Based on Laravel Validation
	 */
	protected static $getRules = array
	(
		'resellerid'=> 'required|integer'
	);
	
	protected static $showRules = array
	(
        'resellerid'=> 'required|integer',
		'id'=> 'required|integer'
	);

    protected static $postRules = array
    (
        'resellerid'=> 'required|integer',
        'name'=> 'required|min:2',
        'planid'=> 'required'
    );

    protected static $updateRules = array
    (
        'id'=> 'required|integer',
        'resellerid'=> 'integer',
        'name'=> 'required',
        'planid'=> 'required'
    );

	
	/**
	 *	RESTful actions
	 */
	 
	/**
	 *	Get Resellers
	 *
	 *	@return array
	 */
	public function index ($resellerid)
	{
        // Validation parameters
        $input = array();

        $input['resellerid'] = $resellerid;

        // Request Foreground Job
		$response = self::restDispatch ('index', 'ResellerAccountsController', $input, self::$getRules);
		
		return $response;
	}
	
	/**
	 *	Store Reseller
	 *	On network redirect - STRICT
	 *
	 *	@return object
	 */
	public function store ($accountid)
	{
		// Validation parameters
        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'AccountController', Input::all(), self::$postRules);

        return $response;
	}	
	
	/**
	 *	Get Reseller
	 *
	 *	@return object
	 */
	public function show ($resellerid, $id)
	{
		// Validation parameters
		$input = array ('resellerid'=> $resellerid, 'id'=> $id);

		// Request Foreground Job
		$response = self::restDispatch ('show', 'ResellerAccountsController', $input, self::$showRules);
			
		return $response;
	}
	
	/**
	 *	Update Reseller
	 *
	 *	@return object
	 */
	public function update ($resellerid, $id)
	{
		// Validation parameters
        Input::merge(array ('id'=> $id, 'resellerid'=> $resellerid));

        Input::merge((array)json_decode(Input::getContent()));
	
		// Request Foreground Job
		$response = self::restDispatch ('update', 'AccountController', Input::all(), self::$updateRules);
		
		return $response;
	}

}
