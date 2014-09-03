<?php

use bmgroup\CloudwalkersClient\CwGearmanClient;
use bmgroup\OAuth2\Verifier;
use Neuron\MapperFactory;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//$namespace = Request::segment(2);

Route::group (array ('prefix' => '1.1'), function ($v)
{
	Route::get ('version', 'ProxyController@guest');
});

Route::group(array('prefix' => '1.1', /*'namespace' => $namespace, */ 'before' => 'oauth2'), function($v)
{
	// THE NEW ONES
	Route::get('accounts/{accountId}/ping', 'ProxyController@authenticated');
	
	/////////////////////////////////////   ACCOUNTS   ///////////////////////////////////////
	Route::get('accounts/{accountId}', 'ProxyController@authenticated');
	Route::put('accounts/{accountId}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/alerts', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/filteroptions', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/licenses', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/licenses', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/messages', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/noteids', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/notes', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/notes', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/read', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/reportids', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/reports', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/rolegroups', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/serviceids', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/services', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/services/available', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/services/{serviceToken}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/statisticids/{timeSpan}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/statistics', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/statistics/{timeSpan}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/tagids/{tagId}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/tags', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/triggerids', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/triggers', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/triggers', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/urlshortener/shorten', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/urlshortener/{token}', 'ProxyController@authenticated');
	Route::put('accounts/{accountId}/urlshortener/{token}', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/users', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/users/{userId}', 'ProxyController@authenticated');
	Route::put('accounts/{accountId}/users/{userId}', 'ProxyController@authenticated');
	Route::patch('accounts/{accountId}/users/{userId}', 'ProxyController@authenticated');
	Route::patch('accounts/{accountId}/validate', 'ProxyController@authenticated');
	///////////////////////////////////////   ADMIN   /////////////////////////////////////////
	Route::get('admin/accountplans', 'ProxyController@authenticated');
	Route::post('admin/accountplans', 'ProxyController@authenticated');
	Route::get('admin/accountplans/{planId}', 'ProxyController@authenticated');
	Route::put('admin/accountplans/{planId}', 'ProxyController@authenticated');
	Route::delete('admin/accountplans/{planId}', 'ProxyController@authenticated');
	Route::post('admin/accounts', 'ProxyController@authenticated');
	Route::get('admin/accounts', 'ProxyController@authenticated');
	Route::get('admin/accounts/{accountId}', 'ProxyController@authenticated');
	Route::put('admin/accounts/{accountId}', 'ProxyController@authenticated');
	Route::delete('admin/accounts/{accountId}', 'ProxyController@authenticated');
	Route::get('admin/bounces', 'ProxyController@authenticated');
	Route::get('admin/bounces/{bounceId}', 'ProxyController@authenticated');
	Route::get('admin/performance', 'ProxyController@authenticated');
	Route::get('admin/procedures', 'ProxyController@authenticated');
	Route::get('admin/streams', 'ProxyController@authenticated');
	Route::get('admin/streams/refresh/{streamId}', 'ProxyController@authenticated');
	Route::get('admin/users', 'ProxyController@authenticated');
	Route::post('admin/users', 'ProxyController@authenticated');
	Route::get('admin/users/{userId}', 'ProxyController@authenticated');
	Route::put('admin/users/{userId}', 'ProxyController@authenticated');
	Route::delete('admin/users/{userId}', 'ProxyController@authenticated');
	/////////////////////////////////////   CAMPAIGNS   ///////////////////////////////////////
	Route::get('accounts/{accountId}/campaigns', 'ProxyController@authenticated');
	Route::put('accounts/{accountId}/campaigns', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/campaigns', 'ProxyController@authenticated');
	Route::delete('accounts/{accountId}/campaigns/{campaignId}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/campaigns/{campaignId}', 'ProxyController@authenticated');
	Route::put('accounts/{accountId}/campaigns/{campaignId}', 'ProxyController@authenticated');
	/////////////////////////////////////   CHANNELS   ///////////////////////////////////////
	Route::get('channels', 'ProxyController@authenticated');
	Route::get('channels/{channelId}', 'ProxyController@authenticated');
	Route::delete('channels/{channelId}', 'ProxyController@authenticated');
	Route::put('channels/{channelId}', 'ProxyController@authenticated');
	Route::post('channels/{channelId}/channels', 'ProxyController@authenticated');
	Route::get('channels/{channelId}/count', 'ProxyController@authenticated');
	Route::get('channels/{channelId}/messageids', 'ProxyController@authenticated');
	Route::get('channels/{channelId}/messages', 'ProxyController@authenticated');
	Route::get('channels/{channelId}/notificationsids', 'ProxyController@authenticated');
	Route::post('channels/{channelId}/read', 'ProxyController@authenticated');
	Route::get('channels/{channelId}/streamids', 'ProxyController@authenticated');
	Route::get('channels/{channelId}/streams', 'ProxyController@authenticated');
	/////////////////////////////////////   CONTACTS   ///////////////////////////////////////
	Route::get('accounts/{accountId}/contactids', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contactids/following', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/contacts', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/following', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/search/{network}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}', 'ProxyController@authenticated');
	Route::put('accounts/{accountId}/contacts/{contactId}', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/conversationids', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/conversations', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/messages', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/noteids', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/contacts/{contactId}/notes', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/notes', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/tagids', 'ProxyController@authenticated');
	Route::get('accounts/{accountId}/contacts/{contactId}/tags', 'ProxyController@authenticated');
	Route::post('accounts/{accountId}/contacts/{contactId}/tags', 'ProxyController@authenticated');
	Route::delete('accounts/{accountId}/contacts/{contactId}/tags/{tagId}', 'ProxyController@authenticated');
	/////////////////////////////////////   GROUP   ///////////////////////////////////////
	Route::post('accounts/{groupId}/groups', 'ProxyController@authenticated');
	Route::get('groups', 'ProxyController@authenticated');
	Route::put('groups/{groupId}', 'ProxyController@authenticated');
	//////////////////////////////////////   LOG   ////////////////////////////////////////
	Route::post('log', 'ProxyController@authenticated');
	////////////////////////////////////   MAILER   ////////////////////////////////////////
	Route::get('mailer/bounces', 'ProxyController@authenticated');
	Route::get('mailer/bounces/{bounceId}', 'ProxyController@authenticated');
	Route::get('mailer/emails', 'ProxyController@authenticated');
	Route::get('mailer/emails/{emailId}', 'ProxyController@authenticated');
	////////////////////////////////////   MESSAGES   ////////////////////////////////////////
	Route::post('messages', 'ProxyController@authenticated');
	Route::get('messages', 'ProxyController@getMessauthenticatedages');
	Route::delete('messages/{messageId}', 'ProxyController@authenticated');
	Route::put('messages/{messageId}', 'ProxyController@authenticated');
	Route::get('messages/{messageId}', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/actions', 'ProxyController@authenticated');
	Route::post('messages/{messageId}/actions/{actionToken}', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/noteids', 'ProxyController@authenticated');
	Route::post('messages/{messageId}/notes', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/notes', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/original', 'ProxyController@authenticated');
	Route::put('messages/{messageId}/original', 'ProxyController@authenticated');
	Route::put('messages/{messageId}/read', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/sendlog', 'ProxyController@authenticated');
	Route::put('messages/{messageId}/skip', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/statistics', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/statistics/{statisticToken}', 'ProxyController@authenticated');
	Route::put('messages/{messageId}/statistics/{statisticToken}', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/tagids', 'ProxyController@authenticated');
	Route::get('messages/{messageId}/tags', 'ProxyController@authenticated');
	Route::post('messages/{messageId}/tags', 'ProxyController@authenticated');
	Route::delete('messages/{messageId}/tags/{tagId}', 'ProxyController@authenticated');
	//////////////////////////////////////   NOTES   ////////////////////////////////////////
	Route::get('notes', 'ProxyController@authenticated');
	Route::get('notes/{noteId}', 'ProxyController@authenticated');
	Route::delete('notes/{noteId}', 'ProxyController@authenticated');
	Route::put('notes/{noteId}', 'ProxyController@authenticated');
	Route::get('notes/{noteId}/related', 'ProxyController@authenticated');
	Route::get('notes/{noteId}/relatedids', 'ProxyController@authenticated');
	//////////////////////////////////////   NOTIFICATIONS   ////////////////////////////////////////
	Route::get('notifications', 'ProxyController@authenticated');
	//////////////////////////////////////   REPORTS   ////////////////////////////////////////
	Route::get('reports', 'ProxyController@authenticated');
	Route::get('reports/{id}', 'ProxyController@authenticated');
	//////////////////////////////////////   RESELLER   ////////////////////////////////////////
	Route::get('reseller/{resellerId}', 'ProxyController@authenticated');
	Route::get('reseller/{resellerId}/accounts', 'ProxyController@authenticated');
	Route::post('reseller/{resellerId}/accounts', 'ProxyController@authenticated');
	Route::put('reseller/{resellerId}/accounts/{accountId}', 'ProxyController@authenticated');
	Route::get('reseller/{resellerId}/plans', 'ProxyController@authenticated');
	Route::post('reseller/{resellerId}/plans', 'ProxyController@authenticated');
	Route::put('reseller/{resellerId}/plans/{planId}', 'ProxyController@authenticated');
	//////////////////////////////////////   SERVICES   ////////////////////////////////////////
	Route::get('services/{id}', 'ProxyController@authenticated');
	Route::delete('services/{id}', 'ProxyController@authenticated');
	Route::put('services/{id}', 'ProxyController@authenticated');
	Route::get('services/{id}/profiles', 'ProxyController@authenticated');
	Route::get('services/{id}/profiles/{profileId}', 'ProxyController@authenticated');
	Route::put('services/{id}/profiles/{profileId}', 'ProxyController@authenticated');
	Route::post('services/{id}/setup', 'ProxyController@authenticated');
	//////////////////////////////////////   STREAMS   ////////////////////////////////////////
	Route::get('streams', 'ProxyController@authenticated');
	Route::get('streams/{streamId}', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/actions', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/besttimetopost', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/contacts/uniqueid/{uniqueid}', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/count', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/followers', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/following', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/live/messages', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/live/statistics', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/live/messageids', 'ProxyController@authenticated');
	Route::post('streams/{streamId}/messages', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/messages', 'ProxyController@authenticated');
	Route::post('streams/{streamId}/read', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/reportids', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/reports', 'ProxyController@authenticated');
	Route::get('streams/{streamId}/validate', 'ProxyController@authenticated');
	/////////////////////////////////////   TAGS   ////////////////////////////////////////
	Route::get('tags', 'ProxyController@authenticated');
	Route::get('tags/{tagId}', 'ProxyController@authenticated');
	Route::post('tags/{tagId}/tags', 'ProxyController@authenticated');
	Route::delete('tags/{tagId}/tags/{tagId2}', 'ProxyController@authenticated');
	///////////////////////////////////   TRIGGERS   /////////////////////////////////////
	Route::put('triggers/{triggerId}', 'ProxyController@authenticated');
	Route::get('triggers/{triggerId}', 'ProxyController@authenticated');
	//////////////////////////////////   URLSHORTENER   //////////////////////////////////
	Route::post('urlshortener/shorten', 'ProxyController@authenticated');
	//////////////////////////////////////   USERS   /////////////////////////////////////
	Route::get('users/{userId}', 'ProxyController@authenticated');
	Route::put('users/{userId}', 'ProxyController@authenticated');
	Route::put('users/{userId}/password', 'ProxyController@authenticated');
	Route::get('users/{userId}/subscriptions', 'ProxyController@authenticated');
	Route::delete('users/{userId}/subscriptions', 'ProxyController@authenticated');
	Route::post('users/{userId}/subscriptions', 'ProxyController@authenticated');
	
	Route::any ('{path?}', function ()
	{
		return Response::json (array ('error' => array ('message' => 'Endpoint not found in api routing file')), 404);
	});
});

Route::get('/', function()
{
	return View::make('hello');
});

Route::get ('loginstatus', function ()
{
	\Neuron\Session::getInstance ()->connect ();
	$login = \Neuron\Session::getInstance ()->isLogin ();
	return Response::json (array ('login' => $login));
});


Route::get ('docs{path?}', function ($path = "")
{
	return Redirect::to ('https://superadmin.cloudwalkers.be/docs' . str_replace (" ", "+", $path));
})->where ('path', '.+');


Route::any('login/{path?}', 'LoginController@login')->where ('path', '.+');
Route::any('logout/{path?}', 'LoginController@logout')->where ('path', '.+');
Route::any('loginx/{path?}', 'CommunicationController@login')->where ('path', '.+');
Route::any('email/{path?}', 'CommunicationController@email')->where ('path', '.+');
Route::any('sms/{path?}', 'CommunicationController@sms')->where ('path', '.+');
Route::get ('1/version', 'ProxyController@guest');

Route::get ('authenticate/{path?}', 'ProxyController@guest')->where ('path', '.+');

Route::any('oauth2/{path?}', 'Oauth2Controller@dispatch')->where ('path', '.+');;

// Reseller endpoints
Route::group(array('before' => 'resellersigned'), function($v)
{

	Route::get('1/resellers/{resellerId}/plans', 'ProxyController@openssl');

});

// The All Catching One
Route::match (array ('GET', 'POST', 'PATCH', 'PUT', 'DELETE'), '{path?}', 'ProxyController@authenticated')->where ('path', '.+')->before (array ('before' => 'oauth2'));
