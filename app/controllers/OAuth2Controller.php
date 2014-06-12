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
	
	public function getAuthorize()
	{
		// get the data from the check-authorization-params filter
		$params = Session::get('authorize-params');
		
		// get the user id
		$params['user_id'] = Auth::user()->id;
		
		// display the authorization form
		return View::make('authorization-form', array('params' => $params));
		
		//return '» OAUTH2 Authorize';
	}
	
	public function postAccessToken()
	{
		return AuthorizationServer::performAccessTokenFlow();
		
		//return '» POST OAUTH2 Access Token';
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
