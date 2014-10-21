<?php

class UserController extends BaseController {

    /**
     *	Validation Rules
     *	Based on Laravel Validation
     */
    protected static $storeRules = array
    (
        'email' => 'required|email',
        'id'    => 'required|integer',
        'url'   => 'required|url'
    );


	/**
	 * Invite to account
	 *
     * @param   integer $id
	 * @return  Response
	 */
	public function store($id)
	{
        $data = json_decode(Input::getContent());

        // get json data (post validation not needed, done by resource)
        if (!isset($data->email))

            return Response::json(array('message'=>'email needed!'), 406);


        $url = URL::to('invitation');

        // Validation parameters
        $input = array ('id' => $id, 'email' => $data->email, 'url' => $url);

        // Request Foreground Job
        $response = self::restDispatch ('invite', 'AccountController', $input, self::$storeRules);

        return Response::json(json_decode($response), 200);

    }

    public function show($id){

        return $id ;
    }


}
