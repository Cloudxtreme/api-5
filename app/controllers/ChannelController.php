<?php

class ChannelController extends BaseController {

    /**
     *	Channels Controller
     *	The channels controller uses the Laravel RESTful Resource Controller method.
     *
     *	[http://laravel.com/docs/4.2/controllers#restful-resource-controllers]
     *
     *	Following routes are supported
     *	GET			/resource				index		resource.index
     *	POST		/resource				store		resource.store
     *	GET			/resource/{resource}	show		resource.show
     *	PUT/PATCH	/resource/{resource}	update		resource.update
     *	DELETE		/resource/{resource}	destroy		resource.destroy
     */

    /**
     *	Validation Rules
     *	Based on Laravel Validation
     */
    protected static $getRules = array
    (
        'id'=> 'required|integer'
    );


    /**
     *	RESTful actions
     */

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'AccountController', null, null);

        return $response;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        // Validation parameters
        $input = array ();

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'AccountController', $input, self::$postRules);

        return $response;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        // Validation parameters
        $input = array ();

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'AccountController', $input, self::$postRules);

        return $response;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
