<?php

// UTF8 :: àáâãä

namespace Api\V2;


class AccountController extends \BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public $restful = true;
	
	public function index()
	{
		return '» Account Index';
	}
	
	public function show($parameters = null)
	{
		return '» Account Show: '. $parameters;
	}
	
	public function test($parameters = null)
	{
		return '» GET - Account Test: '. $parameters;
	}
	
	public function test_post($parameters = null)
	{
		return '» POST - Account Test: '. $parameters;
	}
	
	public function test_delete($parameters = null)
	{
		return '» DELETE - Account Test: '. $parameters;
	}
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		var_dump($parameters);
	}
	
}
