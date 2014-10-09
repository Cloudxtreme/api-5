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
     *	Validation Rules
     *	Based on Laravel Validation
     */
    protected static $lostPasswordRules = array
    (
        'email' => 'required|email',
        'ip'    => 'required|ip',
        'url'   => 'required|url'
    );


	/**
	 *	Login View (standard and mobile)
	 *	Show login fields and handle action
	 */
	public function login ()
	{
        // choose view (standard or mobile)
        $view = (Input::get ('view') == 'mobile')? 'mobile.login' : 'signin.login';

		// Are e-mail and password set
		if(Input::has ('email') && Input::has ('password'))
		{
			// Oauth2 request
			$response = App::make('Oauth2Controller')->login();

			// If successful
			if (isset ($response->redirect))

				App::abort(303, $response->redirect);

			// Else rebuild login
			return View::make($view, array('error'=> array($response->error)));

		}

		// Default view
		return View::make($view, Input::all());
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
		if ( Input::has ('name') && Input::has ('redirect'))

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
     *	Lost Password Form View and process
     *	Show lost password form (input email) and handle action
     */
    public function lostPassword ()
    {

        // Define default view
        if(!Input::has('email'))

            return View::make('signin.lost_password');


        // Merge Post data with request ip (ip is stored in db)
        Input::merge (array('ip' => Request::getClientIp()));

        try
        {
            $response = self::restDispatch ('lostpassword', 'UserController', Input::all(), self::$lostPasswordRules);

            return View::make('signin.lost_password', array('messages'=>$response));
        }

        catch (Exception $e)
        {
            return View::make('signin.lost_password', array('messages'=>$e->getErrors()));
        }


    }

    /**
     *  Change password process
     *  only accessible with token
     *
     */
    public function changepassword ()
    {

        // @todo replace all with
        // $response = self::restDispatch ('update', 'AccountController', $input, self::$updateRules);

        $token  = Request::segment(2);

        // token is required
        if (!$token)

            App::abort(404, 'Woops.');


        if (!Request::isMethod('post'))

            return View::make('signin.change_password');


        $rules = array(
            'token'                 => 'required',
            'newpassword'           => 'required|min:5',
            'newpassword_confirm'   => 'required|min:5|same:newpassword'
        );

        $validator = Validator::make(Input::all(), $rules);

        // validation error output
        if ($validator->fails())

            return View::make( 'signin.change_password', array( 'message'=> $validator->messages()->first(), 'auth'=>1) );


        $payload = (object) array('controller'=> 'UserController', 'action'=> 'changepassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key(Input::all(), $rules), 'user'=> null);

        $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

        // redirect to login if invalid bearer
        if (isset($output['redirect']))

            return Redirect::to($output['redirect']);


        return View::make('signin.changepasswordtoken', $output);

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
                'invitation_token'  => 'required',
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


        $input_data = array_merge($uri_params, Input::all());


        // call engine with input data & invite info
        $payload = (object) array('controller'=> 'UserController', 'action'=> 'register', 'open'=> round(microtime(true), 3), 'payload'=> $input_data);

        $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);


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


}
