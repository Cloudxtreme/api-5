<?php

class ViewController extends BaseController {
	
	public function __construct ()
	{

	}

	public function login ()
	{
		// Are e-mail and password set
		if(Input::get ('email') && Input::get ('password'))
		{
			// Oauth2 request
			$response = App::make('Oauth2Controller')->login();
			
			// If successful
			if (isset ($response->redirect))
				
				App::abort(303, $response->redirect);
			
			// Else rebuild login
			return View::make('signin.login', array('error'=> array($response->error)));
		
		}
		
		// Default view
		return View::make('signin.login', Input::all());
	}
	
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
	
	public function logout ()
	{
		// Call Oauth
		$response = App::make('Oauth2Controller')->revoke();
		
		return View::make('signin.logout', (array) $response);
	}

	public function register ()
	{
        $data = Input::all();

        if( !empty($data) ){
            // send request to engine via gearman
            $output = App::make ('cwclient')->register ($data['email'], $data['password'], $data['firstname'], $data['name']);
            // if ok redirect
            if(isset($output['success'])){
                return Redirect::to('login');
            } else {
                return View::make('signin.register', $output);
            }
        } else {
            return View::make('signin.register', $data);
        }
	}

	public function lostPassword ()
	{
        $data = array();
		return View::make('signin.lost_password', $data);
	}

	public function email ()
	{
        $data = array();
        Mail::send('emails.welcome', $data, function($message)
        {
            $message->to('pedrodee@gmail.com', 'John Smith')->subject('Welcome!');
        });

		return 'email sent!';
	}

	public function sms ()
	{
        $data = array();
        $message = new Clickatell;

        $status = $message->to(32476858168)
            ->message('CW is watching you!')
            ->send();

		return print_r($status, true);
	}

}
