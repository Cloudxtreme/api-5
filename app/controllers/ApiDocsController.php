<?php

class ApiDocsController extends BaseController {
	
	public function __construct ()
	{

	}

	public function index ($version)
	{
		// @todo check if version exists else 404
		// $version = in_array();
//		$token = 'Bearer '.Session::get('_token');
		$url = URL::to('/').'/docs/schema/'.$version;

		// local config
		// $token = 'Bearer '.'7abb47eade4847e75e42bf2bf7b1e7cca5ffd3c8';
		// $url = http://cloudwalkers-api.local/docs/schema/{{$version}}

		$data = array(
			'url'=>$url,
//			'token'=>$token,
			'version'=>$version
		);



		return View::make('swagger.swagger', $data);
	}


}
