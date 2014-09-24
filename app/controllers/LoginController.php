<?php

class LoginController extends BaseController {

	private $ancientPage;
	private $ancientFrontController;
    protected $layout = 'layouts.auth';
	
	public function __construct ()
	{
		$this->ancientPage = new \bmgroup\CloudwalkersClient\Page ();
		
		$frontcontroller = new \Neuron\FrontController ();
		$frontcontroller->setInput (Request::segments ());
		$frontcontroller->setPage ($this->ancientPage);

		$frontcontroller->addController (new \bmgroup\Signin\FrontController ());
		$frontcontroller->addController (new \bmgroup\OAuth2\FrontController ());
		
		$this->ancientFrontController = $frontcontroller;
	}
	
	public function login ()
	{
		$response = $this->ancientFrontController->dispatch ($this->ancientPage);
		if ($response)
		{
			$response->output ();
		}

		exit;

//        $data = Input::all();
//
//        if(isset($data['email']) && isset($data['password'])){
//            $username = $data['email'];
//            $password = $data['password'];
//            // send request to engine via gearman
//            $output = App::make ('cwclient')->login ($username, $password);
//            // if ok redirect
//            if(isset($output['id'])){
//                return Redirect::to('http://devplatform.cloudwalkers.be');
//            } else {
//                return View::make('signin.login', $output);
//            }
//        } else {
//            return View::make('signin.login', $data);
//        }
	}

    public function logout ()
    {
        $response = $this->ancientFrontController->dispatch ($this->ancientPage);
        if ($response)
        {
            $response->output ();
        }

	    exit;
    }

    public function changePassword ()
    {

//	    $bearer = Request::header('Authorization');
	    $bearer = '123456789012345678';
	    $token  = Request::segment(2);
        $data = Input::all();

        // 2 entry points: with bearer (authenticated) or with access_token sent by email
//	    if(!$bearer && !$token){
//		    App::abort(404, 'Woops.');
//	    }

	    if($bearer){
            // access_token used - old password not needed
            if(!empty($data)) {
                if(!Input::has('newpassword') || !Input::has('newpassword_confirm'))
                    return View::make('signin.change_password', array('auth'=>1, 'error'=>'All fields required!'));

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
                    return 'connecting with engine';
                }
            } else {
                return View::make('signin.change_password', array('auth'=>1));
            }
	    } elseif($token) {
            // token used - old password is required
            if(!empty($data)){
                if(!Input::has('oldpassword') || !Input::has('newpassword') || !Input::has('newpassword_confirm'))
                    return View::make('signin.change_password', array('error'=>'All fields required!'));

                $rules = array(
                    'oldpassword' => 'required',
                    'newpassword' => 'required',
                    'newpassword_confirm' => 'required|same:newpassword'
                );

                $validator = Validator::make($data, $rules);

                if ($validator->fails()){
                    $errors = $validator->messages();
                    $error = $errors->first();
                    return View::make('signin.change_password', array('error'=>$error));
                } else {
                    $payload = (object) array('controller'=> 'UserController', 'action'=> 'changePassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules), 'user'=> null);

                    $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

                    if($output['action']=='success'){
                        return View::make('signin.change_password', array('msg'=>'You have a new password!'));
                    } else {
                        return View::make('signin.change_password', array('error'=>'Engine Error!'));
                    }

                }
            }
            return View::make('signin.change_password');
        } else {
            App::abort(404, 'Woops.');
        }

//	    if (!$bearer || strlen ($bearer) < 18)
//	    {
//		    http_response_code (403);
//
//		    return Response::json (array ('error' => array ('message' => 'No valid oauth2 authentication found.')), 403);
//	    }


    }
//else {
//		    return View::make('signin.change_password');
//	    }

//    }

    public function recoverPassword ()
    {
	    $data = Input::all();

	    if(!empty($data)){

		    $rules = array(
			    'email' => 'required|email'
		    );

		    $validator = Validator::make(Input::all(), $rules);

		    if ($validator->fails()){
			    $error = array('error'=> 'you should input a valid email!');
			    return View::make('signin.recover_password', $error);
		    } else {
			    $payload = (object) array('controller'=> 'UserController', 'action'=> 'recoverPassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules));

			    $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

			    return View::make('signin.recover_password', $output);
		    }
	    } else {
		    return View::make('signin.recover_password');
	    }
    }
	
	public function register ()
	{

		$invitation_id = (int) Request::segment(2);
		$invitation_token = Request::segment(3);

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
				if(Input::get('password') != Input::get('password2')){
					$data['error'] ='Password fields must match.';
				}
				if(count(Input::all())<6){
					$data['error'] = 'All fields are required.';
				}

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

//		return var_dump($output['data']);

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


}
