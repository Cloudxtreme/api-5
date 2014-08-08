<?php

// UTF8 :: àáâãä

namespace Test;

// PHP
use \Exception as Exception;

// Laravel
use \Input as Input;
use \Config as Config;
use \App as App;

// Guzzle
use \GuzzleHttp\Exception\RequestException as RequestException;
use \GuzzleHttp\Exception\ClientException as ClientException;

// Gearman
use \GearmanClient as GearmanClient;
//use \Gearman\Status as GearmanServerStatus;
//use \Status\GearmanServerStatus as GearmanServerStatus;
use \Gearman\GearmanServerStatus as GearmanServerStatus;

class TestOAuth2Controller 
	extends \BaseController 
{

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
		
		
		$api_settings = Config::get('api.settings');
		
		$api_url = $api_settings['base_url']; // http://cloudwalkers-api.local/
		
		//try {
		
			$res = $client->post($api_url . 'oauth2/access_token', [
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
		
		
		$api_settings = Config::get('api.settings');
		
		$api_url = $api_settings['base_url']; // http://cloudwalkers-api.local/
		
	
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
		$res = $client->post($api_url . 'oauth2/access_token', [
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
	
		
		$api_settings = Config::get('api.settings');
		
		$api_url = $api_settings['base_url']; // http://cloudwalkers-api.local/
		
		
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
		$res = $client->post($api_url . 'oauth2/authorize', [
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
		
		
		$api_settings = Config::get('api.settings');
		
		$api_url = $api_settings['base_url']; // http://cloudwalkers-api.local/
		
		
		$client = new \GuzzleHttp\Client();
		
		try 
		{
			$url = $api_url . 'oauth2/authorize'.
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
		
		
		$res = $client->post($api_url . 'oauth2/access_token', [
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
		
		
		
		$res = $client->get($api_url . 'api/v2/accounts', [
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
	
	
	public function test_worker () {
	
		//foreach (array(1,2,3) as $row) {
		foreach (array(1) as $row) {
			
			echo "Adding $row<br />\n";
		
			
			//Queue::push('gearman\\Services', array('action'=>'get_token', 'message' => 'Token №' . $row));
			
			// Create our client object
			$client = new GearmanClient();
			
			// Add a server
			//$client->addServer('192.168.56.102', '4730'); // by default host/port will be "localhost" & 4730

			$servers = Config::get('gearman.servers');
			
			foreach ($servers as $server => $port) {
				$client->addServer($server, (int) $port);
			}
			
			echo "Sending job\n";
			
			// Send reverse job
			$result = $client->doHigh("reverse", "Hello!");
			
			//$result = $client->doNormal("reverse", "Hello!");
			
			//$result = $client->doBackground("reverse", "Hello!");
			
			if ($result) {
				echo "Success: $result\n";
			}
				
			
		}
		
	}
		
	// GET => /test/get_user_details
	public function get_user_details ($params = array()) {
		
		// Override function $params
		$params = array();

		//$params['email'] = isset($_POST['email'])     ? strtolower(trim($_POST['email'])) : '';
		//$params['email'] = isset($_POST['$password']) ? $_POST['$password']               : '';
		
		// Send { "email", "password" } from POST or GET
		$params = Input::only('email', 'password');
		
		echo "Checking if user exists by email \"{$params['email']}\", password and get its details.<br />\n";
		
		//Queue::push('gearman\\Services', array('action'=>'get_token', 'message' => 'Token №' . $row));
			
		// Create our client object
		$client = new GearmanClient();
			
		// Add a server
		//$client->addServer('192.168.56.102', '4730'); // by default host/port will be "localhost" & 4730
		
		
		$servers = Config::get('gearman.servers');
		
		foreach ($servers as $server => $port) {
			//if (App::environment('local'))
			//{
				echo "Connecting to server: $server, $port<br />\n";
			//}
			
			$client->addServer("$server", "$port");
		}
		
		
		echo "Sending job:<br />\n";

		$result = false;
		
		// Send job
		$result = $client->doHigh("get_user_details", json_encode($params));

		if ($result) {
			echo "Success: $result<br />\n";
		}

	}
	
	public function get_oauth2_access_token ($params = array()) {
	
		// Override function $params
		$params = array();
	
		//$params['email'] = isset($_POST['email'])     ? strtolower(trim($_POST['email'])) : '';
		//$params['email'] = isset($_POST['$password']) ? $_POST['$password']               : '';
	
		// Send { "email", "password" } from POST or GET
		//$params = Input::only('email', 'password');
	
		echo "Get OAUTH2 ACCESS TOKEN:<br />\n";
	
		//Queue::push('gearman\\Services', array('action'=>'get_token', 'message' => 'Token №' . $row));
			
		// Create our client object
		$client = new GearmanClient();
			
		// Add a server
		//$client->addServer('192.168.56.102', '4730'); // by default host/port will be "localhost" & 4730
		
		$servers = Config::get('gearman.servers');
		
		foreach ($servers as $server => $port) {
			$client->addServer($server, (int) $port);
		}
		
		
		echo "Sending job:<br />\n";
	
		// Send reverse job
		$result = $client->doHigh("get_oauth2_access_token", json_encode($params));
	
		//$result = $client->doNormal("reverse", "Hello!");
			
		//$result = $client->doBackground("reverse", "Hello!");
			
		if ($result) {
			echo "Success: $result<br />\n";
		}
	
	}
	
	// Test :: Show settings (configured in Laravel) and loaded in the respective environment (local, staging, production)
	
	public function show_settings() {
		
		// Dump all loaded configuration items
		// var_dump(Config::getItems())
		
		// If you want to see the configuration settings for a particular group, use Config::get('groupname').
		
		// Dump all the database settings
		// var_dump(Config::get('database'));
		
		echo "<pre>";
		
		//var_dump(Config::get('database'));
		
		//var_dump(Config::get('gearman'));
		
		//var_dump(Config::get('api'));
		echo "<h1>Database</h1>";
		
		$api_settings = Config::get('database.connections');
		
		var_dump($api_settings);
		
		
		echo "<h1>Database</h1>";
		
		$api_settings = Config::get('database.connections.oauth2');
		
		var_dump($api_settings);
		
		
		echo "<h1>API.Settings</h1>";
		
		$api_settings = Config::get('api.settings');
		
		var_dump($api_settings);
		
		
		echo "<h1>Gearman.Workers</h1>";
		
		$servers = Config::get('gearman.servers');
		
		var_dump($servers);
		
		
		echo "<h1>Gearman Server Status</h1>";
		
		$gss = new GearmanServerStatus();
		
		echo print_r($gss->getStatus(),true);
		
		
		//var_dump(Config::getItems());
		
		echo "</pre>";
		
	} 
	
	public function missingMethod($parameters = array())
	{
		// TODO: Log all requests of the missing endpoints
		
		var_dump($parameters);
	}
	
}


function complete($func, $handle, $result) {
	var_dump($func);
	var_dump($handle);
	var_dump($result);
}

function fail($task_object) {
	var_dump($task_object);
}
