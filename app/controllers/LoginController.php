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
	    $payload = (object) array('controller'=> 'UserController', 'action'=> 'changePassword', 'open'=> round(microtime(true), 3), 'payload'=> array(), 'user'=> null);

	    $output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

	    print_r($output); exit;

//	    $bearer = Request::header('Authorization');
//
//	    if (!$bearer || strlen ($bearer) < 18)
//	    {
//		    http_response_code (403);
//
//		    return Response::json (array ('error' => array ('message' => 'No valid oauth2 authentication found.')), 403);
//	    }

	    if(Input::has('oldpassword')){
		    Input::merge(array('userId'=> $userId));

		    $rules = array(
			    'userId' => 'required|integer',
			    'oldpassword' => 'required',
			    'newpassword' => 'required',
			    'newpassword_confirm' => 'required|same:newpassword'
		    );

//		    print_r($rules);
//		    echo '<br>';
//		    print_r(Input::all());
//		    exit;

		    $validator = Validator::make(Input::all(), $rules);
		    $data = Input::all();

		    if ($validator->fails()){
			    $error = array('error'=> 'something went wrong');
			    return View::make('signin.change_password', $error);
		    } else {
			    $payload = (object) array('controller'=> 'UserController', 'action'=> 'changePassword', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key($data, $rules), 'user'=> null);

			    print_r(array(45,43));
			    print_r(Input::all(), true); exit;

				$output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

			    return print_r($output,true);

		    }
	    } else {
		    return View::make('signin.change_password');
	    }

    }

    public function recoverPassword ()
    {
	    $data = Input::all();
//	    return var_dump($data);
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

    public function error404 ()
    {
	    $data = Input::all();

	    App::abort(403, 'Unauthorized action.');
    }
	
	public function register ()
	{
		// todo validation (very important - critical)
        $form_data = Input::all();
		$invitation_id = Request::segment(2);
		$invitation_token = Request::segment(3);

		$data = array(
			'form' => $form_data,
			'invitation_id' => $invitation_id,
			'invitation_token' => $invitation_token
		);

		// call engine with input data & invite info
		$payload = (object) array('controller'=> 'UserController', 'action'=> 'register', 'open'=> round(microtime(true), 3), 'payload'=> $data);
		$output = json_decode ( self::jobdispatch ('controllerDispatch', $payload), true);

		if( !empty($output['action']) && $output['action']=='form'){
			return View::make('signin.register', $output);
		}

		if( !empty($output['action']) && $output['action']=='invalid'){
			App::abort(403, 'Unauthorized action.');
		}

		if( !empty($output['action']) && $output['action']=='msg'){
			return View::make('signin.register', $output);
		}
	}


}
