<?php

use bmgroup\CloudwalkersClient\CwGearmanClient;
use bmgroup\OAuth2\Verifier;
use Neuron\MapperFactory;


/**
 *	Get the version files
 */
include 'routes/routes-v1.php';
include 'routes/routes-v1.1.php';


/**
 *	Internal endpoints
 */
// Dispatch entry
Route::get ('schedule', 'ProxyController@schedule');


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



Route::get ('loginstatus', function ()
{
	\Neuron\Session::getInstance ()->connect ();
	$login = \Neuron\Session::getInstance ()->isLogin ();
	return Response::json (array ('login' => $login));
});

Route::any('login/{path?}', 'LoginController@login')->where ('path', '.+');
Route::any('logout/{path?}', 'LoginController@logout')->where ('path', '.+');
Route::any('404/{path?}', 'LoginController@error404')->where ('path', '.+');

Route::get ('authenticate/{path?}', 'NeuronProxyController@guest')->where ('path', '.+');
//Route::get ('invitation/{path?}', array('before'=>'auth','uses'=>'LoginController@register'))->where ('path', '.+');

Route::any('oauth2/{path?}', 'Oauth2Controller@dispatch')->where ('path', '.+')

Route::get('local/accounts/{accountId}/contacts/{contactId}', 'ContactController@get');


/////////////////// docs //////////////////////
// route to documentation and version control
Route::any('docs/{version?}', function($version=null) {
    if ($version) {
        return App::make('ApiDocsController')->index($version);
    }
});

//Route::get('/', function()
//{
////    return Redirect::to ('https://superadmin.cloudwalkers.be/docs/api/');
//    return App::make('ApiDocsController')->index('1.0');
//});

Route::get ('docs{path?}', function ($path = "")
{
    return Redirect::to ('https://superadmin.cloudwalkers.be/docs/api/' . str_replace (" ", "+", $path));
//    return App::make('ApiDocsController')->index('1.0');
})->where ('path', '.+');


// The All Catching One
Route::match (array ('GET', 'POST', 'PATCH', 'PUT', 'DELETE'), '{path?}', 'NeuronProxyController@authenticated')->where ('path', '.+')->before (array ('before' => 'oauth2'));

Route::any('{all}', function($uri)
{
    return 'yeah, right!';
})->where('all', '.*');
