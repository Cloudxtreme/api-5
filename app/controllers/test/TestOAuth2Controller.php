<?php

// UTF8 :: àáâãä

namespace Test;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class TestOAuth2Controller extends \BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	
	//public $restful = true;

	public function test_oauth2()
	{
		$res = null;
		
		$client = new \GuzzleHttp\Client();
		
		//try {
		
			$res = $client->post('http://cloudwalkers-api.local/oauth2/access_token', [
				'body' => [
					'grant_type' => 'client_credentials',
					'client_id' => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
					'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
					'state' => 0,
					'scope' => 'user'
				]
			]);
		
		/*} catch (RequestException $e) {
			//Catch the invalid login
			echo $e->getRequest();
		    if ($e->hasResponse()) {
		        echo $e->getResponse();
		    }
		*/
		/*
		} catch (ClientException $e) {
			//echo $e->getRequest();
			//echo $e->getResponse();
		*/
		//} catch (\Exception $e) {
		//}
		
		if (empty($res)) {
			echo json_encode(array('error'=>'Invalid request'));
			return;
		} else {
			if ($res->getStatusCode() == 200) {
				echo json_encode($res->json());
			} else {
				echo json_encode(array('error'=>'Unknown request'));
				return;
			}
		}
	

			
		/*
		echo $res->getStatusCode();           // 200
		echo $res->getHeader('content-type'); // 'application/json; charset=utf8'
		echo $res->getBody();                 // {"type":"User"...'
		var_export($res->json());             // Outputs the JSON decoded data
		*/
		
		
	}
	
	public function test_oauth2_token()
	{
		$res = null;
	
		$client = new \GuzzleHttp\Client();
	
		//try {
		/*
		 * POST https://www.example.com/oauth/access_token?
			grant_type=password&
			client_id=the_client_id&
			client_secret=the_client_secret&
			username=the_username&
			password=the_password&
			scope=scope1,scope2&
			state=123456789
		 */
		$res = $client->post('http://cloudwalkers-api.local/oauth2/access_token', [
				'body' => [
				'grant_type' => 'client_credentials',
				'client_id' => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
				'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
				'state' => 0,
				'scope' => 'user'
				]
				]);
	
		/*} catch (RequestException $e) {
		 //Catch the invalid login
		echo $e->getRequest();
		if ($e->hasResponse()) {
		echo $e->getResponse();
		}
		*/
		/*
			} catch (ClientException $e) {
		//echo $e->getRequest();
		//echo $e->getResponse();
		*/
		//} catch (\Exception $e) {
		//}
	
		if (empty($res)) {
			echo json_encode(array('error'=>'Invalid request'));
			return;
		} else {
			if ($res->getStatusCode() == 200) {
				echo json_encode($res->json());
			} else {
				echo json_encode(array('error'=>'Unknown request'));
				return;
			}
		}
	
	
			
		/*
			echo $res->getStatusCode();           // 200
		echo $res->getHeader('content-type'); // 'application/json; charset=utf8'
		echo $res->getBody();                 // {"type":"User"...'
		var_export($res->json());             // Outputs the JSON decoded data
		*/
	
	
	}
	
	//oauth2/authorize/?client_id=
	
	public function test_oauth2_authorize()
	{
		$res = null;
	
		$client = new \GuzzleHttp\Client();
	
		//try {
		/*
		 * POST https://www.example.com/oauth/access_token?
		grant_type=password&
		client_id=the_client_id&
		client_secret=the_client_secret&
		username=the_username&
		password=the_password&
		scope=scope1,scope2&
		state=123456789
		*/
		$res = $client->post('http://cloudwalkers-api.local/oauth2/authorize', [
			'body' => [
			'grant_type' => 'client_credentials',
			'client_id' => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
			'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
			'state' => 0,
			'scope' => 'user'
			]
		]);
	
		/*} catch (RequestException $e) {
		 //Catch the invalid login
		echo $e->getRequest();
		if ($e->hasResponse()) {
		echo $e->getResponse();
		}
		*/
		/*
		 } catch (ClientException $e) {
		//echo $e->getRequest();
		//echo $e->getResponse();
		*/
		//} catch (\Exception $e) {
		//}
	
		if (empty($res)) {
			echo json_encode(array('error'=>'Invalid request'));
			return;
		} else {
			if ($res->getStatusCode() == 200) {
				echo json_encode($res->json());
			} else {
				echo json_encode(array('error'=>'Unknown request'));
				return;
			}
		}
	
	
			
		/*
		 echo $res->getStatusCode();           // 200
		echo $res->getHeader('content-type'); // 'application/json; charset=utf8'
		echo $res->getBody();                 // {"type":"User"...'
		var_export($res->json());             // Outputs the JSON decoded data
		*/
	
	
	}
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		var_dump($parameters);
	}
	
}
