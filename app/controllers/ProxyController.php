<?php

class ProxyController extends BaseController {

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
	
	public function guest ()
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
	}

	public function authenticated ($path)
	{
		$request = \Neuron\Net\Request::fromInput ($path);

		//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));
		$segments = Request::segments ();
		array_shift ($segments);

		$request->setSegments ($segments);

		$verifier = \bmgroup\OAuth2\Verifier::getInstance ();
		//$user = MapperFactory::getUserMapper ()->getFromId ($verifier->getUserID ());
		$user = new \Neuron\Models\User ($verifier->getUserID ());

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
	}

}
