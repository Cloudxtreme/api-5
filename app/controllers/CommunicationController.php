<?php

class CommunicationController extends BaseController {
	
	public function __construct ()
	{

	}

	public function login ()
	{
        $data = array();

		return View::make('login', $data);
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