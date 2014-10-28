<?php

/**
 *	Plan Controller
 *	The plan controller uses the Laravel RESTful Resource Controller method.
 *
 *	[http://laravel.com/docs/4.2/controllers#restful-resource-controllers]
 *
 *	Following routes are supported
 *	GET			/resource		                index		resource.index
 *	POST		/resource		                store		resource.store
 *	GET			/resource/{resource}            show		resource.show
 *	PUT/PATCH	/resource/{resource}	        update		resource.update
 *	DELETE		/resource/{resource}	        destroy		resource.destroy
 */
class PlanController extends BaseController {

	/**
	 *	Validation Rules
	 *	Based on Laravel Validation
	 */
	
	protected static $showRules = array
	(
		'id'    => 'required|integer'
    );

    protected static $postRules = array
    (
        'name'          => 'required|min:2',
        'adminslimit'   => 'required',
        'userslimit'    => 'required',
        'serviceslimit' => 'required',
        'keywordslimit' => 'required',
        'followinglimit'=> 'required',
    );

    protected static $putRules = array
    (
        'id'            => 'required|integer',
        'name'          => 'required|min:2'
    );

	
	/**
	 *	RESTful actions
	 */
	 
	/**
	 *	Get plans
	 *
	 *	@return array
	 */
	public function index ()
	{
        // Request Foreground Job
		$response = self::restDispatch ('index', 'PlanController', array(), array());
		
		return $response;
	}
	
	/**
	 *	Store Plan
	 *
	 *	@return object
	 */
	public function store ()
	{
        // Validation parameters
        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'PlanController', Input::all(), self::$postRules);

        return $response;

	}	
	
	/**
	 *	Get plan
	 *
     *  @param $id
	 *	@return object
	 */
	public function show ($id)
	{
		// Validation parameters
		$input = array ('id'=> $id);

		// Request Foreground Job
		$response = self::restDispatch ('show', 'PlanController', $input, self::$showRules);
			
		return $response;
	}
	
	/**
	 *	Update plan
	 *
     *  @param $id
	 *	@return object
	 */
	public function update ($id)
	{
        // Validation parameters
        Input::merge(array ('id'=> $id));

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('update', 'PlanController', Input::all(), self::$putRules);

        return $response;
	}

	/**
	 *	Delete plan
	 *
     *  @param $id
	 *	@return object
	 */
	public function destroy ($id)
	{
        // Validation parameters
        $input = array ('id'=> $id);

        // Request Foreground Job
        $response = self::restDispatch ('destroy', 'PlanController', $input, self::$showRules);

        return $response;
	}

}
