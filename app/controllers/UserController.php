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
        // get json data (post validation not needed, done by resource)
        $data = json_decode(Input::getContent());

        $url = URL::to('invitation');

        // Validation parameters
        $input = array ('id' => $id, 'email' => $data->email, 'url' => $url);

        // Request Foreground Job
        $response = self::restDispatch ('invite', 'AccountController', $input, self::$storeRules);

        return $response;

    }

    public function show($id1, $id2){

        return $id1 . ' - ' . $id2;
    }


}
