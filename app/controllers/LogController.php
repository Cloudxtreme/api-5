<?php

/**
 *	Log Controller
 *	The log controller uses the Laravel RESTful Resource Controller method.
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
class LogController extends BaseController {

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
	 *	Get Log data
	 *
	 *	@return array
	 */
	public function index ()
	{
        return 'index';
	}
	
	/**
	 *	Get Processed Log data
	 *
	 *	@return array
	 */
	public function digest ()
	{
		// Request Foreground Job
		$response = self::restDispatch ('digest', 'LogController');
		
		return $response;
	}

	
	/**
	 *	Post Log entry
	 *
	 *	@return object
	 */
	public function store ()
	{
        return 'store';
	}	
	
	/**
	 *	Get Log
	 *
	 *	@return object
	 */
	public function show ($id)
	{
        return 'show';
	}
	
	/**
	 *	Update Log
	 *
	 *	@return object
	 */
	public function update ($id)
	{
        return 'update';
	}
	
	/**
	 *	Delete Logs
	 *
	 *	@return boolean
	 */
	public function destroy ($id)
	{
        return 'destroy';
	}


}
