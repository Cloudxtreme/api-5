<?php

class OAuth2Controller extends \BaseController {

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

	public function getIndex()
	{
		return 'OAUTH2 Index';
	}

	//public function getAuthorize()
	//{
		//return '» OAUTH2 Authorize';
	//}
	
	public function getAuthorizeWeb()
	{
		return '» OAUTH2 AuthorizeWeb';
	}
	
	public function getAccess()
	{
		return '» OAUTH2 Access';
	}

	public function getAccesstokens()
	{
		return '» OAUTH2 AccessTokens';
	}
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		var_dump($parameters);
	}
	
}
