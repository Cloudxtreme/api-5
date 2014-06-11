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
// Setup OAuth2 routing
// ----------------------------------------------------------------------------
// GET => /oauth2/
// GET => /oauth2/requesttoken
// GET => /oauth2/accesstoken
// GET => /oauth2/authorize/web
// ----------------------------------------------------------------------------
Route::group(['prefix' => 'oauth2'], function()
{
	//GET => /oauth2/authorize/web
	Route::get('authorize/web', 'OAuth2Controller@getAuthorizeWeb');
	
	//GET => /oauth2/
	//GET => /oauth2/requesttoken
	//GET => /oauth2/accesstoken
	Route::controller('', 'OAuth2Controller');
});

// ----------------------------------------------------------------------------
// Setup account routing [API / V2]
// ----------------------------------------------------------------------------

Route::group(['prefix' => 'api'], function()
{
    Route::group(['prefix' => 'v2', 'namespace' => 'Api\V2'], function()
    {
        // Add as many routes as you need...

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





