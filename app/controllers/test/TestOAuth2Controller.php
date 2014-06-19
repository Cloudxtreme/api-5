<?php

// UTF8 :: àáâãä

namespace Test;

use Exception;
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
					'client_id' => '1',
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
		
		
		'client_id' => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
		*/
		$res = $client->post('http://cloudwalkers-api.local/oauth2/authorize', [
			'body' => [
			'grant_type' => 'client_credentials',
			'client_id' => '1',
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
	
		
		/*if (empty($res)) {
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
		*/
	
		//echo $res->getBody();
		
		//echo json_encode(var_export($res));
		
		echo json_encode($res->json());
			
		/*
		 echo $res->getStatusCode();           // 200
		echo $res->getHeader('content-type'); // 'application/json; charset=utf8'
		echo $res->getBody();                 // {"type":"User"...'
		var_export($res->json());             // Outputs the JSON decoded data
		*/
	
	
	}
	


	public function is_json($str) {
		//json_decode($string);
		//return (json_last_error() == JSON_ERROR_NONE);
		
		return is_array(json_decode($str,true));
	}
	
	public function test_client_flow() {
		
		$res = null;
		$has_error = false;
		
		$client = new \GuzzleHttp\Client();
		
		try 
		{
			$url = 'http://cloudwalkers-api.local/oauth2/authorize'.
				'?grant_type=authorization_code'.
				'&client_id=1'.
				'&client_secret=dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ'.
				'&state=0'.
				'&scope=user'.
				'&response_type=code'.
				'&redirect_uri='. urlencode('http://cloudwalkers-api.local/demo/backhome')
				;
		
			$res = $client->get($url);
			
		} catch (Exception $e) {
			$has_error = true;
			//echo "FLOW ERROR: ". $e->getMessage();
		}
		
		if ($res === null || $this->is_json($res->getBody()) === false) {
			$has_error = true;
			
			throw new Exception("Unable to obtain a valid AUTHORIZATION CODE");
			
			return;
		}
		
		try 
		{
			$response_code = $res->json();
		} catch (Exception $e) {
			//echo "REQ ERROR: ". $e->getMessage();
		}
		
		//echo json_encode($res->json());
		
		$code = isset($response_code['code']) ? $response_code['code'] : null;
		
		
		$res = $client->post('http://cloudwalkers-api.local/oauth2/access_token', [
			'body' => [
				'grant_type' => 'authorization_code',
				'code' => $code,
				'client_id' => '1',
				'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
				//'state' => 0,
				//'scope' => 'user',
				'redirect_uri' => 'http://cloudwalkers-api.local/demo/backhome'
				//'redirect_uri' => urlencode('http://cloudwalkers-api.local/demo/backhome')
			]
		]);
		
		$response_token = $res->json();
		
		$token = isset($response_token['access_token']) ? $response_token['access_token'] : null;
		
		
		
		$res = $client->get('http://cloudwalkers-api.local/api/v2/accounts', [
			'headers' => [
				'Authorization' => 'Bearer '. $token
			]
		]);
		
		$response_api = $res->getBody();
		
		//$token = isset($response_api['access_token']) ? $response_api['access_token'] : null;
		
		//echo "API CALL: $response_api<br />\n";
		
		echo "TOKEN CODE: $code<br />\n";
		echo "ACCESS TOKEN: $token<br />\n";
		echo "API CALL: <br />\n";
		
		echo var_export($response_api);
		
		
		//echo $res->getBody();                 // {"type":"User"...'
		
		//echo var_export($res);
		
		//echo var_export($code);
		
				
		//echo $res;
				
		//echo json_encode($res->json());
		
		//var_export($res);
		
		die('<br>DONE...');
		
		return;
		
		$res = $client->post('http://cloudwalkers-api.local/oauth2/authorize', [
				'body' => [
				'grant_type' => 'authorization_code',
				'client_id' => '1',
				'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
				'state' => 0,
				'scope' => 'user'
				]
				]);
		
		
		$provider = new \League\OAuth2\Client\Provider\Cloudwalkers (array(
			'clientId'     => '1',
			'clientSecret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
			'redirectUri'  => 'http://cloudwalkers-api.local/demo/backhome'
		));
		
		if ( ! isset($_GET['code'])) {
		
			//die("We dont have a CODE, going to -> ". $provider->getAuthorizationUrl());
			
			// If we don't have an authorization code then get one
			header('Location: '. $provider->getAuthorizationUrl());
			
			exit;
		
		} else {
		
			// Try to get an access token (using the authorization code grant)
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
				]);
		
			// If you are using Eventbrite you will need to add the grant_type parameter (see below)
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code'],
				'grant_type' => 'authorization_code'
				]);
		
			// Optional: Now you have a token you can look up a users profile data
			try {
		
				// We got an access token, let's now get the user's details
				$userDetails = $provider->getUserDetails($token);
		
				// Use these details to create a new profile
				printf('Hello %s!', $userDetails->firstName);
		
			} catch (Exception $e) {
		
				// Failed to get user details
				//exit('Oh dear...');
			}
		
			/*
			// Use this to interact with an API on the users behalf
			echo $token->accessToken;
		
			// Use this to get a new access token if the old one expires
			echo $token->refreshToken;
		
			// Number of seconds until the access token will expire, and need refreshing
			echo $token->expires;
			*/
		}
	}	
	
	public function test_refresh () {
		$provider = new League\OAuth2\Client\Provider\Cloudwalkers (array(
			'clientId'     => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
			'clientSecret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
			'redirectUri'  => 'http://cloudwalkers-api.local/demo/backhome'
		));
		
		$grant = new \League\OAuth2\Client\Grant\RefreshToken();
		$token = $provider->getAccessToken($grant, ['refresh_token' => $refreshToken]);
	}
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		var_dump($parameters);
	}
	
}
