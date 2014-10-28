<?php

/**
 *	Campaign Controller
 *	The campaign controller uses the Laravel RESTful Resource Controller method.
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
class CampaignController extends BaseController {

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
	 *	Get Account Campaigns
	 *
	 *	@return array
	 */
	public function index ()
	{
        return 'index';
	}
	
	/**
	 *	Post Campaign
	 *
	 *	@return object
	 */
	public function store ()
	{
        return 'store';
	}	
	
	/**
	 *	Get Campaign
	 *
	 *	@return object
	 */
	public function show ($id)
	{
        return 'show';
	}
	
	/**
	 *	Update Account
	 *
	 *	@return object
	 */
	public function update ($id)
	{
        return 'update';
	}
	
	/**
	 *	Delete Accounts
	 *
	 *	@return boolean
	 */
	public function destroy ($id)
	{
        return 'destroy';
	}


}
