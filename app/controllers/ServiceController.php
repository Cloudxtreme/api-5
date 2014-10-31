<?php

/**
 *	Streams Controller
 *	The streams controller uses the Laravel RESTful Resource Controller method.
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

    protected static $getIdsRules = array
	(
		'ids'=> 'required'
	);
	
	protected static $updateRules = array
	(
		'id'=> 'required|integer'
	);

	protected static $authRules = array
	(
		'accountid'=> 'required|integer',
		'token'=> 'required|min:5',
		'redirect'=> 'required|url'
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
	 *	Get Services
	 *
	 *	@return array
	 */
	public function index ($id = null, $secondid = null)
	{

        if (!$id)
        {
            # /1.1/services GET (?ids)
            if (Input::get('ids'))

                $rules = self::$getIdsRules;


            # /1.1/services GET
            else

                $rules = null;


            $input = null;
        }

        else
        {
            # /1.1/accounts/id/serviceids GET
            # /1.1/accounts/id/services GET

            if (Request::segment(4) == 'serviceids')

                Input::merge(array('display', 'ids'));

            $input = array('id'=> $secondid?: $id);
            $rules = self::$getRules;
        }


        // Request Foreground Job
		$response = self::restDispatch ('index', 'ServiceController', $input, $rules);
		
		return $response;
	}
	
	/**
	 *	Authenticate service network
	 *
	 *	@return object
	 */
	public function authurl ($accountid = null, $token = null)
	{
		// Validation parameters
		$input = array();
		
		if ($accountid)
			$input['accountid'] = $accountid;
		
		if ($token)
			$input['token'] = $token;
		
		// Request Foreground Job
		$response = self::restDispatch ('authurl', 'ServiceController', $input, self::$authRules);
		
			
		// Or return error
		return $response;
	}
	
	/**
	 *	Store service
	 *	On network redirect - STRICT
	 *
	 *	@return object
	 */
	public function store ($accountid, $token)
	{
		// Validation parameters
		$input = array();
		
		$input['accountid'] = $accountid;	
		$input['token'] = $token;

		
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

    /**
     * Get available services
     *
     * @return object
     */
    public function available ()
    {
        // Request Foreground Job
        $response = self::restDispatch ('available', 'ServiceController', null, null);

        return $response;
    }
}
