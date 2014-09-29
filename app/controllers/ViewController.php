<?php

class ViewController extends BaseController {
	
	public function __construct ()
	{

	}

	/**
	 *	Login View
	 *	Show login fields and handle action
	 */
	public function login ()
	{
		// Are e-mail and password set
		if(Input::get ('email') && Input::get ('password'))
		{
            // Request Foreground Job
            $response = self::jobdispatch ( 'controllerDispatch', (object) array
            (
                'action'=> 'login',
                'controller'=> 'AuthController',
                'payload'=> array_intersect_key (Input::all(), array('email'=>Input::get ('email'), 'password'=>Input::get ('password')))
            ));

            $response = json_decode($response);

			// If successful
			if (isset ($response->user))
                return View::make('signin.login', array('msg'=> $response->access_token));
//				App::abort(303, $response->redirect);
			
			// Else rebuild login
			return View::make('signin.login', array('error'=> array($response->error)));
		
		}
		
		// Default view
		return View::make('signin.login', Input::all());
	}
	
	/**
	 *	Authorize Approve View
	 *	Show approve options and handle action
	 */
	public function approve ($response = array())
	{
		// App is approved
		if (($auth = Input::get ('authorized')) && $auth == 'yes')

			return App::make('Oauth2Controller')->e_dispatch('approve');
			
		// App is not approved	
		else if($auth)
		{
			App::make ('Oauth2Controller')->revoke();
			App::abort (303, '/oauth2-e/authorize');
		}
		
		// Call Oauth
		return View::make('signin.authorize', (array) $response);
	}
	
	/**
	 *	Register View
	 *	Show client app registration and handle action
	 */
	public function registerapp ($response = array())
	{
		// Post action
		if ( Input::get ('name') && Input::has ('redirect'))
		
			$response = json_decode
			(
				App::make('Oauth2Controller')->e_dispatch('registerapp')
			);

		// Block action
		else if (Input::has ('layout'))
			
			$response->error = array('missing fields');

		// define view
		$view = isset ($response->success)?
			
			'oauth2.registerdone':
			'oauth2.register';
		

		// Build View
		return View::make($view, (array) $response);
	}
	
	/**
	 *	Logout View
	 */
	public function logout ()
	{
		// Call Oauth
		$response = App::make('Oauth2Controller')->revoke();
		
		return View::make('signin.logout', (array) $response);
	}

	/**
	 *	Lost Password View
	 *	Show lost pasword options and handle action
	 */
	public function lostPassword ()
	{
        $data = array();
		return View::make('signin.lost_password', $data);
	}


}
