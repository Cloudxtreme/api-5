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
	
	public function register ()
	{
//		$response = $this->ancientFrontController->dispatch ($this->ancientPage);
//
//		if ($response)
//		{
//			$response->output ();
//		}
//
//		exit;

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


}
