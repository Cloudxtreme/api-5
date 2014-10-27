<?php

class ApiDocsController extends BaseController {
	
	public function __construct ()
	{

	}

    /**
     * Swagger docs API versions avaliable and routing
     * @param $version
     * @return \Illuminate\View\View
     */
	public function index ($version)
	{

		// check if docs version is available
		if ( !in_array($version, Config::get('api.documentation')) )

			App::abort(404, 'Woops.');


		return View::make('swagger.swagger', array('url'=> URL::to(Config::get('api.swaggerjsonpath').$version), 'version'=>$version));
	}


    /**
     * Check current api version and details
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiversion()
    {
        return Response::json(array(
            'api' => array
            (
                'name'          => Config::get('api.name'),
                'version'       => Config::get('api.current_version'),
                'environment'   => App::environment(),
                'status'        => Config::get('api.status'),
            )
        ), 200);
    }


}
