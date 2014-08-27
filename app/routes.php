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
$namespace = 'v'.Request::segment(2);

Route::group(array('prefix' => 'cw/{v}', 'namespace' => $namespace, 'before' => 'oauth2'), function($v)
{
	/////////////////////////////////////   ACCOUNTS   ///////////////////////////////////////
	Route::get('accounts/{accountId}', 'AccountsController@getAccountsId');
	Route::put('accounts/{accountId}', 'AccountsController@putAccountsId');
	Route::get('accounts/{accountId}/alerts', 'AccountsController@getAccountsIdAlerts');
	Route::get('accounts/{accountId}/filteroptions', 'AccountsController@getAccountsIdFilterOptions');
	Route::get('accounts/{accountId}/licenses', 'AccountsController@getAccountsIdLicenses');
	Route::post('accounts/{accountId}/licenses', 'AccountsController@postAccountsIdLicenses');
	Route::post('accounts/{accountId}/messages', 'AccountsController@postAccountsIdMessages');
	Route::get('accounts/{accountId}/noteids', 'AccountsController@getAccountsIdNotesids');
	Route::get('accounts/{accountId}/notes', 'AccountsController@getAccountsIdNotes');
	Route::post('accounts/{accountId}/notes', 'AccountsController@postAccountsIdNotes');
	Route::get('accounts/{accountId}/ping', 'AccountsController@getAccountsIdPing');
	Route::post('accounts/{accountId}/read', 'AccountsController@postAccountsIdRead');
	Route::get('accounts/{accountId}/reportids', 'AccountsController@getAccountsIdReportids');
	Route::get('accounts/{accountId}/reports', 'AccountsController@getAccountsIdReports');
	Route::get('accounts/{accountId}/rolegroups', 'AccountsController@gettAccountsIdRolegroups');
	Route::get('accounts/{accountId}/serviceids', 'AccountsController@getAccountsIdServiceids');
	Route::get('accounts/{accountId}/services', 'AccountsController@getAccountsIdServices');
	Route::get('accounts/{accountId}/services/available', 'AccountsController@getAccountsIdServicesAvailable');
	Route::post('accounts/{accountId}/services/{serviceToken}', 'AccountsController@postAccountsIdServicesToken');
	Route::get('accounts/{accountId}/statisticids/{timeSpan}', 'AccountsController@getAccountsIdStatisticidsTimespan');
	Route::get('accounts/{accountId}/statistics', 'AccountsController@getAccountsIdStatistics');
	Route::get('accounts/{accountId}/statistics/{timeSpan}', 'AccountsController@getAccountsIdTimespan');
	Route::get('accounts/{accountId}/tagids/{tagId}', 'AccountsController@getAccountsIdTagidsId');
	Route::get('accounts/{accountId}/tags', 'AccountsController@getAccountsIdTags');
	Route::get('accounts/{accountId}/triggerids', 'AccountsController@getAccountsIdTriggersids');
	Route::post('accounts/{accountId}/triggers', 'AccountsController@postAccountsIdTriggers');
	Route::get('accounts/{accountId}/triggers', 'AccountsController@getAccountsIdTriggers');
	Route::post('accounts/{accountId}/urlshortener/shorten', 'AccountsController@postAccountsIdUrlshortenerShorten');
	Route::get('accounts/{accountId}/urlshortener/{token}', 'AccountsController@getAccountsIdUrlshortenerToken');
	Route::put('accounts/{accountId}/urlshortener/{token}', 'AccountsController@putAccountsIdUrlshortenerToken');
	Route::post('accounts/{accountId}/users', 'AccountsController@postAccountsIdUsers');
	Route::get('accounts/{accountId}/users/{userId}', 'AccountsController@getAccountsIdUsersId');
	Route::put('accounts/{accountId}/users/{userId}', 'AccountsController@putAccountsIdUsersId');
	Route::patch('accounts/{accountId}/users/{userId}', 'AccountsController@patchAccountsIdUsersId');
	Route::patch('accounts/{accountId}/validate', 'AccountsController@patchAccountsIdValidate');
	///////////////////////////////////////   ADMIN   /////////////////////////////////////////
	Route::get('admin/accountplans', 'AdminController@getAdminAccountplans');
	Route::post('admin/accountplans', 'AdminController@postAdminAccountplans');
	Route::get('admin/accountplans/{planId}', 'AdminController@getAdminAccountplansId');
	Route::put('admin/accountplans/{planId}', 'AdminController@putAdminAccountplansId');
	Route::delete('admin/accountplans/{planId}', 'AdminController@deleteAdminAccountplansId');
	Route::post('admin/accounts', 'AdminController@postAdminAccounts');
	Route::get('admin/accounts', 'AdminController@getAdminAccounts');
	Route::get('admin/accounts/{accountId}', 'AdminController@getAdminAccountsId');
	Route::put('admin/accounts/{accountId}', 'AdminController@putAdminAccountsId');
	Route::delete('admin/accounts/{accountId}', 'AdminController@deleteAdminAccountsId');
	Route::get('admin/bounces', 'AdminController@getAdminBounces');
	Route::get('admin/bounces/{bounceId}', 'AdminController@getAdminBouncesId');
	Route::get('admin/performance', 'AdminController@getAdminPerformance');
	Route::get('admin/procedures', 'AdminController@getAdminProcedures');
	Route::get('admin/streams', 'AdminController@getAdminStreams');
	Route::get('admin/streams/refresh/{streamId}', 'AdminController@getAdminStreamsRefreshId');
	Route::get('admin/users', 'AdminController@getAdminUsers');
	Route::post('admin/users', 'AdminController@postAdminUsers');
	Route::get('admin/users/{userId}', 'AdminController@getAdminUsersId');
	Route::put('admin/users/{userId}', 'AdminController@putAdminUsersId');
	Route::delete('admin/users/{userId}', 'AdminController@deleteAdminUsersId');
	/////////////////////////////////////   CAMPAIGNS   ///////////////////////////////////////
	Route::get('accounts/{accountId}/campaigns', 'CampaignsController@getAccountsIdCampaigns');
	Route::put('accounts/{accountId}/campaigns', 'CampaignsController@putAccountsIdCampaigns');
	Route::post('accounts/{accountId}/campaigns', 'CampaignsController@postAccountsIdCampaigns');
	Route::delete('accounts/{accountId}/campaigns/{campaignId}', 'CampaignsController@deleteAccountsIdCampaignsId');
	Route::get('accounts/{accountId}/campaigns/{campaignId}', 'CampaignsController@getAccountsIdCampaignsId');
	Route::put('accounts/{accountId}/campaigns/{campaignId}', 'CampaignsController@putAccountsIdCampaignsId');
	/////////////////////////////////////   CHANNELS   ///////////////////////////////////////
	Route::get('channels', 'ChannelsController@getChannels');
	Route::get('channels/{channelId}', 'ChannelsController@getChannelsId');
	Route::delete('channels/{channelId}', 'ChannelsController@deleteChannelsId');
	Route::put('channels/{channelId}', 'ChannelsController@putChannelsId');
	Route::post('channels/{channelId}/channels', 'ChannelsController@postChannelsIdChannels');
	Route::get('channels/{channelId}/count', 'ChannelsController@getChannelsIdCount');
	Route::get('channels/{channelId}/messageids', 'ChannelsController@getChannelsIdMessageids');
	Route::get('channels/{channelId}/messages', 'ChannelsController@getChannelsIdMessages');
	Route::get('channels/{channelId}/notificationsids', 'ChannelsController@getChannelsIdNotificationids');
	Route::post('channels/{channelId}/read', 'ChannelsController@postChannelsIdRead');
	Route::get('channels/{channelId}/streamids', 'ChannelsController@getChannelsIdStreamids');
	Route::get('channels/{channelId}/streams', 'ChannelsController@getChannelsIdStreams');
	/////////////////////////////////////   CONTACTS   ///////////////////////////////////////
	Route::get('accounts/{accountId}/contactids', 'AccountsController@getAccountsIdContactids');
	Route::get('accounts/{accountId}/contactids/following', 'AccountsController@getAccountsIdContactidsFollowing');
	Route::post('accounts/{accountId}/contacts', 'AccountsController@postAccountsIdContacts');
	Route::get('accounts/{accountId}/contacts', 'AccountsController@getAccountsIdContacts');
	Route::get('accounts/{accountId}/contacts/following', 'AccountsController@getAccountsIdContactsFollowing');
	Route::get('accounts/{accountId}/contacts/search/{network}', 'AccountsController@getAccountsIdContactsSearchNetwork');
	Route::get('accounts/{accountId}/contacts/{contactId}', 'AccountsController@getAccountsIdContactsId');
	Route::put('accounts/{accountId}/contacts/{contactId}', 'AccountsController@putAccountsIdContactsId');
	Route::get('accounts/{accountId}/contacts/{contactId}/conversationids', 'AccountsController@getAccountsIdContactsIdConversationids');
	Route::get('accounts/{accountId}/contacts/{contactId}/conversations', 'AccountsController@getAccountsIdContactsIdConversations');
	Route::get('accounts/{accountId}/contacts/{contactId}/messages', 'AccountsController@getAccountsIdContactsIdMessages');
	Route::get('accounts/{accountId}/contacts/{contactId}/noteids', 'AccountsController@getAccountsIdContactsIdNoteids');
	Route::post('accounts/{accountId}/contacts/{contactId}/notes', 'AccountsController@postAccountsIdContactsIdNotes');
	Route::get('accounts/{accountId}/contacts/{contactId}/notes', 'AccountsController@getAccountsIdContactsIdNotes');
	Route::get('accounts/{accountId}/contacts/{contactId}/tagids', 'AccountsController@getAccountsIdContactsIdTagids');
	Route::get('accounts/{accountId}/contacts/{contactId}/tags', 'AccountsController@getAccountsIdContactsIdTags');
	Route::post('accounts/{accountId}/contacts/{contactId}/tags', 'AccountsController@postAccountsIdContactsIdTags');
	Route::delete('accounts/{accountId}/contacts/{contactId}/tags/{tagId}', 'AccountsController@deleteAccountsIdContactsIdTagsId');
	/////////////////////////////////////   GROUP   ///////////////////////////////////////
	Route::post('accounts/{groupId}/groups', 'AccountsController@postAccountsIdGroups');
	Route::get('groups', 'GroupsController@getGroups');
	Route::put('groups/{groupId}', 'GroupsController@putGroupsId');
	//////////////////////////////////////   LOG   ////////////////////////////////////////
	Route::post('log', 'LogController@postLog');
	////////////////////////////////////   MAILER   ////////////////////////////////////////
	Route::get('mailer/bounces', 'MailerController@getMailerBounces');
	Route::get('mailer/bounces/{bounceId}', 'MailerController@getMailerBouncesId');
	Route::get('mailer/emails', 'MailerController@getMailerEmails');
	Route::get('mailer/emails/{emailId}', 'MailerController@getMailerEmailsId');
	////////////////////////////////////   MESSAGES   ////////////////////////////////////////
	Route::post('messages', 'MessageController@postMessages');
	Route::get('messages', 'MessageController@getMessages');
	Route::delete('messages/{messageId}', 'MessageController@deleteMessagesId');
	Route::put('messages/{messageId}', 'MessageController@putMessagesId');
	Route::get('messages/{messageId}', 'MessageController@getMessagesId');
	Route::get('messages/{messageId}/actions', 'MessageController@getMessagesIdActions');
	Route::post('messages/{messageId}/actions/{actionToken}', 'MessageController@postMessagesIdActionsToken');
	Route::get('messages/{messageId}/noteids', 'MessageController@getMessagesIdNoteids');
	Route::post('messages/{messageId}/notes', 'MessageController@postMessagesIdNotes');
	Route::get('messages/{messageId}/notes', 'MessageController@getMessagesIdNotes');
	Route::get('messages/{messageId}/original', 'MessageController@getMessagesIdOriginal');
	Route::put('messages/{messageId}/original', 'MessageController@putMessagesIdOriginal');
	Route::put('messages/{messageId}/read', 'MessageController@putMessagesIdRead');
	Route::get('messages/{messageId}/sendlog', 'MessageController@getMessagesIdSendlog');
	Route::put('messages/{messageId}/skip', 'MessageController@putMessagesIdSkip');
	Route::get('messages/{messageId}/statistics', 'MessageController@getMessagesIdStatistics');
	Route::get('messages/{messageId}/statistics/{statisticToken}', 'MessageController@getMessagesIdStatisticsToken');
	Route::put('messages/{messageId}/statistics/{statisticToken}', 'MessageController@putMessagesIdStatisticsToken');
	Route::get('messages/{messageId}/tagids', 'MessageController@getMessagesIdTagids');
	Route::get('messages/{messageId}/tags', 'MessageController@getMessagesIdTags');
	Route::post('messages/{messageId}/tags', 'MessageController@postMessagesIdTags');
	Route::delete('messages/{messageId}/tags/{tagId}', 'MessageController@deleteMessagesIdTagsId');
	//////////////////////////////////////   NOTES   ////////////////////////////////////////
	Route::get('notes', 'NotesController@getNotes');
	Route::get('notes/{noteId}', 'NotesController@getNotesId');
	Route::delete('notes/{noteId}', 'NotesController@deleteNotesId');
	Route::put('notes/{noteId}', 'NotesController@putNotesId');
	Route::get('notes/{noteId}/related', 'NotesController@getNotesIdRelated');
	Route::get('notes/{noteId}/relatedids', 'NotesController@getNotesIdRelatedids');
	//////////////////////////////////////   NOTIFICATIONS   ////////////////////////////////////////
	Route::get('notifications', 'NotificationsController@getNotifications');
	//////////////////////////////////////   REPORTS   ////////////////////////////////////////
	Route::get('reports', 'ReportsController@getReports');
	Route::get('reports/{id}', 'ReportsController@getReportsId');
	//////////////////////////////////////   RESELLER   ////////////////////////////////////////
	Route::get('reseller/{resellerId}', 'ResellerController@getResellerId');
	Route::get('reseller/{resellerId}/accounts', 'ResellerController@getResellerIdAccounts');
	Route::post('reseller/{resellerId}/accounts', 'ResellerController@postResellerIdAccounts');
	Route::put('reseller/{resellerId}/accounts/{accountId}', 'ResellerController@putResellerIdAccountsId');
	Route::get('reseller/{resellerId}/plans', 'ResellerController@getResellerIdPlans');
	Route::post('reseller/{resellerId}/plans', 'ResellerController@postResellerIdPlans');
	Route::put('reseller/{resellerId}/plans/{planId}', 'ResellerController@putResellerIdPlansId');
	//////////////////////////////////////   SERVICES   ////////////////////////////////////////
	Route::get('services/{id}', 'ServicesController@getServicesId');
	Route::delete('services/{id}', 'ServicesController@deleteServicesId');
	Route::put('services/{id}', 'ServicesController@putServicesId');
	Route::get('services/{id}/profiles', 'ServicesController@getServicesIdProfiles');
	Route::get('services/{id}/profiles/{profileId}', 'ServicesController@getServicesIdProfilesId');
	Route::put('services/{id}/profiles/{profileId}', 'ServicesController@putServicesIdProfilesId');
	Route::post('services/{id}/setup', 'ServicesController@getServicesIdSetup');
	//////////////////////////////////////   STREAMS   ////////////////////////////////////////
	Route::get('streams', 'StreamsController@getStreams');
	Route::get('streams/{streamId}', 'StreamsController@getStreamsId');
	Route::get('streams/{streamId}/actions', 'StreamsController@getStreamsIdActions');
	Route::get('streams/{streamId}/besttimetopost', 'StreamsController@getStreamsIdBesttimetopost');
	Route::get('streams/{streamId}/contacts/uniqueid/{uniqueid}', 'StreamsController@getStreamsIdContactsUniqueidId');
	Route::get('streams/{streamId}/count', 'StreamsController@getStreamsIdCount');
	Route::get('streams/{streamId}/followers', 'StreamsController@getStreamsIdFollowers');
	Route::get('streams/{streamId}/following', 'StreamsController@getStreamsIdFollowing');
	Route::get('streams/{streamId}/live/messages', 'StreamsController@getStreamsIdLiveMessages');
	Route::get('streams/{streamId}/live/statistics', 'StreamsController@getStreamsIdLiveStatistics');
	Route::get('streams/{streamId}/live/messageids', 'StreamsController@getStreamsIdLiveMessageids');
	Route::post('streams/{streamId}/messages', 'StreamsController@postStreamsIdMessages');
	Route::get('streams/{streamId}/messages', 'StreamsController@getStreamsIdMessages');
	Route::post('streams/{streamId}/read', 'StreamsController@postStreamsIdRead');
	Route::get('streams/{streamId}/reportids', 'StreamsController@getStreamsIdReportids');
	Route::get('streams/{streamId}/reports', 'StreamsController@getStreamsIdReports');
	Route::get('streams/{streamId}/validate', 'StreamsController@getStreamsIdValidate');
	/////////////////////////////////////   TAGS   ////////////////////////////////////////
	Route::get('tags', 'TagsController@getTags');
	Route::get('tags/{tagId}', 'TagsController@getTagsId');
	Route::post('tags/{tagId}/tags', 'TagsController@postTagsIdTags');
	Route::delete('tags/{tagId}/tags/{tagId2}', 'TagsController@deleteTagsIdTagsId2');
	///////////////////////////////////   TRIGGERS   /////////////////////////////////////
	Route::put('triggers/{triggerId}', 'TriggersController@putTriggersId');
	Route::get('triggers/{triggerId}', 'TriggersController@getTriggersId');
	//////////////////////////////////   URLSHORTENER   //////////////////////////////////
	Route::post('urlshortener/shorten', 'UrlshortenerController@postUrlshortener');
	//////////////////////////////////////   USERS   /////////////////////////////////////
	Route::get('users/{userId}', 'UsersController@getUsersId');
	Route::put('users/{userId}', 'UsersController@putUsersId');
	Route::put('users/{userId}/password', 'UsersController@putUsersIdPassword');
	Route::get('users/{userId}/subscriptions', 'UsersController@getUsersIdSubscriptions');
	Route::delete('users/{userId}/subscriptions', 'UsersController@deleteUsersIdSubscriptions');
	Route::post('users/{userId}/subscriptions', 'UsersController@postUsersIdSubscriptions');
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

Route::get ('1/version', 'ProxyController@guest');

Route::any('oauth2/{path?}', 'Oauth2Controller@dispatch')->where ('path', '.+');;

// The All Catching One
Route::match (array ('GET', 'POST', 'PATCH', 'PUT', 'DELETE'), '{path?}', 'ProxyController@authenticated')->where ('path', '.+')->before (array ('before' => 'oauth2'));