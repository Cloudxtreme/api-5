<?php

class ApiDocsController extends BaseController {
	
	public function __construct ()
	{

	}

	public function index ($version)
	{

		// check if docs version is available
		if ( !in_array($version, Config::get('api.documentation')) )

			App::abort(404, 'Woops.');


		return View::make('swagger.swagger', array('url'=> URL::to(Config::get('api.swaggerjsonpath').$version), 'version'=>$version));
	}


}
