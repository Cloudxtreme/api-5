<?php

class EventsController extends BaseController {

    // @todo emails should be sent via workers so pages can load faster

    public function onTesting()
    {
        // notify admins
        $data = array();
        Mail::send('emails.new_registration', $data, function($message)
        {
            $message->to('psilva@agap2.pt', 'Event notification')->subject('test events');
        });

        return 'email sent!';
    }


	public function onUserRegister ()
    {
        // notify admins
        $data = array();
        Mail::send('emails.new_registration', $data, function($message)
        {
            $message->to('psilva@agap2.pt', 'User event notification')->subject('New user registration');
        });

        return 'email sent!';
    }


}
