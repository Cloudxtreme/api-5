<?php

/**
 *	Static endpoints
 */


/**	
 *	Engine-based Oauth2
 */
Route::any('login-e', 'ViewController@login');
Route::any('revoke', 'ViewController@logout');
Route::any('oauth2-e/approve', 'ViewController@approve');
Route::any('oauth2-e/{path?}', 'Oauth2Controller@e_dispatch')->where ('path', '.+');




/**
 *	Guest endpoints
 */
Route::group (array ('prefix' => '1.1'), function ($v)
{
	Route::get ('version', 'ProxyController@guest');
	Route::get ('loginstatus', 'Oauth2Controller@status');
});


/**
 *	Authenticated endpoints
 */
Route::group(array('prefix' => '1.1', /*'namespace' => $namespace, */ 'before' => 'auth'), function($v)
{

	/////////////////////////////////////   ACCOUNTS   ///////////////////////////////////////
	Route::get('accounts/{accountId}', 'NeuronProxyController@authenticated');
	Route::put('accounts/{accountId}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/alerts', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/filteroptions', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/licenses', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/licenses', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/messages', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/noteids', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/notes', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/notes', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/read', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/reportids', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/reports', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/rolegroups', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/serviceids', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/services', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/services/available', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/services/{serviceToken}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/statisticids/{timeSpan}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/statistics', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/statistics/{timeSpan}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/tagids/{tagId}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/tags', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/triggerids', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/triggers', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/triggers', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/urlshortener/shorten', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/urlshortener/{token}', 'NeuronProxyController@authenticated');
	Route::put('accounts/{accountId}/urlshortener/{token}', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/users', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/users/{userId}', 'NeuronProxyController@authenticated');
	Route::put('accounts/{accountId}/users/{userId}', 'NeuronProxyController@authenticated');
	Route::patch('accounts/{accountId}/users/{userId}', 'NeuronProxyController@authenticated');
	Route::patch('accounts/{accountId}/validate', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/ping', 'NeuronProxyController@authenticated');
	///////////////////////////////////////   ADMIN   /////////////////////////////////////////
	Route::get('admin/accountplans', 'NeuronProxyController@authenticated');
	Route::post('admin/accountplans', 'NeuronProxyController@authenticated');
	Route::get('admin/accountplans/{planId}', 'NeuronProxyController@authenticated');
	Route::put('admin/accountplans/{planId}', 'NeuronProxyController@authenticated');
	Route::delete('admin/accountplans/{planId}', 'NeuronProxyController@authenticated');
	Route::post('admin/accounts', 'NeuronProxyController@authenticated');
	Route::get('admin/accounts', 'NeuronProxyController@authenticated');
	Route::get('admin/accounts/{accountId}', 'NeuronProxyController@authenticated');
	Route::put('admin/accounts/{accountId}', 'NeuronProxyController@authenticated');
	Route::delete('admin/accounts/{accountId}', 'NeuronProxyController@authenticated');
	Route::get('admin/bounces', 'NeuronProxyController@authenticated');
	Route::get('admin/bounces/{bounceId}', 'NeuronProxyController@authenticated');
	Route::get('admin/performance', 'NeuronProxyController@authenticated');
	Route::get('admin/procedures', 'NeuronProxyController@authenticated');
	Route::get('admin/streams', 'NeuronProxyController@authenticated');
	Route::get('admin/streams/refresh/{streamId}', 'NeuronProxyController@authenticated');
	Route::get('admin/users', 'NeuronProxyController@authenticated');
	Route::post('admin/users', 'NeuronProxyController@authenticated');
	Route::get('admin/users/{userId}', 'NeuronProxyController@authenticated');
	Route::put('admin/users/{userId}', 'NeuronProxyController@authenticated');
	Route::delete('admin/users/{userId}', 'NeuronProxyController@authenticated');
	/////////////////////////////////////   CAMPAIGNS   ///////////////////////////////////////
	Route::get('accounts/{accountId}/campaigns', 'NeuronProxyController@authenticated');
	Route::put('accounts/{accountId}/campaigns', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/campaigns', 'NeuronProxyController@authenticated');
	Route::delete('accounts/{accountId}/campaigns/{campaignId}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/campaigns/{campaignId}', 'NeuronProxyController@authenticated');
	Route::put('accounts/{accountId}/campaigns/{campaignId}', 'NeuronProxyController@authenticated');
	/////////////////////////////////////   CHANNELS   ///////////////////////////////////////
	Route::get('channels', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}', 'NeuronProxyController@authenticated');
	Route::delete('channels/{channelId}', 'NeuronProxyController@authenticated');
	Route::put('channels/{channelId}', 'NeuronProxyController@authenticated');
	Route::post('channels/{channelId}/channels', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}/count', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}/messageids', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}/messages', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}/notificationsids', 'NeuronProxyController@authenticated');
	Route::post('channels/{channelId}/read', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}/streamids', 'NeuronProxyController@authenticated');
	Route::get('channels/{channelId}/streams', 'NeuronProxyController@authenticated');
	/////////////////////////////////////   CONTACTS   ///////////////////////////////////////
	Route::get('accounts/{accountId}/contactids', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contactids/following', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/contacts', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/following', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/search/{network}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}', 'NeuronProxyController@authenticated');
	Route::put('accounts/{accountId}/contacts/{contactId}', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/conversationids', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/conversations', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/messages', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/noteids', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/contacts/{contactId}/notes', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/notes', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/tagids', 'NeuronProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/tags', 'NeuronProxyController@authenticated');
	Route::post('accounts/{accountId}/contacts/{contactId}/tags', 'NeuronProxyController@authenticated');
	Route::delete('accounts/{accountId}/contacts/{contactId}/tags/{tagId}', 'NeuronProxyController@authenticated');
	/////////////////////////////////////   GROUP   ///////////////////////////////////////
	Route::post('accounts/{groupId}/groups', 'NeuronProxyController@authenticated');
	Route::get('groups', 'NeuronProxyController@authenticated');
	Route::put('groups/{groupId}', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   LOG   ////////////////////////////////////////
	Route::post('log', 'NeuronProxyController@authenticated');
	////////////////////////////////////   MAILER   ////////////////////////////////////////
	Route::get('mailer/bounces', 'NeuronProxyController@authenticated');
	Route::get('mailer/bounces/{bounceId}', 'NeuronProxyController@authenticated');
	Route::get('mailer/emails', 'NeuronProxyController@authenticated');
	Route::get('mailer/emails/{emailId}', 'NeuronProxyController@authenticated');
	////////////////////////////////////   MESSAGES   ////////////////////////////////////////
	Route::post('messages', 'NeuronProxyController@authenticated');
	Route::get('messages', 'NeuronProxyController@getMessauthenticatedages');
	Route::delete('messages/{messageId}', 'NeuronProxyController@authenticated');
	Route::put('messages/{messageId}', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/actions', 'NeuronProxyController@authenticated');
	Route::post('messages/{messageId}/actions/{actionToken}', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/noteids', 'NeuronProxyController@authenticated');
	Route::post('messages/{messageId}/notes', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/notes', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/original', 'NeuronProxyController@authenticated');
	Route::put('messages/{messageId}/original', 'NeuronProxyController@authenticated');
	Route::put('messages/{messageId}/read', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/sendlog', 'NeuronProxyController@authenticated');
	Route::put('messages/{messageId}/skip', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/statistics', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/statistics/{statisticToken}', 'NeuronProxyController@authenticated');
	Route::put('messages/{messageId}/statistics/{statisticToken}', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/tagids', 'NeuronProxyController@authenticated');
	Route::get('messages/{messageId}/tags', 'NeuronProxyController@authenticated');
	Route::post('messages/{messageId}/tags', 'NeuronProxyController@authenticated');
	Route::delete('messages/{messageId}/tags/{tagId}', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   NOTES   ////////////////////////////////////////
	Route::get('notes', 'NeuronProxyController@authenticated');
	Route::get('notes/{noteId}', 'NeuronProxyController@authenticated');
	Route::delete('notes/{noteId}', 'NeuronProxyController@authenticated');
	Route::put('notes/{noteId}', 'NeuronProxyController@authenticated');
	Route::get('notes/{noteId}/related', 'NeuronProxyController@authenticated');
	Route::get('notes/{noteId}/relatedids', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   NOTIFICATIONS   ////////////////////////////////////////
	Route::get('notifications', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   REPORTS   ////////////////////////////////////////
	Route::get('reports', 'NeuronProxyController@authenticated');
	Route::get('reports/{id}', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   RESELLER   ////////////////////////////////////////
	Route::get('reseller/{resellerId}', 'NeuronProxyController@authenticated');
	Route::get('reseller/{resellerId}/accounts', 'NeuronProxyController@authenticated');
	Route::post('reseller/{resellerId}/accounts', 'NeuronProxyController@authenticated');
	Route::put('reseller/{resellerId}/accounts/{accountId}', 'NeuronProxyController@authenticated');
	Route::get('reseller/{resellerId}/plans', 'NeuronProxyController@authenticated');
	Route::post('reseller/{resellerId}/plans', 'NeuronProxyController@authenticated');
	Route::put('reseller/{resellerId}/plans/{planId}', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   SERVICES   ////////////////////////////////////////
	Route::get('services/{id}', 'NeuronProxyController@authenticated');
	Route::delete('services/{id}', 'NeuronProxyController@authenticated');
	Route::put('services/{id}', 'NeuronProxyController@authenticated');
	Route::get('services/{id}/profiles', 'NeuronProxyController@authenticated');
	Route::get('services/{id}/profiles/{profileId}', 'NeuronProxyController@authenticated');
	Route::put('services/{id}/profiles/{profileId}', 'NeuronProxyController@authenticated');
	Route::post('services/{id}/setup', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   STREAMS   ////////////////////////////////////////
	Route::get('streams', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/actions', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/besttimetopost', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/contacts/uniqueid/{uniqueid}', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/count', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/followers', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/following', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/live/messages', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/live/statistics', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/live/messageids', 'NeuronProxyController@authenticated');
	Route::post('streams/{streamId}/messages', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/messages', 'NeuronProxyController@authenticated');
	Route::post('streams/{streamId}/read', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/reportids', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/reports', 'NeuronProxyController@authenticated');
	Route::get('streams/{streamId}/validate', 'NeuronProxyController@authenticated');
	/////////////////////////////////////   TAGS   ////////////////////////////////////////
	Route::get('tags', 'NeuronProxyController@authenticated');
	Route::get('tags/{tagId}', 'NeuronProxyController@authenticated');
	Route::post('tags/{tagId}/tags', 'NeuronProxyController@authenticated');
	Route::delete('tags/{tagId}/tags/{tagId2}', 'NeuronProxyController@authenticated');
	///////////////////////////////////   TRIGGERS   /////////////////////////////////////
	Route::put('triggers/{triggerId}', 'NeuronProxyController@authenticated');
	Route::get('triggers/{triggerId}', 'NeuronProxyController@authenticated');
	//////////////////////////////////   URLSHORTENER   //////////////////////////////////
	Route::post('urlshortener/shorten', 'NeuronProxyController@authenticated');
	//////////////////////////////////////   USERS   /////////////////////////////////////
	Route::get('users/{userId}', 'NeuronProxyController@authenticated');
	Route::put('users/{userId}', 'NeuronProxyController@authenticated');
	Route::put('users/{userId}/password', 'NeuronProxyController@authenticated');
//	Route::put('users/{userId}/password', 'LoginController@changePassword');
	Route::get('users/{userId}/subscriptions', 'NeuronProxyController@authenticated');
	Route::delete('users/{userId}/subscriptions', 'NeuronProxyController@authenticated');
	Route::post('users/{userId}/subscriptions', 'NeuronProxyController@authenticated');

	Route::any ('{path?}', function ()
	{
		return Response::json (array ('error' => array ('message' => 'Endpoint not found in api routing file')), 404);
	});
});