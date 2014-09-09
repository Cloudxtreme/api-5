<?php

use bmgroup\CloudwalkersClient\CwGearmanClient;

class NeuronProxyController extends BaseController {

	/**
	 * Make an anonymous request to the worker chain.
	 */
	public function guest ()
	{
		$segments = Request::segments ();
		//array_shift ($segments);
		
		$request = \Neuron\Net\Request::fromInput ();
		$request->setPath (implode ('/', $segments));

		//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));
		$request->setSegments ($segments);

		$client = new GearmanClient ();

		foreach (Config::get ('gearman.servers') as $server => $port)
		{
			$client->addServer ($server, $port);
		}

		$data = $client->doHigh ('neuronApiDispatch', $request->toJSON ());
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

	/**
	 * Make a request based on the user.
	 */
	public function authenticated ()
	{
		$segments = Request::segments ();
		//array_shift ($segments);
		
		$request = \Neuron\Net\Request::fromInput (implode ('/', $segments));

		//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));


		$request->setSegments ($segments);
		
		// Check for oauth2 signature
		

		$verifier = \bmgroup\OAuth2\Verifier::getInstance ();
		//$user = MapperFactory::getUserMapper ()->getFromId ($verifier->getUserID ());
		$user = new \Neuron\Models\User ($verifier->getUserID ());

		$request->setUser ($user);

		$client = new GearmanClient ();
		foreach (Config::get ('gearman.servers') as $server => $port)
		{
			$client->addServer ($server, $port);
		}

		$data = $client->doHigh ('neuronApiDispatch', $request->toJSON ());
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

	/**
	 * Auth using signed ssl (for resellers)
	 */
	public function openssl ()
	{
		$segments = Request::segments ();
		//array_shift ($segments);

		$request = \Neuron\Net\Request::fromInput (implode ('/', $segments));

		//return Response::make ($request->getJSON (), 200, array ('content-type' => 'application/json'));


		$request->setSegments ($segments);

		if (! ($reseller = CwGearmanClient::getInstance()->getResellerInfo()))
		{
			$request->setSession ('reseller', $reseller['id']);
		}

		// Check for oauth2 signature

		$client = new GearmanClient ();
		foreach (Config::get ('gearman.servers') as $server => $port)
		{
			$client->addServer ($server, $port);
		}

		$data = $client->doHigh ('neuronApiDispatch', $request->toJSON ());
		$response = \Neuron\Net\Response::fromJSON ($data);

		// Hack the body for forms
		/*
		if ($response->getBody ())
		{
			$body = $response->getBody ();
			$body = str_replace ('action="http://cloudwalkers-api.local/', 'action="http://cloudwalkers-api.local/proxy/', $body);
			$response->setBody ($body);
		}
		*/

		$response->output ();
		//print_r ($response->toJSON ());
		exit;
	}

}
