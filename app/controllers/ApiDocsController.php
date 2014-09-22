<?php

class ApiDocsController extends BaseController {
	
	public function __construct ()
	{

	}

	public function index ($version)
	{
		// atention json files are cached
		// @todo put versions in config
		// @todo get bearer from localstorage
		$available_versions = array(
			'1.0'
		);
		// check if version exists else 404
		if( !in_array($version, $available_versions) ){
			App::abort(404, 'Woops.');
		}

//		$token = 'Bearer '.Session::get('_token');
		$url = URL::to('/').'/docs/schema/'.$version;

//URL::to('/')
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
