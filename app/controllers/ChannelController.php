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
		//
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
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
