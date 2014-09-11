<?php

class ContactController extends BaseController {

    public function get($accountId = null, $contactId = null){
        Input::merge(array('accountId'=> $accountId, 'contactId'=> $contactId));

        $rules = array(
            'accountId' => 'required|integer',
            'contactId' => 'required|integer'
        );

        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed
        if ($validator->fails()){
            // TODO
            // return Redirect::to('<add page here>')->withErrors($validator);
        } else {
            $payload = array('controller'=> 'ContactController', 'action'=> 'getAccountsIdContactsId', 'open'=> round(microtime(true), 3), 'payload'=> array_intersect_key(Input::all(), $rules), 'user'=> null);

            return json_decode
            (
                self::jobdispatch ('controllerDispatch', $payload)
            );
        }
    }

}