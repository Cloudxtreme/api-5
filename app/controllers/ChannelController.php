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

    protected static $getIdsRules = array
    (
        'ids'=> 'required'
    );

    protected static $postRules = array
    (
        'name'=> 'required|min:2',
        'settings'=> 'required'
    );

    protected static $updateRules = array
    (
        'id'=> 'required|integer',
        'name'=> 'required|min:2',
        'settings'=> 'required'
    );


    /**
     *	RESTful actions
     */

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index ($id)
	{
        $input = null;
        $rules = null;


        if (!$id)
        {
            # /1.1/channels GET (?ids)
            $rules = self::$getIdsRules;
        }

        if ($id)
        {
            # /1.1/accounts/id/channels GET
            # /1.1/channels/id/channels GET
            $input = array('id'=> $id, 'type' => Request::segment(2));
            $rules = self::$getRules;
        }

        // Request Foreground Job
        $response = self::restDispatch ('index', 'ChannelController', $input, $rules);

        return $response;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store ($id)
	{
        // Validation parameters
        $input = array ('id' => $id);

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('store', 'ChannelController', $input, self::$postRules);

        return $response;
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show ($id)
	{
        // Validation parameters
        $input = array ('id' => $id);


        // Request Foreground Job
        $response = self::restDispatch ('show', 'ChannelController', $input, self::$getRules);

        return $response;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update ($id)
	{
        // Validation parameters
        $input = array ('id' => $id);

        Input::merge((array)json_decode(Input::getContent()));

        // Request Foreground Job
        $response = self::restDispatch ('update', 'ChannelController', $input, self::$updateRules);

        return $response;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy ($id)
	{
        // Validation parameters
        $input = array ('id'=> $id);

        // Request Foreground Job
        $response = self::restDispatch ('destroy', 'ChannelController', $input, self::$getRules);

        return $response;
	}

    /**
     * Get ids of the account channels
     */
    public function channelids ()
    {
        # STANDBY: not making sense
        # how can we relate to account
    }


}
