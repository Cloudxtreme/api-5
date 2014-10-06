<?php

/**
 *	View Controller
 *	The view controller is used for static pages and login management.
 */
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

	/**
	 *	Mobile Login View
	 *	Show login fields and handle action
	 */
	public function mlogin ()
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
			return View::make('mobile.login_form', array('error'=> array($response->error)));

		}

		// Default view
		return View::make('mobile.login_form', Input::all());
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
     *  Recover password proccess
     *  send email to user with link to change password
     */
    public function recoverpassword ()
    {
        $data = Input::all();

        // Define default view
        if(empty($data))

            return View::make('signin.recover_password');


        // Post data actions and validation rules
        $data['url'] = URL::to('/');
        $data['ip']  = Request::getClientIp();

        $rules = array(
            'email' => 'required|email',
            'ip'    => 'required|ip',
            'url'   => 'required|url'
        );

        // input validation
        $validator = Validator::make($data, $rules);

        // validation error output
        if ($validator->fails())

            return View::make( 'signin.recover_password', array( 'message'=> $validator->messages()->first()) );


        $payload = (object) array('controller'=> 'UserController', 'action'=> 'recoverpassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules));

        $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);


        return View::make('signin.recover_password', $output);

    }

    /**
     *  Change password
     */
    public function changepassword ()
    {
	    $bearer = Request::header('Authorization');
        $token  = Request::segment(2);
        $data   = Input::all();

        // 2 entry points: with bearer (authenticated) or with access_token sent by email

        if ($bearer)
        {

            if (empty($data))

                return View::make('signin.change_password', array('auth'=>1));


            $rules = array(
                'newpassword'           => 'required|min:5',
                'newpassword_confirm'   => 'required|min:5|same:newpassword'
            );

            $validator = Validator::make($data, $rules);

            // validation error output
            if ($validator->fails())

                return View::make( 'signin.change_password', array( 'message'=> $validator->messages()->first(), 'auth'=>1) );


            $payload = (object) array('controller'=> 'UserController', 'action'=> 'changepassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules), 'user'=> null);

            $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

            // redirect to login if invalid bearer
            if (isset($output['redirect']))

                return Redirect::to($output['redirect']);


            return View::make('signin.change_password', array_merge($output, array('auth'=>1)));


        }

        elseif ($token) {

            // token used - old password is required
            if (empty($data))

                return View::make('signin.change_password');


            $data['token'] = $token;

            $rules = array(
                'token'                 => 'required',
                'oldpassword'           => 'required|min:5',
                'newpassword'           => 'required|min:5',
                'newpassword_confirm'   => 'required|min:5|same:newpassword'
            );

            $validator = Validator::make($data, $rules);

            // validation error output
            if ($validator->fails())

                return View::make('signin.change_password', array( 'message'=> $validator->messages()->first()));


            $payload = (object) array('controller'=> 'UserController', 'action'=> 'changepasswordtoken', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules), 'user'=> null);

            $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);


            return View::make('signin.change_password', $output);

        }

        else {
            // no token or bearer
            App::abort(404, 'Woops.');
        }

    }


    /**
     *  Register new user
     *  only with valid invitation
     */
    public function registeruser ()
    {
        $invitation_id = (int) Request::segment(2);
        $invitation_token = Request::segment(3);

        $uri_params = array( 'invitation_id' => $invitation_id, 'invitation_token'  => $invitation_token);

        // url params must be set otherwise invitation is not valid
        if(!$invitation_id || !$invitation_token)

            App::abort(404, 'Woops.');


        // validate all required data
        if(Request::isMethod('post')){
            $data = array_merge(Input::all(), $uri_params);
            $rules = array(
                'invitation_id'     => 'required|integer',
                'invitation_token'  => 'required|string',
                'email'             => 'required|email',
                'name'              => 'required',
                'firstname'         => 'required',
                'password'          => 'required',
                'password2'         => 'required|same:password'
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails())

                return View::make( 'signin.register', array_merge(array( 'message'=> $validator->messages()->first()), Input::all() ));

        }


        $input_data = array(
            'form' => Input::all(),
            'invitation_id' => $invitation_id,
            'invitation_token' => $invitation_token
        );


        // call engine with input data & invite info
        $payload = (object) array('controller'=> 'UserController', 'action'=> 'register', 'open'=> round(microtime(true), 3), 'payload'=> $input_data);
        $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);


        // output render
        if( isset($output['success']) )
            // trigger a notification to admin (for example)
            Event::fire('user.registration', array('msg', 'one more user registered in cloudwalkers'));


        return View::make('signin.register', array_merge($output, Input::all()));

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
