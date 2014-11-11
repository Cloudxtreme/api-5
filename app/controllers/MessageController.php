<?php

class MessageController extends BaseController {

    /**
     *	Validation Rules
     *	Based on Laravel Validation
     */
    protected static $getRules = array
    (
        'id'=> 'required|integer',
        'ids'=> ''
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
        $input = null;
        $rules = null;

        if (!$id && !Input::get('ids'))

            throw new InvalidParameterException ('A parent ID or ids list should be provided.');

        if ($id)
        {
            $input['id'] = $id;
            $rules = self::$getRules;
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
        if (Request::segment(2) == 'messages') $input['display'] = 'message';
        if (Request::segment(2) == 'notifications') $input['display'] = 'notification';
        if (Request::segment(2) == 'notes') $input['display'] = 'note';

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
