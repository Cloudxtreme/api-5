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
class StreamController extends BaseController {

	/**
	 *	Validation Rules
	 *	Based on Laravel Validation
	 */
	protected static $getRules = array
	(
		'id'=> 'required|integer',
        'ids'=> ''
    );
	
	protected static $updateRules = array
	(
		'id'=> 'required|integer',
        'active'=> 'required|integer'
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
	 *	Get Streams
	 *
     * @param $id
     * @return Job
     * @throws InvalidParameterException
     * @throws WorkerException
     */
	public function index ($id = null)
	{
        $input = null;
        $rules = null;

        if (!$id && !Input::get('ids'))

            throw new InvalidParameterException ('A parent ID or ids list should be provided.');


        if ($id)
        {
            $input['id'] = $id;
            $rules = self::$getRules;
        }

        if (Request::segment(4) == 'streamids') $input['display'] = 'id';

		
		// Request Foreground Job
		$response = self::restDispatch ('index', 'StreamController', $input, $rules);
		
		return $response;
	}

	/**
	 *	Get Stream Actions
	 *
	 *	@return array
	 */
	public function actions ($id, $secondid = null)
	{
		$input = array('id'=> $secondid?: $id);

		// Request Foreground Job
		$response = self::restDispatch ('actions', 'StreamController', $input, self::$getRules);

		return $response;
	}
	
	/**
	 *	Store stream
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
		$response = self::restDispatch ('store', 'StreamController', $input, self::$postRules);
			

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
		$response = self::restDispatch ('show', 'StreamController', $input, self::$getRules);
			
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

        // used to merge the raw input (as is done by v1)
        Input::merge((array)json_decode(Input::getContent()));

		// Request Foreground Job
		$response = self::restDispatch ('update', 'StreamController', $input, self::$updateRules);
		
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
		$response = self::restDispatch ('destroy', 'StreamController', $input, self::$getRules);
		
		return $response;
	}

    /**
     * Get stream besttimetopost
     *
     * @param $id
     * @return Job
     * @throws WorkerException
     */
    public function besttimetopost($id)
    {
        // Validation parameters
        $input = array ('id'=> $id);

        // Request Foreground Job
        $response = self::restDispatch ('besttimetopost', 'StreamController', $input, self::$getRules);

        return $response;
    }

    /**
     * Force refresh stream
     *
     * @param $id
     * @return Job
     * @throws WorkerException
     */
    public function refresh($id)
    {
        // Validation parameters
        $input = array ('id'=> $id);

        // Request Foreground Job
        $response = self::restDispatch ('refresh', 'StreamController', $input, self::$getRules);

        return $response;
    }
}
