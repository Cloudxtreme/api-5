<?php

define ('APP_SECRET_KEY', 'bmgroup tickee catlab pineapple orange');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


// ----------------------------------------------------------------------------
// This command allows to see the existing routes that are configured
// ----------------------------------------------------------------------------
// php artisan routes > x_routes.txt
// ----------------------------------------------------------------------------


// ----------------------------------------------------------------------------
// Setup OAuth2 routing
// ----------------------------------------------------------------------------
// GET => /oauth2/
// GET => /oauth2/requesttoken
// GET => /oauth2/accesstoken
// GET => /oauth2/authorize/web
// ----------------------------------------------------------------------------
Route::group(['prefix' => 'oauth2'], function()
{
	
	//echo "GROUP OAUTH";
	/*
	App::singleton('oauth2', function() {
	
		$storage = new OAuth2\Storage\Pdo(array('dsn' => 'mysql:dbname='. DB_NAME .';host='. DB_HOST, 'username' => DB_USERNAME, 'password' => DB_PASSWORD));
		$server = new OAuth2\Server($storage);
	
		$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
		$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
	
		return $server;
	});
	*/
	
	//App::singleton('oauth2')->
	
	
	//GET => /oauth2/authorize/web
	//Route::get('authorize/web', 'OAuth2Controller@getAuthorizeWeb');
	
	//GET => /oauth2/authorize
	//Route::get('authorize', 'OAuth2Controller@getAuthorize');
	
	Route::any('authorize', array('before' => 'check-authorization-params', 'uses' => 'OAuth2Controller@getAuthorize'));
	
	
	//Route::get('authorize', array('before' => 'check-authorization-params|auth', 'OAuth2Controller@getAuthorizes'));
	
	// ----------------------------------------------------------------------------
	// POST => /oauth2/authorize/web
	// ----------------------------------------------------------------------------
	Route::post('access_token', 'OAuth2Controller@postAccessToken');
	
	/*
	Route::get('authorize', array('before' => 'check-authorization-params', function()
	{
	
	}));
	*/
	
	
	// ----------------------------------------------------------------------------
	// 
	// ----------------------------------------------------------------------------
	
	/*Route::get('authorize', array('before' => 'check-authorization-params|auth', function()
	{
		// get the data from the check-authorization-params filter
		$params = Session::get('authorize-params');
	
		// get the user id
		$params['user_id'] = Auth::user()->id;
	
		// display the authorization form
		return View::make('authorization-form', array('params' => $params));
	}));*/
	
	
	// ----------------------------------------------------------------------------
	//
	// ----------------------------------------------------------------------------
	/*
	Route::post('authorize', array('before' => 'check-authorization-params|auth|csrf', function()
	{
		// get the data from the check-authorization-params filter
		$params = Session::get('authorize-params');
	
		// get the user id
		$params['user_id'] = Auth::user()->id;
	
		// check if the user approved or denied the authorization request
		if (Input::get('approve') !== null) {
	
			$code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);
	
			Session::forget('authorize-params');
	
			return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
		}
	
		if (Input::get('deny') !== null) {
	
			Session::forget('authorize-params');
	
			return Redirect::to(AuthorizationServer::makeRedirectWithError($params));
		}
	}));
	*/
	
	/*
	Route::post('oauth/access_token', function()
	{
		return AuthorizationServer::performAccessTokenFlow();
	});
	*/
	
	//GET => /oauth2/
	//GET => /oauth2/requesttoken
	//GET => /oauth2/accesstoken
	//Route::controller('', 'OAuth2Controller');
});

// ----------------------------------------------------------------------------
// Setup account routing [API / V2]
// ----------------------------------------------------------------------------

Route::group(['prefix' => 'api'], function()
{
    Route::group(['prefix' => 'v2', 'namespace' => 'Api\\V2'], function()
    {
    	//GET => /api/v2/accounts/{id}/test
        Route::get('accounts/{id}/test', 'AccountController@test');
        
        //POST => /api/v2/accounts/{id}/test
        Route::post('accounts/{id}/test', 'AccountController@test_post');
        
        //DELETE => /api/v2/accounts/{id}/test
        Route::delete('accounts/{id}/test', 'AccountController@test_delete');
        
        //GET => /api/v2/accounts/
        //GET => /api/v2/accounts/info
        //GET => /api/v2/accounts/etc
        Route::resource('accounts', 'AccountController');
    });
});

// ----------------------------------------------------------------------------
// DEMO - OAUTH2 Authentication
// ----------------------------------------------------------------------------

Route::group(['prefix' => 'demo', 'namespace' => 'Demo'], function()
{
	//GET => /demo/oauth2/authorize
	Route::get('oauth2/authorize', 'DemoController@getOauth2Authorize');
	
	//GET => /demo/access_token
	Route::get('access_token', 'DemoController@getAccessToken');
	
	// Authenticate request /demo/test_user
	//Route::get('test_user', array('before' => 'check_oauth', 'uses' => 'DemoController@getTestUser'));
	//Route::get('test_user', array('before' => 'check-authorization-params', 'uses' => 'DemoController@getTestUser'));

	// POST & GET => /demo/test_user
	//Route::any('test_user', array('before' => 'check-authorization-params', 'uses' => 'DemoController@getTestUser'));
	
});

