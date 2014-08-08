<?php

use \League\OAuth2\Server\Storage\PDO\Db as DBOauth;

//new ClientModel, new SessionModel, new ScopeModel
use \League\OAuth2\Server\Storage\PDO\Client as ClientModel;
use \League\OAuth2\Server\Storage\PDO\Session as ClientSession;
use \League\OAuth2\Server\Storage\PDO\Scope as ClientScope;

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
	
	//public $restful = true;
	
	public $db_oauth2 = null;
	
	public function __construct()
	{
		// --------------------------------------------------------------------
		// LOAD CONFIGURATION FROM BASE CONTROLLER
		// --------------------------------------------------------------------
		parent::__construct();
		
		// --------------------------------------------------------------------
		// MYSQL CONNECTION
		// --------------------------------------------------------------------
		
		// Initiate the request handler which deals with $_GET, $_POST, etc
		$request = new \League\OAuth2\Server\Util\Request();
	
		// Initiate a new database connection
		//$db = new League\OAuth2\Server\Storage\PDO\Db('mysql://user:pass@localhost/oauth');
		
		// Initiate a new database connection
		$dsn = DB_OAUTH2_PROTOCOL . ':host='. DB_OAUTH2_HOST .';port='. DB_OAUTH2_PORT .';dbname='. DB_OAUTH2_NAME;
		$username = DB_OAUTH2_USERNAME;
		$password = DB_OAUTH2_PASSWORD;
		
		$options = null;
		
		// --------------------------------------------------------------------
		// OAUTH2
		// --------------------------------------------------------------------
		
		// Initiate the request handler which deals with $_GET, $_POST, etc
		$request = new \League\OAuth2\Server\Util\Request();
		
		
		// Create the auth server, the three parameters passed are references
		// to the storage models
		$this->authserver = new \League\OAuth2\Server\Authorization(
				//new ClientModel, new SessionModel, new ScopeModel
				new \League\OAuth2\Server\Storage\PDO\Client,
				new \League\OAuth2\Server\Storage\PDO\Session,
				new \League\OAuth2\Server\Storage\PDO\Scope
		);
		
		// Enable the authorization code grant type
		//$this->authserver->addGrantType(new \League\OAuth2\Server\Grant\AuthCode($this->authserver));
		//$this->authserver->addGrantType();
				
		// Create the auth server, the three parameters passed are references
		//  to the storage models
		/*$this->authserver = new League\OAuth2\Server\Authorization(
				new ClientModel,
				new SessionModel,
				new ScopeModel
		);*/
		
		// Enable the authorization code grant type
		$this->authserver->addGrantType(new League\OAuth2\Server\Grant\AuthCode());
		
		$server = $this->authserver;
		
	}

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
		
		// Get the user ID
		//$params['user_id'] = Session::get('user_id');
		
		$params['user_id'] = Session::get('client_id');
		
		if (empty($params)) die('FILTER :: check-authorization-params returned empty'); 
		
		//echo var_export(Auth::user()); die('OAuth2Controller.getAuthorize');
		//echo var_export($params); die('OAuth2Controller.getAuthorize');
		
		// get the user id
		//$params['user_id'] = Auth::user()->id;
		
		// display the authorization form
		//return View::make('authorization-form', array('params' => $params));
		
		// Generate an authorization code
		$code = $this->authserver->getGrantType('authorization_code')->newAuthoriseRequest('user', $params['user_id'], $params);
		
		// Redirect the user back to the client with an authorization code
		/*
		return Redirect::to(
			League\OAuth2\Server\Util\RedirectUri::make($params['redirect_uri'],
				array(
					'code'  =>  $code,
					'state' =>  isset($params['state']) ? $params['state'] : ''
				)
			));
		*/
		
		return json_encode(array(
				'code'  =>  $code,
				'state' =>  isset($params['state']) ? $params['state'] : ''
			)); 
		
		//return '» OAUTH2 Authorize';
	}
	
	public function postAccessToken()
	{
		
		//$this->authserver->isValid();
		
		//return;
		
		try {
		
			// Tell the auth server to issue an access token
			$response = $this->authserver->issueAccessToken();
			
			//var_export($response); die('OAuth2Controller.postAccessToken');
		
		} catch (\League\OAuth2\Server\Exception\ClientException $e) {
		
			// Throw an exception because there was a problem with the client's request
			$response = array(
					'error' =>  $this->authserver->getExceptionType($e->getCode()),
					'error_description' => $e->getMessage()
			);
		
			//var_export($response); die('OAuth2Controller.postAccessToken');
			
			// Set the correct header
			@header($this->authserver->getExceptionHttpHeaders($this->authserver->getExceptionType($e->getCode())));
		
		} catch (Exception $e) {
		
			// Throw an error when a non-library specific exception has been thrown
			$response = array(
					'error' =>  'undefined_error',
					'error_description' => $e->getMessage()
			);
		}
		
		@header('Content-type: application/json');
		echo json_encode($response);
		
		
		
		//return AuthorizationServer::performAccessTokenFlow();
		
		//return '» POST OAUTH2 Access Token';
	}

	public function getAccesstoken()
	{
		
		
		return '» OAUTH2 AccessToken';
	}
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		var_dump($parameters);
	}
	
}
