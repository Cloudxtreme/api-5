<?php

class ApiDocsController extends BaseController {
	
	public function __construct ()
	{

	}

	public function index ($version)
	{
		$token = 'Bearer '.Session::get('_token');
//		$token = 'Bearer '.'7abb47eade4847e75e42bf2bf7b1e7cca5ffd3c8';
		$data = array(
			'auth'=>1,
			'token'=>Session::get('_token'),
			'version'=>$version
		);

		// @todo check if version exists

		return View::make('swagger.swagger', $data);
	}


}