//Route::filter('check-authorization-params1', 'League\OAuth2\Server\Filters\CheckAuthorizationParamsFilter');
Route::filter('check-authorization-params', 'demo\DemoController@CheckAuthorizationParamsFilter');



//Route::filter('check-authorization-params', '\\League\\OAuth2\\Server\\Filters\\CheckAuthorizationParamsFilter');

// filter to check if the auth code grant type params are provided
//Route::filter('check-authorization-params', 'LucaDegasperi\OAuth2Server\Filters\CheckAuthorizationParamsFilter');

// make sure an endpoint is accessible only by authrized members eventually with specific scopes
//Route::filter('oauth', 'LucaDegasperi\OAuth2Server\Filters\OAuthFilter');

// make sure an endpoint is accessible only by a specific owner
//Route::filter('oauth-owner', 'LucaDegasperi\OAuth2Server\Filters\OAuthOwnerFilter');


// before "auth"
Route::filter("check_oauth", function()
{
	// TODO: Check token, to be able to access API endpoint
	
	/*
	if (Input::server("token") !== $user->token)
	{
		App::abort(400, "Invalid token");
	}*/
});

// ----------------------------------------------------------------------------
// DEMO
// ----------------------------------------------------------------------------
// GET => /demo/
// GET => /demo/signin
// ----------------------------------------------------------------------------

//GET => /demo/test_user
//Route::get(['prefix' => 'test_user', 'namespace' => 'Demo', 'before' => 'auth'], 'DemoController@getTestUser');
//Route::get(['prefix' => 'test_user', 'namespace' => 'Demo', 'before' => 'auth'], 'DemoController@getTestUser');

//Route::group(['prefix' => 'demo/test_user', 'namespace' => 'Demo', 'before' => 'auth'], function() {
	//DemoController->getTestUser();
//});



//GET => /demo/
//GET => /demo/signin
Route::controller('demo', 'demo\\DemoController');

// ----------------------------------------------------------------------------
// Tests
// ----------------------------------------------------------------------------

Route::group(['prefix' => 'test', 'namespace' => 'Test'], function()
{
	//GET => /test/oauth2
	//GET => /test/test_oauth2
	Route::get('oauth2', 'TestOAuth2Controller@test_oauth2');
	Route::get('test_oauth2', 'TestOAuth2Controller@test_oauth2');
	
	//GET => /test/test_client_flow
	//Testing workflow of an API request
	//1. Authorize; 2. Access Token; 3. API call
	Route::get('test_client_flow', 'TestOAuth2Controller@test_client_flow');
	
	//GET => /test/test_oauth2_authorize
	//Test :: OAuth2 Authorize
	Route::get('test_oauth2_authorize', 'TestOAuth2Controller@test_oauth2_authorize');
	
	//GET => /test/worker
	//Test :: Send some text and return the text reversed (standard Gearman Worker test)
	Route::get('worker', 'TestOAuth2Controller@test_worker');
	/*
	Route::get('worker', function()
	{

		foreach (array(1,2,3) as $row) {
			echo "Adding $row<br />\n";
				
			Queue::push('gearman\\Services', array('action'=>'get_token', 'message' => 'Token №' . $row));
			
		}
		
	});
	*/
	//GET,POST => /test/get_user_details
	//Test :: Obtain user details by { "email", "password" }
	Route::any('get_user_details', 'TestOAuth2Controller@get_user_details');
	
	//GET,POST => /test/get_oauth2_authorize
	//Test (Gearman Server and Workers) :: Authorize Workflow
	Route::any('get_oauth2_authorize', 'TestOAuth2Controller@get_oauth2_authorize');
	
	//GET,POST => /test/get_oauth2_access_token
	//Test (Gearman Server and Workers) :: Access Token Workflow
	Route::any('get_oauth2_access_token', 'TestOAuth2Controller@get_oauth2_access_token');
	
	//GET => /test/show_settings
	Route::get('show_settings', 'TestOAuth2Controller@show_settings');
	
});


// The All Catching One
Route::any ('/proxy/{path?}', function ($path) {
		
	$request = \Neuron\Net\Request::fromInput ($path);
	
	//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));
	$segments = Request::segments ();
	array_shift ($segments);
	
	$request->setSegments ($segments);

	$client = new GearmanClient ();
	$client->addServer ('localhost', 4730);

	$data = $client->doHigh ('apiDispatch', $request->toJSON ());
	$response = \Neuron\Net\Response::fromJSON ($data);

	// Hack the body for forms
	if ($response->getBody ())
	{
		$body = $response->getBody ();
		$body = str_replace ('action="http://cloudwalkers-api.local/', 'action="http://cloudwalkers-api.local/proxy/', $body);
		$response->setBody ($body);
	}

	$response->output ();
	//print_r ($response->getData ());
	exit;
	
	//return '<pre>' . print_r ($out, true) . '</pre>';
	

	//return Response::make($out['return'], 200, array('content-type' => 'application/json'));

	//return $request->getJSON ();
	
})->where ('path', '.+');