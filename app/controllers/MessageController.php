<?php

class MessageController extends BaseController {

    /**
     *	Validation Rules
     *	Based on Laravel Validation
     */
    protected static $getRules = array
    (
        'id'=> 'integer',
        'ids'=> '',
        'type'=>'',
        'display'=> ''
    );



	/**
	 * Display a listing of the resource.
	 *
     * @param null $id
     * @return Job
     * @throws InvalidParameterException
     * @throws WorkerException
     */
	public function index($id = null)
	{
        $rules = self::$getRules;
        $input['display'] = 'message';


        if (!$id && !Input::get('ids'))

            throw new InvalidParameterException ('A parent ID or ids list should be provided.');


        if ($id)
        {
            $input['id'] = $id;

            if (Request::segment(2) == 'accounts') $input['type'] = 'account';
            if (Request::segment(2) == 'channels') $input['type'] = 'channel';
            if (Request::segment(2) == 'streams') $input['type'] = 'stream';
            if (Request::segment(2) == 'contacts') $input['type'] = 'contact';
        }

        if (Request::segment(4) == 'messageids') $input['display'] = 'id';

        // Request Foreground Job
        $response = self::restDispatch ('index', 'MessageController', $input , $rules);

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
        $input['id'] = $id;
        $input['display'] = 'message';

        // Request Foreground Job
        $response = self::restDispatch ('show', 'MessageController', $input, self::$getRules);

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
