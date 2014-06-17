<?php

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
	
	App::singleton('oauth2', function() {
	
		$storage = new OAuth2\Storage\Pdo(array('dsn' => 'mysql:dbname='. DB_NAME .';host='. DB_HOST, 'username' => DB_USERNAME, 'password' => DB_PASSWORD));
		$server = new OAuth2\Server($storage);
	
		$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
		$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
	
		return $server;
	});
	
	//App::singleton('oauth2')->
	
	
	//GET => /oauth2/authorize/web
	//Route::get('authorize/web', 'OAuth2Controller@getAuthorizeWeb');
	
	//GET => /oauth2/authorize
	//Route::get('authorize', 'OAuth2Controller@getAuthorize');
	
	//Route::get('authorize', array('before' => 'check-authorization-params|auth', 'OAuth2Controller@getAuthorizes'));
	
	// ----------------------------------------------------------------------------
	// POST => /oauth2/authorize/web
	// ----------------------------------------------------------------------------
	Route::post('access_token', 'OAuth2Controller@postAccessToken');
	
	
	// ----------------------------------------------------------------------------
	// 
	// ----------------------------------------------------------------------------
	
	Route::get('authorize', array('before' => 'check-authorization-params|auth', function()
	{
		// get the data from the check-authorization-params filter
		$params = Session::get('authorize-params');
	
		// get the user id
		$params['user_id'] = Auth::user()->id;
	
		// display the authorization form
		return View::make('authorization-form', array('params' => $params));
	}));
	
	// ----------------------------------------------------------------------------
	//
	// ----------------------------------------------------------------------------
	
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
	Route::get('test_user', array('before' => 'check_oauth', 'uses' => 'DemoController@getTestUser'));
	
});

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
	Route::get('oauth2', 'TestOAuth2Controller@test_oauth2');
	
	//GET => /test/oauth2auth
	Route::get('oauth2auth', 'TestOAuth2Controller@test_oauth2_authorize');
});



