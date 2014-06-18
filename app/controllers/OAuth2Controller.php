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
		
		/*
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
		 */
		
		
		// Create the auth server, the three parameters passed are references
		//  to the storage models
		$this->authserver = new League\OAuth2\Server\Authorization(
				new ClientModel,
				new SessionModel,
				new ScopeModel
		);
		
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
		
		// get the user id
		$params['user_id'] = Auth::user()->id;
		
		// display the authorization form
		return View::make('authorization-form', array('params' => $params));
		
		//return '» OAUTH2 Authorize';
	}
	
	public function postAccessToken()
	{
		
		
		
		//return AuthorizationServer::performAccessTokenFlow();
		
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
