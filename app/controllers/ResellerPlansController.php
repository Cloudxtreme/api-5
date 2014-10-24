<?php

/**
 *	ResellerPlans Nested Controller
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
class ResellerPlansController extends BaseController {

	/**
	 *	Validation Rules
	 *	Based on Laravel Validation
	 */
	protected static $getRules = array
	(
		'id'    => 'required|integer'
	);
	
	protected static $showRules = array
	(
		'id'    => 'required|integer',
        'planid'=> 'required|integer'
    );

    protected static $postRules = array
    (
        'resellerid'    => 'required|integer',
        'name'          => 'required|min:2',
        'adminslimit'   => 'required',
        'userslimit'    => 'required',
        'serviceslimit' => 'required',
        'keywordslimit' => 'required',
        'followinglimit'=> 'required',
    );

    protected static $putRules = array
    (
        'resellerid'    => 'required|integer',
        'planid'        => 'required|integer',
        'name'          => 'required|min:2'
    );

	
	/**
	 *	RESTful actions
	 */
	 
	/**
	 *	Get Resellers plans
	 *
	 *	@return array
	 */
	public function index ($id)
	{
        // Validation parameters
        $input = array();

        $input['id'] = $id;

        // Request Foreground Job
		$response = self::restDispatch ('index', 'ResellerPlansController', $input, self::$getRules);
		
		return $response;
	}
	
	/**
	 *	Store Plan to Reseller
	 *
	 *	@return object
	 */
	public function store ($resellerid)
	{
        // Validation parameters
        Input::merge(array ('resellerid'=> $resellerid));

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'ResellerPlansController', Input::all(), self::$postRules);

        return $response;

	}	
	
	/**
	 *	Get Reseller plan
	 *
	 *	@return object
	 */
	public function show ($resellerid, $id)
	{
		// Validation parameters
		$input = array ('id'=> $resellerid, 'planid'=> $id);

		// Request Foreground Job
		$response = self::restDispatch ('show', 'ResellerAccountsController', $input, self::$showRules);
			
		return $response;
	}
	
	/**
	 *	Update Reseller plan
	 *
	 *	@return object
	 */
	public function update ($resellerid, $planid)
	{
        // Validation parameters
        Input::merge(array ('resellerid'=> $resellerid, 'planid'=> $planid));

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('update', 'ResellerPlansController', Input::all(), self::$postRules);

        return $response;
	}

}
