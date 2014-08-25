<?php

use bmgroup\OAuth2\Verifier;
use Neuron\MapperFactory;

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
	if (strtoupper ($request->getMethod()) == "OPTIONS")
	{
		header ('Access-Control-Allow-Origin: *');
		header ('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, PATCH, OPTIONS');
		header ('Access-Control-Allow-Headers: origin, x-requested-with, content-type, access_token, authorization');
		
		echo 'These are not the droids you\'re looking for.';
		
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

if (!function_exists('http_response_code')) {
	function http_response_code($code = NULL) {

		if ($code !== NULL) {

			switch ($code) {
				case 100: $text = 'Continue'; break;
				case 101: $text = 'Switching Protocols'; break;
				case 200: $text = 'OK'; break;
				case 201: $text = 'Created'; break;
				case 202: $text = 'Accepted'; break;
				case 203: $text = 'Non-Authoritative Information'; break;
				case 204: $text = 'No Content'; break;
				case 205: $text = 'Reset Content'; break;
				case 206: $text = 'Partial Content'; break;
				case 300: $text = 'Multiple Choices'; break;
				case 301: $text = 'Moved Permanently'; break;
				case 302: $text = 'Moved Temporarily'; break;
				case 303: $text = 'See Other'; break;
				case 304: $text = 'Not Modified'; break;
				case 305: $text = 'Use Proxy'; break;
				case 400: $text = 'Bad Request'; break;
				case 401: $text = 'Unauthorized'; break;
				case 402: $text = 'Payment Required'; break;
				case 403: $text = 'Forbidden'; break;
				case 404: $text = 'Not Found'; break;
				case 405: $text = 'Method Not Allowed'; break;
				case 406: $text = 'Not Acceptable'; break;
				case 407: $text = 'Proxy Authentication Required'; break;
				case 408: $text = 'Request Time-out'; break;
				case 409: $text = 'Conflict'; break;
				case 410: $text = 'Gone'; break;
				case 411: $text = 'Length Required'; break;
				case 412: $text = 'Precondition Failed'; break;
				case 413: $text = 'Request Entity Too Large'; break;
				case 414: $text = 'Request-URI Too Large'; break;
				case 415: $text = 'Unsupported Media Type'; break;
				case 500: $text = 'Internal Server Error'; break;
				case 501: $text = 'Not Implemented'; break;
				case 502: $text = 'Bad Gateway'; break;
				case 503: $text = 'Service Unavailable'; break;
				case 504: $text = 'Gateway Time-out'; break;
				case 505: $text = 'HTTP Version not supported'; break;
				default:
					exit('Unknown http status code "' . htmlentities($code) . '"');
					break;
			}

			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

			header($protocol . ' ' . $code . ' ' . $text);

			$GLOBALS['http_response_code'] = $code;

		} else {

			$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

		}

		return $code;

	}
}

$databasesettings = Config::get ('database.connections.' . (Config::get ('database.default')));

define  ('DB_HOST', $databasesettings['host']);
define  ('DB_USERNAME', $databasesettings['username']);
define  ('DB_PASSWORD', $databasesettings['password']);
define  ('DB_NAME', $databasesettings['database']);
define  ('DB_CHARSET', $databasesettings['charset']);

define ('TEMPLATE_DIR', dirname (dirname (__FILE__)) . '/templates/');
define ('BASE_URL', URL::to('/') . '/');

// Which templates to load (catlab code)
$display = trim(\Neuron\Core\Tools::getInput('_GET', 'display', 'varchar'));

if ((strlen($display) == 0) ||
	($display == 'web'))
{
	$display = 'default';
}

if ($display == 'mobile')
{
	\Neuron\Core\Template::addTemplatePath (TEMPLATE_DIR . 'mobile', null, true);
}
else
{
	\Neuron\Core\Template::addTemplatePath (TEMPLATE_DIR, null, true);
}

Route::get ('docs{path?}', function ($path = "")
{

	return Redirect::to ('https://superadmin.cloudwalkers.be/docs' . $path);

})->where ('path', '.+');

Route::get ('1/version', function ()
{
	$request = \Neuron\Net\Request::fromInput ('version');

	//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));
	$segments = Request::segments ();

	$request->setSegments (array ('version'));

	$client = new GearmanClient ();
	
	foreach (Config::get ('gearman.servers') as $server => $port)
	{
		$client->addServer ($server, $port);
	}

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
	//print_r ($response->toJSON ());
	exit;
});

Route::any('login/{path?}', function()
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

Route::any('logout/{path?}', function()
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

Route::any('oauth2/{path?}', function()
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

})->where ('path', '.+');;

// The All Catching One
Route::match (array ('GET', 'POST', 'PATCH', 'PUT', 'DELETE'), '{path?}', function ($path) {

	$verifier = \bmgroup\OAuth2\Verifier::getInstance ();
	if (!$verifier->isValid ())
	{
		header ('Access-Control-Allow-Origin: *');
		header ('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, PATCH, OPTIONS');
		header ('Access-Control-Allow-Headers: origin, x-requested-with, content-type, access_token, authorization');

		http_response_code (403);
		
		echo 'I\'m sorry, no valid oauth2 information provided.';
		exit;
	}

	$request = \Neuron\Net\Request::fromInput ($path);

	//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));
	$segments = Request::segments ();
	array_shift ($segments);

	$request->setSegments ($segments);

	$user = MapperFactory::getUserMapper ()->getFromId ($verifier->getUserID ());
	$request->setUser ($user);

	$client = new GearmanClient ();
	foreach (Config::get ('gearman.servers') as $server => $port)
	{
		$client->addServer ($server, $port);
	}

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
	//print_r ($response->toJSON ());
	exit;

})->where ('path', '.+');