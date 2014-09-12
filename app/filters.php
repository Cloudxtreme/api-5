<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

// Catch the OPTIONS call.
use bmgroup\CloudwalkersClient\CwGearmanClient;

App::before(function($request)
{
	// Set headers
	header ('Access-Control-Allow-Origin: *');
	header ('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, PATCH, OPTIONS');
	header ('Access-Control-Allow-Headers: origin, x-requested-with, content-type, access_token, authorization');	
	
	// Sent by the browser since request come in as cross-site AJAX
	// The cross-site headers are sent via .htaccess
	if (strtoupper ($request->getMethod()) == "OPTIONS")
	{
		echo 'These are not the droids you\'re looking for.';

		exit;
	}
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	// Default bearer
	$bearer = Request::header('Authorization');
	
	// Get based bearer
	if(!$bearer)
		$bearer = Input::get('bearer');
	
	if (!$bearer || strlen ($bearer) < 18)
	
		return App::abort(403);
	
	// Add Acces token to input
	
	Input::merge( array('access_token'=> array_pop(explode(' ', $bearer))));
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Route::filter ('oauth2', function ()
{
	$verifier = \bmgroup\OAuth2\Verifier::getInstance ();
	if (!$verifier->isValid ())
	{
		http_response_code (403);

		return Response::json (array ('error' => array ('message' => 'No valid oauth2 authentication found.')), 403);
	}
});

Route::filter ('resellersigned', function ()
{
	$time = Input::get ('time');
	$random = Input::get ('random');
	$resellerid = Input::get ('reseller');
	$signature = Input::get ('signature');

	$body = Request::instance ()->getContent();
	
	if ($time && $random && $resellerid && $signature)
	{
		$client = CwGearmanClient::getInstance ();
		if (!$client->verifyopenssl ($resellerid, $signature, $random, $time, $body))
		{
			http_response_code (403);

			return Response::json (array ('error' => array ('message' => 'No valid openssl authentication found.')), 403);
		}
	}
});