<?php

class OAuth2Controller extends BaseController {

	// V1
	public function dispatch ($path)
	{
		$page = new \bmgroup\CloudwalkersClient\Page ();

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
	}

	// V1.1
	
	/**
	 *	Allowed paths
	 */
	static $paths = array('authorize', 'approve', 'login', 'status', 'revoke');
	
	/**
	 *	Dispatch
	 *	Call Engine based Oauth handler
	 *	(e_ stands for engine, since the default dispatch is API based)
	 */
	 public static function e_dispatch ($action)
	{
		// Basic sanity
		if (!in_array ($action, self::$paths))
			
			App::abort(404);
			
		// In case of redirect
		if (Session::has('last_url'))
			
			Input::merge(Session::get('last_url'));
		
		// Send job
		$jobload = (object) array('controller'=> 'AuthController', 'action'=> $action, 'user'=> Session::get('user'), 'payload'=> Input::all());

		$status = json_decode
		(
			self::jobdispatch('controllerDispatch', $jobload)
		);
		
		// Check for redirect
		if (isset ($status->redirect))
		{
			Session::put('last_url', Input::all());
			App::abort(303, $status->redirect);
		}
		
		// Check for view
		if (isset ($status->view))
		{
			return App::make('ViewController')->{$status->view}($status);
		}
		
		
		return json_encode($status);
	}
	
	/**
	 *	Login
	 */
	public function login ()
	{
		// Encrypt password
		$encryption = new SimpleCrypt (Config::get ('app.secret'));
		Input::merge (array ('password'=> $encryption->encrypt (Input::get ('password'))));
		
		
		// Request login check
		$status = json_decode( self::e_dispatch ('login'));
		
		// Add user id to session
		// Then go back to authorize, with stored auth parameters
		if (isset ($status->user))
		{
			Session::put('user', $status->user);
			
			App::abort(303, 'oauth2-e/authorize');
		}

		return $status;
	}
	
	/**
	 *	Status
	 */
	public function status ()
	{
		/* // First check
		if (!Input::get('bearer'))
			
			App::abort(403);
			
		else Input::merge (array('access_token'=> Input::get ('bearer')));*/
		
		// Request from server
		return self::e_dispatch ('status');	
	}
	
	/**
	 *	Revoke
	 */
	public function revoke ()
	{
		// Request logout check
		$response = json_decode( self::e_dispatch ('revoke'));
		
		Session::flush ();
		
		return $response;
	}
}
