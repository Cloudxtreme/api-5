<?php

class CommunicationController extends BaseController {
	
	public function __construct ()
	{

	}

	public function login ()
	{
        $data = Input::all();

        if($data['email'] && $data['password']){
            // send request to engine via gearman
            return App::make('ProxyController')->guest($data);
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
