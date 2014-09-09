<?php

class ProxyController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Proxy Controller
	|--------------------------------------------------------------------------
	|
	| Communication controller between workers and API.
	| Specialized worker controllers should extend this one.
	|
	*/
	
	/**
	 *	Guest dispatch
	 */
	public static function guest ()
	{
		// Proxy payload
		$payload = array('method'=> Request::method(), 'path'=> implode ('/', Request::segments()));
	
		return json_decode
		(
			self::jobdispatch ('apiDispatch', $payload)
		);
	}

	/**
	 *	Authenticated dispatch
	 */
	public function authenticated ()
	{
		// Proxy payload
		$payload = array('method'=> Request::method(), 'path'=> implode ('/', Request::segments ()), 'access_token'=> Request::header('Authorization'));
		
		return json_decode
		(
			self::jobdispatch ('apiDispatch', $payload)
		);
	}

}