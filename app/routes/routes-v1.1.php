<?php

/**
 *	Static endpoints
 */
 
/**	
 *	Authenticated Engine Oauth2
 */
Route::group(array('before'=> 'auth'), function()
{
	Route::any ('oauth2-e/register', 'ViewController@registerapp');
});

/**	
 *	Engine-based Oauth2
 */
Route::any ('login-e',              'ViewController@login');
Route::any ('logout-e',             'ViewController@logout');
Route::any ('oauth2-e/register',    'ViewController@registerapp');
Route::any ('oauth2-e/revoke',      'ViewController@logout');
Route::any ('oauth2-e/approve',     'ViewController@approve');
Route::any ('oauth2-e/{path?}',     'Oauth2Controller@e_dispatch')->where ('path', '.+');

/**
 *  Invitations && User info
 */
Route::any ('invitation/{path?}',       'ViewController@registeruser')->where ('path', '.+');
Route::any ('changepassword/{path?}',   'ViewController@changepassword')->where ('path', '.+');
Route::any ('forgotpassword/{path?}',     'ViewController@forgotpassword')->where ('path', '.+');

/**
 *	Guest endpoints. No OAuth2 required
 */
Route::group (array('prefix'=> '1.1'), function($v) {

    # System
    Route::get('version', 'ApiDocsController@apiversion');

});


# Documentation
Route::get('apidocs/{version?}','ApiDocsController@index');


/**
 *	Authenticated endpoints
 *
 *	Some endpoints are supported by RESTful controllers
 *	[http://laravel.com/docs/4.2/controllers#restful-resource-controllers]
 *
 *	Following routes might be supported
 *	GET			/resource				index		resource.index
 *	POST		/resource				store		resource.store
 *	GET			/resource/{resource}	show		resource.show
 *	PUT/PATCH	/resource/{resource}	update		resource.update
 *	DELETE		/resource/{resource}	destroy		resource.destroy
 */
Route::group (array('prefix'=> '1.1', 'before'=> 'auth'), function($v)
{
    # System
	Route::get	('loginstatus',	'Oauth2Controller@status');
	Route::get	('logs/digest',		'LogController@digest');


	# Accounts
	Route::resource	('accounts', 				'AccountController',	array ('except' => array('create', 'edit')));
	
	# Accounts variations
	Route::resource	('users.accounts',		    'AccountController',	array ('except' => array('create', 'edit')));
	Route::resource	('resellers.accounts',		'AccountController',	array ('except' => array('create', 'edit')));

	# Users
	Route::resource	('users',	                'UserController',	    array ('except' => array('create', 'edit')));
	
	# Users variations
	Route::resource	('accounts.users',		    'UserController',	    array ('except' => array('create', 'edit')));
	
	# Services
    Route::get		('services/available', 					            'ServiceController@available');

    Route::resource	('services',	            'ServiceController',	array ('except' => array('create', 'edit')));

    # Services variations
    Route::get		('accounts/{id}/services/{token}/auth', 			'ServiceController@show')->where ('token', '[a-z]+');
    Route::post		('accounts/{id}/services/{token}', 					'ServiceController@store')->where ('token', '[a-z]+');
    Route::get		('accounts/{id}/serviceids', 					    'ServiceController@index')->where ('id', '[0-9]+');
    Route::get		('accounts/{id}/services', 					        'ServiceController@index')->where ('id', '[0-9]+');

	Route::resource	('accounts.services',		'ServiceController',	array ('except' => array('store', 'create', 'edit')));
	
	# Channels
    # Route::get		('channelids', 					                    'ChannelController@index');

    Route::resource	('channels',	            'ChannelController',	array ('except' => array('create', 'edit')));

    # Channels variations
    Route::get		('accounts/{id}/channelids', 					    'ChannelController@index')->where ('id', '[0-9]+');
    Route::get		('accounts/{id}/channels', 					        'ChannelController@index')->where ('id', '[0-9]+');
    Route::post		('accounts/{id}/channels',                          'ChannelController@store')->where ('id', '[0-9]+');
    Route::get		('channels/{id}/channels', 					        'ChannelController@index')->where ('id', '[0-9]+');

    # Streams
    Route::get		('streams/{id}/refresh', 					        'StreamController@refresh')->where ('id', '[0-9]+');
    Route::get		('streams/{id}/besttimetopost', 					'StreamController@besttimetopost')->where ('id', '[0-9]+');
    Route::get		('streams/{id}/actions', 					        'StreamController@actions')->where ('id', '[0-9]+');

    Route::resource	('streams',	                'StreamController',	    array ('except' => array('create', 'edit')));

    # Streams variations
    Route::get		('channels/{id}/streamids', 					    'StreamController@index')->where ('id', '[0-9]+');
    Route::get		('channels/{id}/streams', 					        'StreamController@index')->where ('id', '[0-9]+');

    # Plans
	Route::resource	('plans',                   'PlanController',       array ('except' => array('create', 'edit')));
	
	# Plans variations
	Route::resource	('resellers.plans',	        'PlanController',       array ('except' => array('create', 'edit')));
	
	# Resellers
	Route::resource	('resellers',               'ResellerController',   array ('except' => array('create', 'edit')));

    # Messages
    Route::get		('messages/{id}/actions', 					        'MessageController@actions')->where ('id', '[0-9]+');
    Route::post		('messages/{id}/actions/{token}', 					'MessageController@actions')->where ('token', '[a-z]+');
    Route::get		('messages/{id}/original', 					        'MessageController@original')->where ('id', '[0-9]+');
    Route::patch	('messages/{id}/original', 					        'MessageController@original')->where ('id', '[0-9]+');
    Route::patch	('messages/{id}/skip', 					            'MessageController@skip')->where ('id', '[0-9]+');

    Route::resource	('messages',	             'MessageController',	array ('except' => array('create', 'edit')));

    # Messages variations
    Route::get		('accounts/{id}/messages', 					        'MessageController@index')->where ('id', '[0-9]+');
    Route::post		('accounts/{id}/messages', 					        'MessageController@index')->where ('id', '[0-9]+');

    Route::get		('channels/{id}/messages', 					        'MessageController@index')->where ('id', '[0-9]+');
    Route::get		('channels/{id}/messageids', 					    'MessageController@index')->where ('id', '[0-9]+');

    Route::get		('streams/{id}/messages', 					        'MessageController@index')->where ('id', '[0-9]+');
    Route::get		('streams/{id}/messageids', 					    'MessageController@index')->where ('id', '[0-9]+');

    Route::get		('contacts/{id}/messages', 					        'MessageController@index')->where ('id', '[0-9]+');
    Route::get		('contacts/{id}/messageids', 					    'MessageController@index')->where ('id', '[0-9]+');

});

// 404 Not found
Route::any ('1.1/{path?}', function ()
{
	return Response::json (array ('error' => array ('message' => 'Endpoint not found in api routing file')), 404);
});