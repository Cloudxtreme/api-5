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

	
	// GET => /oauth2/authorize
	//        Filter "check-authorization-params" is called to setup $params (@ SESSION)
	Route::any('authorize', array('before' => 'check-authorization-params', 'uses' => 'OAuth2Controller@getAuthorize'));
	
	
	//Route::get('authorize', array('before' => 'check-authorization-params|auth', 'OAuth2Controller@getAuthorizes'));
	
	// ----------------------------------------------------------------------------
	// POST => /oauth2/authorize/web
	// ----------------------------------------------------------------------------
	Route::post('access_token', 'OAuth2Controller@postAccessToken');

	// ----------------------------------------------------------------------------
	// TEST authorize-params
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

// Filter to check if the auth code grant type params are provided
// Overrided from:
// Route::filter('check-authorization-params', 'LucaDegasperi\OAuth2Server\Filters\CheckAuthorizationParamsFilter');
Route::filter('check-authorization-params', 'demo\DemoController@CheckAuthorizationParamsFilter');

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
	}
	*/
});

// ----------------------------------------------------------------------------
// DEMO
// ----------------------------------------------------------------------------
// GET => /demo/
// GET => /demo/signin
// ----------------------------------------------------------------------------

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





