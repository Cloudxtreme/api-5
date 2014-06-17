<?php

namespace Demo;

use \Session as Session;
use \Input as Input;
use \View as View;
use \Redirect as Redirect;
use \League\OAuth2\Server\Util\RedirectUri as RedirectUri;
use \League\OAuth2\Server\Storage\PDO\Db as DBOauth;

class DemoController 
	extends \BaseController 
	//implements \BaseController 
{

	/*
	|--------------------------------------------------------------------------
	| Demo Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	
	public $db = null;         // Database connection
	public $db_oauth2 = null;  // OAuth2 connection
	public $authserver = null; // OAuth2 server object
	
	
	public function __construct() {
		
		@session_start();
		//ini_set('display_errors', true);
		//error_reporting(-1);
		
		// --------------------------------------------------------------------
		// LOAD CONFIGURATION FROM BASE CONTROLLER
		// --------------------------------------------------------------------
		parent::__construct();
		
		//include_once dirname(__FILE__) .'/../../../app/config/mutable-local.php';
		
		// --------------------------------------------------------------------
		// MYSQL CONNECTION
		// --------------------------------------------------------------------
		
		// Initiate a new database connection
		$dsn = DB_PROTOCOL . ':host='. DB_HOST .';port='. DB_PORT .';dbname='. DB_NAME;
		$username = DB_USERNAME;
		$password = DB_PASSWORD;
		
		$options = null; 
		/*
		$options = array(
	 		\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		);
		*/

		//echo "SQL: $dsn<br />";
		
		$this->db = new DBOauth($dsn, $username, $password, $options);
		
		unset($dsn, $username, $password);
		
		// --------------------------------------------------------------------
		// OAUTH2 CONNECTION
		// --------------------------------------------------------------------
		
		// Initiate a new database connection
		$dsn = DB_OAUTH2_PROTOCOL . ':host='. DB_OAUTH2_HOST .';port='. DB_OAUTH2_PORT .';dbname='. DB_OAUTH2_NAME;
		$username = DB_OAUTH2_USERNAME;
		$password = DB_OAUTH2_PASSWORD;
		
		$options = null;
		
		//die($dsn);
		
		$this->db_oauth2 = new DBOauth($dsn, $username, $password, $options);
		
		unset($dsn, $username, $password);
		
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
		$this->authserver->addGrantType(new \League\OAuth2\Server\Grant\AuthCode($this->authserver));
		
		
		$server = $this->authserver;
		
		$checkToken = function () use ($server) {
	
		    return function() use ($server)
		    {
		        // Test for token existance and validity
		        try {
		            $server->isValid();
		        }
				// The access token is missing or invalid...
				catch (League\OAuth2\Server\Exception\InvalidAccessTokenException $e)
				{
					//$app = \Slim\Slim::getInstance();
					//$res = $app->response();
					//$res['Content-Type'] = 'application/json';
					//$res->status(403);
		
					//$res->body(json_encode(array(
							//'error' =>  $e->getMessage()
					//)));
				}
			};
		};
		
		
		
	}
	
	public function getIndex()
	{
		//Show index page
		$data = array();
		
		return View::make('demo/oauth-index', $data);
	}
	
	public function getBackhome()
	{
		// Show back home page
		$data = 'Hello, back home!';
	
		return $data;
	}
	
	public function getTestUser(){
		
		//$user_model = new UserModel();
		
		//$user = $user_model->getUser($id);
		
		$user = array(
			'user_id'   => 1,
			'firstname' => 'Roberto',
			'lastname'  => 'S'
		);
		
		if ( ! $user)
		{
			$res = $app->response();
			$res->status(404);
			$res['Content-Type'] = 'application/json';
			$res->body(json_encode(array(
					'error' => 'User not found'
			)));
		}
		
		else
		{
			// Basic response
			$response = array(
					'error' => null,
					'result'    =>  array(
							'user_id'   =>  $user['user_id'],
							'firstname' =>  $user['firstname'],
							'lastname'  =>  $user['lastname']
					)
			);
		
			// If the acess token has the "user.contact" access token include
			//  an email address and phone numner
			/*if ($this->authserver->hasScope('user.contact'))
			{
				$response['result']['email'] = $user['email'];
				$response['result']['phone'] = $user['phone'];
			}*/
		
			// Respond
			//$res = $app->response();
			//$res['Content-Type'] = 'application/json';
		
			//$res->body(json_encode($response));
			
			
		}
		
		
		return "Test User";
	}
	

	public function getOauth2()
	{

		try {
		
			// Tell the auth server to check the required parameters are in the
			//  query string
			$params = $this->authserver->getGrantType('authorization_code')->checkAuthoriseParams();
		
			// Save the verified parameters to the user's session
			Session::put('client_id', $params['client_id']);
			Session::put('client_details', $params['client_details']);
			Session::put('redirect_uri', $params['redirect_uri']);
			Session::put('response_type', $params['response_type']);
			Session::put('scopes', $params['scopes']);
		
			// Redirect the user to the sign-in route
			return Redirect::to('/oauth/signin');
		
		} catch (Oauth2\Exception\ClientException $e) {
		
			// Throw an error here which says what the problem is with the
			//  auth params
		
		} catch (Exception $e) {
		
			// Throw an error here which has caught a non-library specific error
		
		}
		
		//return 'DEMO Index';
		
	}
	
	public function getSignin()
	{
		$params = null;
		
		return View::make('demo/oauth-signin', array('params'=>$params));
	}
	
	public function postSignin()
	{
		// Retrieve the auth params from the user's session
		$params['client_id'] = Session::get('client_id');
		$params['client_details'] = Session::get('client_details');
		$params['redirect_uri'] = Session::get('redirect_uri');
		$params['response_type'] = Session::get('response_type');
		$params['scopes'] = Session::get('scopes');
	
		// Check that the auth params are all present
		/*foreach ($params as $key=>$value) {
			if ($value === null) {
				// Throw an error because an auth param is missing - don't
				//  continue any further
			}
		}*/
		
		// Process the sign-in form submission
		if (Input::get('signin') !== null) {
			
			try {
	
				// Get username
				$email = trim(strtolower(Input::get('email')));
				
				// Get password
				$password = Input::get('password');
				
				if ("$email" == '') {
					throw new \Exception('Please enter your email.');
				}
				
				if ("$password" == '') {
					throw new \Exception('Please enter your password.');
				}
	
				//die("$email, $password");
				
				// Verify the user's username and password
				// Set the user's ID to a session

				// But first we reset session
				//Session::put('user_id', null);
				
				//$email = $this->db->escape($email);
				//$password = $this->db->escape($password);
		
				$sql = "SELECT
							u.u_id as u_id,
							u.u_email as u_email
						FROM
							users u
						WHERE
							u.u_email = :email AND 
							u.u_password = MD5(CONCAT(:password, u.u_salt));";
				
				$params = array(
					':email' => $email,
					':password' => $password
						
				);
				
				//Query user details
				$rows = $this->db->queryAndFetchAll($sql, $params);
				
				// Clear sensitive information
				unset($email, $password, $params);
				
				// Check if the row exists and is valid
				$row = isset($rows[0]) && is_array($rows[0]) ? $rows[0] : null;
				
				$u_id = isset($row['u_id']) ? $row['u_id'] : '';
				$u_email = isset($row['u_email']) ? $row['u_email'] : '';

				//die("USER DETAILS: $u_id, $u_email");
				
				if ("$u_id" == '' || "$u_email" == '') {
					Session::put('user_id', null);
					Session::put('user_email', null);
					
					Session::put('client_id', 'invalid-user-id');
					Session::put('client_details', '');
					Session::put('redirect_uri', '/demo/');
					Session::put('response_type', '');
					Session::put('scopes', 'user');
					
					throw new \Exception('Login not found!');
				} else {
					Session::put('user_id', $u_id);
					Session::put('user_email', $u_email);
					
					Session::put('client_id', 'I6Lh72kTItE6y29Ig607N74M7i21oyTo');
					Session::put('client_details', '');
					Session::put('redirect_uri', 'http://cloudwalkers-api.local/demo/backhome');
					Session::put('response_type', '');
					Session::put('scopes', 'user');
					
					// TODO: Fix to get proper "user_id", "client_secret", etc
					Session::put('grant_type', 'client_credentials');
					Session::put('client_secret', 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ');
				}
				
				
			} catch (\Exception $e) {
				//die( $e->getMessage() );
				
				$params['error_message'] = $e->getMessage();
			}
		}
	
		// Get the user's ID from their session
		$params['user_id'] = Session::get('user_id');

		//echo "USER: ". Session::get('user_id') ."<br />";
		
		// User is signed in
		if ($params['user_id'] !== null) 
		{
			// Redirect the user to /oauth/authorise route
			return Redirect::to('/demo/oauth2/authorize');
	
		} // User is not signed in, show the sign-in form
		else 
		{
			return View::make('demo/oauth-signin', array('params'=>$params));
		}
	}
	
	public function getOauth2Authorize()
	{

		// Retrieve the auth params from the user's session
		$params['client_id'] = Session::get('client_id');
		$params['client_details'] = Session::get('client_details');
		$params['redirect_uri'] = Session::get('redirect_uri');
		$params['response_type'] = Session::get('response_type');
		$params['scopes'] = Session::get('scopes');
	
		// Check that the auth params are all present
		foreach ($params as $key=>$value) {
			if ($value === null) {
				// Throw an error because an auth param is missing - don't
				//  continue any further
			}
		}
	
		// Get the user ID
		$params['user_id'] = Session::get('user_id');
	
		// User is not signed in so redirect them to the sign-in route (/oauth/signin)
		if ($params['user_id'] === null) {
			return Redirect::to('/demo/signin');
		}
	
		$params_auto_approve = isset($params['client_details']) && isset($params['client_details']['auto_approve']) ? $params['client_details']['auto_approve'] : false;  
		
		// Check if the client should be automatically approved
		$autoApprove = ($params_auto_approve === '1') ? true : false;
		
		//Bypass "authorize" form
		$autoApprove = true;
	
		// Process the authorise request if the user's has clicked 'approve' or the client
		if (Input::get('approve') !== null || $autoApprove === true) {
	
			// Generate an authorization code
			//$code = $server->getGrantType('authorization_code')->newAuthoriseRequest('user', $params['user_id'], $params);
			$code = $this->authserver->getGrantType('authorization_code')->newAuthoriseRequest('user', $params['user_id'], $params);
				
			// Redirect the user back to the client with an authorization code
			return Redirect::to(
					\League\OAuth2\Server\Util\RedirectUri::make($params['redirect_uri'],
							array(
									'code'  =>  $code,
									'state' =>  isset($params['state']) ? $params['state'] : ''
							)
					));
		}
	
		// If the user has denied the client so redirect them back without an authorization code
		if (Input::get('deny') !== null) {
			return Redirect::to(
					\League\OAuth2\Server\Util\RedirectUri::make($params['redirect_uri'],
							array(
									'error' =>  'access_denied',
									'error_message' =>  $this->authserver->getExceptionMessage('access_denied'),
									'state' =>  isset($params['state']) ? $params['state'] : ''
							)
					));
		}
	
		// The client shouldn't automatically be approved and the user hasn't yet
		//  approved it so show them a form
		return View::make('/demo/oauth-authorize', $params);
	}
	
	public function getAccessToken()
	{
		try {
	
			// Tell the auth server to issue an access token
			$response = $this->authserver->issueAccessToken();
	
		} catch (League\OAuth2\Server\Exception\ClientException $e) {
	
			// Throw an exception because there was a problem with the client's request
			$response = array(
					'error' =>  $this->authserver->getExceptionType($e->getCode()),
					'error_description' => $e->getMessage()
			);
	
			// Set the correct header
			header($this->authserver->getExceptionHttpHeaders($this->authserver->getExceptionType($e->getCode())));
	
		} catch (Exception $e) {
	
			// Throw an error when a non-library specific exception has been thrown
			$response = array(
					'error' =>  'undefined_error',
					'error_description' => $e->getMessage()
			);
		}
	
		header('Content-type: application/json');
		echo json_encode($response);
	}
	
	
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		echo "DemoController - Routing unknown: <br />\n";
		
		var_dump($parameters);
	}
	
}
