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
	    $bearer = 'Bearer 24ee80731476c05f3c7ae519297064b16f97ca33';
        $token  = Request::segment(2);
        $token  = Input::get('token');
        $data   = Input::all();

        // 2 entry points: with bearer (authenticated) or with access_token sent by email

        if($bearer){
            // access_token used - old password not needed
            if(!empty($data)) {
                if(!Input::has('newpassword') || !Input::has('newpassword_confirm'))
                    return View::make('signin.change_password', array('auth'=>1, 'error' => trans('change_password.all.required')));

                $rules = array(
                    'newpassword' => 'required|min:5',
                    'newpassword_confirm' => 'required|min:5|same:newpassword'
                );

                $validator = Validator::make($data, $rules);

                if ($validator->fails()){
                    $errors = $validator->messages();
                    $error = $errors->first();
                    return View::make('signin.change_password', array('auth'=>1, 'error'=>$error));
                } else {
                    $payload = (object) array('controller'=> 'UserController', 'action'=> 'changepassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules), 'user'=> null);

                    $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

                    dd( $output );
                }
            } else {
                return View::make('signin.change_password', array('auth'=>1));
            }
        } elseif ($token) {
            // token used - old password is required
            if(!empty($data)){
                if(!Input::has('oldpassword') || !Input::has('newpassword') || !Input::has('newpassword_confirm'))
                    return View::make('signin.change_password', array('error' => trans('change_password.all.required')));

                $data['token'] = $token;

                $rules = array(
                    'token'                 => 'required',
                    'oldpassword'           => 'required|min:5',
                    'newpassword'           => 'required|min:5',
                    'newpassword_confirm'   => 'required|min:5|same:newpassword'
                );

                $validator = Validator::make($data, $rules);

                if ($validator->fails()){
                    $errors = $validator->messages();
                    $error = $errors->first();
                    return View::make('signin.change_password', array('error'=>$error));
                } else {
                    $payload = (object) array('controller'=> 'UserController', 'action'=> 'changepasswordtoken', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules), 'user'=> null);

                    $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

                    if($output['action']=='success'){
                        return View::make('signin.change_password', array('msg' => $output['msg']));
                    } else {
                        return View::make('signin.change_password', array('error' => $output['msg']));
                    }

                }
            }
            return View::make('signin.change_password');
        } else {
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

        // both fields required, validation of those is made in engine
        if (!$invitation_id || !$invitation_token)
            App::abort(403, 'Unauthorized action.');

        // validation for post data
        if(Request::isMethod('post')){
            $data = Input::all();
            $rules = array(
                'email' => 'required|email',
                'name' => 'required',
                'firstname' => 'required',
                'password' => 'required',
                'password2' => 'required|same:password'
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()){
                $data['error'] = $validator->messages()->first();
//                if(Input::get('password') != Input::get('password2')){
//                    $data['error'] ='Password fields must match.';
//                }
//                if(count(Input::all())<6){
//                    $data['error'] = 'All fields are required.';
//                }

                return View::make('signin.register', $data);
            }
        }

        // validation url parameters
        if(Request::isMethod('post')){
            $rules1 = array(
                'invitation_id' => 'required|integer',
                'invitation_token' => 'required|string'
            );

            $data1 = array(
                'invitation_id' => $invitation_id,
                'invitation_token' => $invitation_token
            );

            $validator = Validator::make($data1, $rules1);
            if ($validator->fails()){
                App::abort(403, 'Unauthorized action.');
            }
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
        if( !empty($output['action']) && $output['action']=='success'){
            // trigger a notification to admin (for example)
            Event::fire('user.registration', array('msg', 'one more user registered in cloudwalkers'));
            return View::make('signin.login', $output);
        }

        if( !empty($output['action']) && $output['action']=='register_form'){
            return View::make('signin.register', $output);
        }

        if( !empty($output['action']) && $output['action']=='error'){
            return View::make('signin.register', $output);
        }

        if( !empty($output['action']) && $output['action']=='invalid'){
            App::abort(403, 'Unauthorized action.');
        }

        App::abort(404, 'Woops.');

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
