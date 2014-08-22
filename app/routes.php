<?php

use bmgroup\OAuth2\Verifier;

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

App::before(function($request)
{
	// Sent by the browser since request come in as cross-site AJAX
	// The cross-site headers are sent via .htaccess
	if ($request->getMethod() == "OPTIONS")
	{
		header ('Access-Control-Allow-Origin: *');
		header ('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, PATCH, OPTIONS');
		header ('Access-Control-Allow-Headers: origin, x-requested-with, content-type, access_token, authorization');
		exit;
	}
});


// ----------------------------------------------------------------------------
// This command allows to see the existing routes that are configured
// ----------------------------------------------------------------------------
// php artisan routes > x_routes.txt
// ----------------------------------------------------------------------------

function __ ($text)
{
	return $text;
}

define  ('DB_HOST', 'db.cloudwalkers.be');
define  ('DB_USERNAME', 'workers');
define  ('DB_PASSWORD', 'dj99Pze!Ueh');
define  ('DB_NAME', 'cloudwalkers_dev');
define  ('DB_CHARSET', 'utf8');

define ('TEMPLATE_DIR', dirname (__FILE__) . '/templates/');
define ('BASE_URL', 'https://devapi.cloudwalkers.be/');

// The All Catching One
Route::any ('/proxy/{path?}', function ($path) {

	$verifier = \bmgroup\OAuth2\Verifier::getInstance ();
	if (!$verifier->isValid ())
	{
		echo '<p>No valid oauth2 credentials provided.</p>';
		exit;
	}

	$request = \Neuron\Net\Request::fromInput ($path);
	
	//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));
	$segments = Request::segments ();
	array_shift ($segments);
	
	$request->setSegments ($segments);

	$client = new GearmanClient ();
	$client->addServer ('devgearman.cloudwalkers.be', 4730);

	$data = $client->doHigh ('apiDispatch', $request->toJSON ());
	$response = \Neuron\Net\Response::fromJSON ($data);

	// Hack the body for forms
	if ($response->getBody ())
	{
		$body = $response->getBody ();
		$body = str_replace ('action="http://cloudwalkers-api.local/', 'action="http://cloudwalkers-api.local/proxy/', $body);
		$response->setBody ($body);
	}
	
	// Also change the headers

	$response->output ();
	//print_r ($response->toJSON ());
	exit;
	
	//return '<pre>' . print_r ($out, true) . '</pre>';
	

	//return Response::make($out['return'], 200, array('content-type' => 'application/json'));

	//return $request->getJSON ();
	
})->where ('path', '.+');

Route::any('{path?}', function()
{
	$page = new \bmgroup\Cloudwalkers\Page ();

	$frontcontroller = new \Neuron\FrontController ();
	$frontcontroller->setInput (Request::segments ());
	$frontcontroller->setPage ($page);

	$frontcontroller->addController (new \bmgroup\Signin\FrontController ());
	$frontcontroller->addController (new \bmgroup\OAuth2\FrontController ());

	$response = $frontcontroller->dispatch ($page);

	if ($response)
	{
		$response->output ();
	}

	exit;

})->where ('path', '.+');