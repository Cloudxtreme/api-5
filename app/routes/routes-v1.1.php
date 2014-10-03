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
Route::any ('mlogin-e',             'ViewController@mlogin');
Route::any ('logout-e',             'ViewController@logout');
Route::any ('oauth2-e/register',    'ViewController@registerapp');
Route::any ('oauth2-e/revoke',      'ViewController@logout');
Route::any ('oauth2-e/approve',     'ViewController@approve');
Route::any ('oauth2-e/{path?}',     'Oauth2Controller@e_dispatch')->where ('path', '.+');

/**
 *  Invitations && User info
 */
Route::get ('invitation/{path?}',       'ViewController@registeruser')->where ('path', '.+');
Route::any ('recoverpassword/{path?}',  'ViewController@recoverpassword')->where ('path', '.+');
Route::any ('changepassword/{path?}',   'ViewController@changepassword')->where ('path', '.+');

/**
 *	Guest endpoints
 */
Route::group (array ('prefix' => '1.1'), function ($v)
{
	Route::get ('version', 'ProxyController@guest');
});

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
	Route::get	('loginstatus',	'Oauth2Controller@status');
	
	// Accounts
	Route::resource	('accounts', 			'AccountController',	array ('except' => array('create', 'edit', 'destroy')));
	Route::resource	('accounts.services',	'ServiceController',	array ('except' => array('create', 'edit')));
	// Route::post		('account/{id}/services/{token}')->where ('token', '[a-z]+');
	Route::get	('accounts/{accountId}/alerts', 				'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/filteroptions',			'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/licenses', 				'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/licenses', 				'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/messages', 				'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/noteids', 				'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/notes', 					'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/notes', 					'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/read', 					'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/rolegroups', 			'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/serviceids', 			'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/services/available',		'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/services/{serviceToken}','ProxyController@authenticated');
	Route::get	('accounts/{accountId}/statisticids/{timeSpan}','ProxyController@authenticated');
	Route::get	('accounts/{accountId}/statistics', 			'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/statistics/{timeSpan}', 	'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/tagids/{tagId}',			'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/tags',					'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/triggerids',				'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/triggers',				'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/triggers',				'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/urlshortener/shorten',	'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/urlshortener/{token}',	'ProxyController@authenticated');
	Route::put	('accounts/{accountId}/urlshortener/{token}',	'ProxyController@authenticated');
	Route::post	('accounts/{accountId}/users',					'ProxyController@authenticated');
	Route::get	('accounts/{accountId}/users/{userId}',			'ProxyController@authenticated');
	Route::put	('accounts/{accountId}/users/{userId}',			'ProxyController@authenticated');
	Route::patch('accounts/{accountId}/users/{userId}',			'ProxyController@authenticated');
	Route::patch('accounts/{accountId}/validate',				'ProxyController@authenticated');

	// Users
	Route::get      ('users/{userId}',                  'ProxyController@authenticated');
	Route::put      ('users/{userId}',                  'ProxyController@authenticated');
	Route::put      ('users/{userId}/password',         'ProxyController@authenticated');
	Route::get      ('users/{userId}/subscriptions',    'ProxyController@authenticated');
	Route::delete   ('users/{userId}/subscriptions',    'ProxyController@authenticated');
	Route::post     ('users/{userId}/subscriptions',    'ProxyController@authenticated');
	
	// Contacts
	Route::get      ('accounts/{accountId}/contactids',                             'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contactids/following',                   'ProxyController@authenticated');
	Route::post     ('accounts/{accountId}/contacts',                               'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts',                               'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/following',                     'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/search/{network}',              'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}',                   'ProxyController@authenticated');
	Route::put      ('accounts/{accountId}/contacts/{contactId}',                   'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/conversationids',   'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/conversations',     'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/messages',          'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/noteids',           'ProxyController@authenticated');
	Route::post     ('accounts/{accountId}/contacts/{contactId}/notes',             'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/notes',             'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/tagids',            'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/contacts/{contactId}/tags',              'ProxyController@authenticated');
	Route::post     ('accounts/{accountId}/contacts/{contactId}/tags',              'ProxyController@authenticated');
	Route::delete   ('accounts/{accountId}/contacts/{contactId}/tags/{tagId}',      'ProxyController@authenticated');
	
	// Services				
	Route::resource	('services',	'ServiceController',	array ('except' => array('create', 'edit', 'store')));
	// Route::get      ('services/{id}',                       'ProxyController@authenticated');
	// Route::delete   ('services/{id}',                       'ProxyController@authenticated');
	// Route::put      ('services/{id}',                       'ProxyController@authenticated');
	// Route::get      ('services/{id}/profiles',              'ProxyController@authenticated');
	Route::get      ('services/{id}/profiles/{profileId}',  'ProxyController@authenticated');
	Route::put      ('services/{id}/profiles/{profileId}',  'ProxyController@authenticated');
	Route::post     ('services/{id}/setup',                 'ProxyController@authenticated');
	
	// Channels
	Route::get      ('channels',                                'ProxyController@authenticated');
	Route::get      ('channels/{channelId}',                    'ProxyController@authenticated');
	Route::delete   ('channels/{channelId}',                    'ProxyController@authenticated');
	Route::put      ('channels/{channelId}',                    'ProxyController@authenticated');
	Route::post     ('channels/{channelId}/channels',           'ProxyController@authenticated');
	Route::get      ('channels/{channelId}/count',              'ProxyController@authenticated');
	Route::get      ('channels/{channelId}/messageids',         'ProxyController@authenticated');
	Route::get      ('channels/{channelId}/messages',           'ProxyController@authenticated');
	Route::get      ('channels/{channelId}/notificationsids',   'ProxyController@authenticated');
	Route::post     ('channels/{channelId}/read',               'ProxyController@authenticated');
	Route::get      ('channels/{channelId}/streamids',          'ProxyController@authenticated');
	Route::get      ('channels/{channelId}/streams',            'ProxyController@authenticated');
	
	// Streams
	Route::get  ('streams',                                         'ProxyController@authenticated');
	Route::get  ('streams/{streamId}',                              'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/actions',                      'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/besttimetopost',               'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/contacts/uniqueid/{uniqueid}', 'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/count',                        'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/followers',                    'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/following',                    'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/live/messages',                'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/live/statistics',              'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/live/messageids',              'ProxyController@authenticated');
	Route::post ('streams/{streamId}/messages',                     'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/messages',                     'ProxyController@authenticated');
	Route::post ('streams/{streamId}/read',                         'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/reportids',                    'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/reports',                      'ProxyController@authenticated');
	Route::get  ('streams/{streamId}/validate',                     'ProxyController@authenticated');
	
	// Messages
	Route::post     ('messages',                                            'ProxyController@authenticated');
	Route::get      ('messages',                                            'NeuronProxyController@getMessauthenticatedages');
	Route::delete   ('messages/{messageId}',                                'ProxyController@authenticated');
	Route::put      ('messages/{messageId}',                                'ProxyController@authenticated');
	Route::get      ('messages/{messageId}',                                'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/actions',                        'ProxyController@authenticated');
	Route::post     ('messages/{messageId}/actions/{actionToken}',          'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/noteids',                        'ProxyController@authenticated');
	Route::post     ('messages/{messageId}/notes',                          'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/notes',                          'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/original',                       'ProxyController@authenticated');
	Route::put      ('messages/{messageId}/original',                       'ProxyController@authenticated');
	Route::put      ('messages/{messageId}/read',                           'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/sendlog',                        'ProxyController@authenticated');
	Route::put      ('messages/{messageId}/skip',                           'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/statistics',                     'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/statistics/{statisticToken}',    'ProxyController@authenticated');
	Route::put      ('messages/{messageId}/statistics/{statisticToken}',    'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/tagids',                         'ProxyController@authenticated');
	Route::get      ('messages/{messageId}/tags',                           'ProxyController@authenticated');
	Route::post     ('messages/{messageId}/tags',                           'ProxyController@authenticated');
	Route::delete   ('messages/{messageId}/tags/{tagId}',                   'ProxyController@authenticated');
	
	// Notifications
	Route::get  ('notifications', 'ProxyController@authenticated');
	
	// Notes
	Route::get      ('notes',                       'ProxyController@authenticated');
	Route::get      ('notes/{noteId}',              'ProxyController@authenticated');
	Route::delete   ('notes/{noteId}',              'ProxyController@authenticated');
	Route::put      ('notes/{noteId}',              'ProxyController@authenticated');
	Route::get      ('notes/{noteId}/related',      'ProxyController@authenticated');
	Route::get      ('notes/{noteId}/relatedids',   'ProxyController@authenticated');
	
	// Tags
	Route::get      ('tags',                        'ProxyController@authenticated');
	Route::get      ('tags/{tagId}',                'ProxyController@authenticated');
	Route::post     ('tags/{tagId}/tags',           'ProxyController@authenticated');
	Route::delete   ('tags/{tagId}/tags/{tagId2}',  'ProxyController@authenticated');
	
	// Triggers
	Route::put      ('triggers/{triggerId}',        'ProxyController@authenticated');
	Route::get      ('triggers/{triggerId}',        'ProxyController@authenticated');
	
	// Campaigns
	Route::get      ('accounts/{accountId}/campaigns',                  'ProxyController@authenticated');
	Route::put      ('accounts/{accountId}/campaigns',                  'ProxyController@authenticated');
	Route::post     ('accounts/{accountId}/campaigns',                  'ProxyController@authenticated');
	Route::delete   ('accounts/{accountId}/campaigns/{campaignId}',     'ProxyController@authenticated');
	Route::get      ('accounts/{accountId}/campaigns/{campaignId}',     'ProxyController@authenticated');
	Route::put      ('accounts/{accountId}/campaigns/{campaignId}',     'ProxyController@authenticated');
	
	// Group
	Route::post     ('accounts/{groupId}/groups',   'ProxyController@authenticated');
	Route::get      ('groups',                      'ProxyController@authenticated');
	Route::put      ('groups/{groupId}',            'ProxyController@authenticated');
	
	// Log
	Route::post ('log', 'ProxyController@authenticated');
	
	// Mailer
	Route::get  ('mailer/bounces',              'ProxyController@authenticated');
	Route::get  ('mailer/bounces/{bounceId}',   'ProxyController@authenticated');
	Route::get  ('mailer/emails',               'ProxyController@authenticated');
	Route::get  ('mailer/emails/{emailId}',     'ProxyController@authenticated');
	
	// Ping
	Route::get  ('accounts/{accountId}/ping',   'ProxyController@authenticated');
	
	// Resellers
	Route::get  ('reseller/{resellerId}',                       'ProxyController@authenticated');
	Route::get  ('reseller/{resellerId}/accounts',              'ProxyController@authenticated');
	Route::post ('reseller/{resellerId}/accounts',              'ProxyController@authenticated');
	Route::put  ('reseller/{resellerId}/accounts/{accountId}',  'ProxyController@authenticated');
	Route::get  ('reseller/{resellerId}/plans',                 'ProxyController@authenticated');
	Route::post ('reseller/{resellerId}/plans',                 'ProxyController@authenticated');
	Route::put  ('reseller/{resellerId}/plans/{planId}',        'ProxyController@authenticated');
});

// 404 Not found
Route::any ('1.1/{path?}', function ()
{
	return Response::json (array ('error' => array ('message' => 'Endpoint not found in api routing file')), 404);
});