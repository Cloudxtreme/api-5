<?php

class CommunicationController extends BaseController {
	
	public function __construct ()
	{

	}

	public function login ()
	{
        $data = Input::all();

        if(isset($data['email']) && isset($data['password'])){
            $username = $data['email'];
            $password = $data['password'];
            // send request to engine via gearman
            $output = App::make ('cwclient')->login ($username, $password);
            return View::make('signin.login', $output);
        } else {
            return View::make('signin.login', $data);
        }

	}

	public function lostPassword ()
	{
        return 'did you?';

        //$data = array();
		//return View::make('signin.login', $data);
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

        $status = $message->to(351966479598)
            ->message('Hello world!')
            ->send();

		return print_r($status, true);
	}

}
