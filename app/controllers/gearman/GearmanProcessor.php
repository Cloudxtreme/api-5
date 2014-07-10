<?php

// ----------------------------------------------------------------------------
// Workers daemon
// ----------------------------------------------------------------------------
// This file allows to send a task/job to a GearmanWorker to process and return
// information to the GearmanServer
// ----------------------------------------------------------------------------

namespace Gearman;

// Gearman
use \GearmanWorker as GearmanWorker;
use \GearmanJob as GearmanJob;

// PHP
use \PDO as PDO;

// Guzzle
use GuzzleHttp\json_decode;

// Composer autoload
//require '../../../vendor/autoload.php';
require __DIR__.'/../../../bootstrap/autoload.php';

$app = require_once __DIR__.'/../../../bootstrap/start.php';
//$app->run();

// Laravel
use \Illuminate\Support\Facades\DB as DB;
use \Response as Response;
use \Config as Config;
use \App as App;


function is_json($str) {
	//json_decode($string);
	//return (json_last_error() == JSON_ERROR_NONE);

	return is_array(json_decode($str,true));
}


// Create our worker object
$worker = new GearmanWorker();

// Add a server (again, same defaults apply as a worker)

//$worker->addServer('192.168.56.102', '4730'); // by default host/port will be "localhost" & 4730


$servers = Config::get('gearman.servers');

foreach ($servers as $server => $port) {
	//if (App::environment('local'))
	//{
		echo "Connecting to $server : $port<br />\n";
	//}
	
	//$worker->addServer($server, (int) $port);
	
	//$worker->addServer("$server", (int) $port);
	
	$worker->addServer('192.168.56.102', '4730'); break; // TEST!
	
	//$worker->addServer('192.168.56.102', '4731'); break;
}


// Existing functions
$functions_to_declare = array(
	 "reverse" => "Gearman\\reverse_fn"
	,"get_user_details" => "Gearman\\getUserDetails"
	,"get_oauth2_authorize" => "Gearman\\getOauth2Authorize"
	,"get_oauth2_access_token" => "Gearman\\getOauth2AccessToken"
);

// Inform the server that this worker can process the following function calls
foreach ($functions_to_declare as $func_ix => $func) {
	
	if (App::environment('local'))
	{
		echo "Declaring: {$func_ix} -> {$func}\n";
	}
	
	$worker->addFunction($func_ix, $func);
}

// ----------------------------------------------------------------------------
// TODO: Add dynamic terminate and restart when we have implemented a new
//       functionality or updated an existing one. 
// ----------------------------------------------------------------------------

while (1) {
	//try {
		print "Waiting for job...\n";
		$ret = $worker->work(); // work() will block execution until a job is delivered
		if ($worker->returnCode() != GEARMAN_SUCCESS) {
			break;
		}
	//} catch(Exception $e) {
		//break;
	//}
}

function before_process($job, $workload) {
	echo "Received job: " . $job->handle() . "\n";
	echo "Workload: $workload\n";
} 

// A simple reverse function
function reverse_fn(GearmanJob $job) {
	$workload = $job->workload();
	
	before_process($job, $workload);
	
	$result = "#".strrev($workload) ."#";
	
	echo "Result: $result\n";
	return $result;
}


// GET => /user/{id}/
// Get user details
function getUserDetails(GearmanJob $job) {
	$error = false;
	
	$workload = $job->workload();
	
	before_process($job, $workload);
	
	if (is_json($workload)) {
		$workload = json_decode($workload, true);
		
	} else {
		// We dont have valid data to process, return error
		$workload = false;
		
		$error = array('error'=>'JSON: Invalid data was sent');
	}

	// We have a job to process
	if ($workload) {
		// Get request details 
		$email    = isset($workload['email'])    ? substr(strtolower(trim($workload['email'])),0,250) : ''; 
		$password = isset($workload['password']) ? substr(trim($workload['password']),0,250) : '';
		
		// Request validation 
		if ("$email" == ''    && !$error) $error = array('error'=>'Email is empty');
		if ("$password" == '' && !$error) $error = array('error'=>'Password is empty');
		
		
		// Search for the user
		if (!$error) {
			
			$sql = "SELECT u.* 
					FROM users u 
					WHERE 
						    u.u_email = :email 
						AND u.u_password = MD5(CONCAT(:password , u.u_salt))
					LIMIT 1;";
			
			$params = array(
				'email' => $email,
				'password' => $password
			);

			//die('Connecting DB...');
			
			// Database connection
			$db = DB::connection('mysqlcw');
			
			// Set fetch as array
			//Config::set('database.fetch', PDO::FETCH_ASSOC);

			$db->setFetchMode( PDO::FETCH_ASSOC );
			
			$rows = $db->select( $db->raw($sql), $params );
			
			echo var_export($rows);
			
			//$db->getPdo()->setFetchMode(PDO::FETCH_ASSOC);
			
			
			// Revert fetch mode to default
			$db->setFetchMode( Config::get( 'database.fetch' ));
			
			
			
			// If the record is found
			if ($rows && count($rows) >  0 && isset($rows[0]) && isset($rows[0]['u_email'])) {

				//Return the record
				$result = $rows[0];
				
			} else {
				$error = array('error'=>'Record not found.');
			}
			 
		}
		
	}
	
	
	
	// Check if we have an error to send 
	if ($error !== false) { 
		$result = $error;
	}
	
	return json_encode($result);

	//return Response::json($result); // Also return JSON content-type headers
}





function getOauth2Authorize(GearmanJob $job) {
	$error = false;
	
	$workload = $job->workload();
	
	before_process($job, $workload);
	
	/*
	if (is_json($workload)) {
		$workload = json_decode($workload, true);
		
	} else {
		// We dont have valid data to process, return error
		$workload = false;
		
		$error = array('error'=>'JSON: Invalid data was sent');
	}*/
	
	
	$api_settings = Config::get('api.settings');

	$api_url = $api_settings['base_url']; // http://cloudwalkers-api.local/
	
	
	// We have a job to process
	if ($workload) {
		$res = null;
		$has_error = false;
		
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
			
			$error = array('error'=> $e->getMessage() );
		}
		
		//if ($res === null || $this->is_json($res->getBody()) === false) {
		if ($res === null || is_json($res->getBody()) === false) {
			$has_error = true;
				
			//throw new Exception("Unable to obtain a valid AUTHORIZATION CODE");
			
			$error = array('error'=> "Unable to obtain a valid AUTHORIZATION CODE" );
				
		}
		
		if ($error === false) {
			try
			{
				$response_code = $res->json();
				
				//Return the AUTHORIZATION CODE
				$result = $response_code;
				
			} catch (Exception $e) {
				//echo "REQ ERROR: ". $e->getMessage();
				
				$error = array('error'=> $e->getMessage() );
				
			}
		}
		
		// Check if we have an error to send
		if ($error !== false) {
			$result = $error;
		}
		
		return json_encode($result);
		
	} // END :: $workload
	
} // END :: getOauth2Authorize()


function getOauth2AccessToken(GearmanJob $job) {
	$error = false;

	$workload = $job->workload();

	before_process($job, $workload);

	/*
	 if (is_json($workload)) {
	$workload = json_decode($workload, true);

	} else {
	// We dont have valid data to process, return error
	$workload = false;

	$error = array('error'=>'JSON: Invalid data was sent');
	}*/

	$api_settings = Config::get('api.settings');
	
	$api_url = $api_settings['base_url']; // http://cloudwalkers-api.local/
	
	// We have a job to process
	if ($workload) {
		$res = null;
		$has_error = false;

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
				
			$error = array('error'=> $e->getMessage() );
		}

		//if ($res === null || $this->is_json($res->getBody()) === false) {
		if ($res === null || is_json($res->getBody()) === false) {
			$has_error = true;

			//throw new Exception("Unable to obtain a valid AUTHORIZATION CODE");
				
			$error = array('error'=> "Unable to obtain a valid AUTHORIZATION CODE" );

		}

		if ($error === false) {
			try
			{
				$response_code = $res->json();

				//Return the AUTHORIZATION CODE
				//$result = $response_code;

			} catch (Exception $e) {
				//echo "REQ ERROR: ". $e->getMessage();

				$error = array('error'=> $e->getMessage() );

			}
		}
		
		
		
		
		$code = isset($response_code['code']) ? $response_code['code'] : null;
		
		
		$res = $client->post($api_url . 'oauth2/access_token', [
			'body' => [
			'grant_type' => 'authorization_code',
			'code' => $code,
			'client_id' => '1',
			'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
			//'state' => 0,
			//'scope' => 'user',
			'redirect_uri' => $api_url . 'demo/backhome'
			//'redirect_uri' => urlencode('http://cloudwalkers-api.local/demo/backhome')
		]
		]);
		
		$response_token = $res->json();
		
		$token = isset($response_token['access_token']) ? $response_token['access_token'] : null;
		
		
		//Return the ACCESS TOKEN
		$result = $token;
		
		
		/*
		$res = $client->get('http://cloudwalkers-api.local/api/v2/accounts', [
			'headers' => [
			'Authorization' => 'Bearer '. $token
			]
			]);
		
		$response_api = $res->getBody();
		*/
		//$token = isset($response_api['access_token']) ? $response_api['access_token'] : null;
		
		//echo "API CALL: $response_api<br />\n";
		
		
		//echo "TOKEN CODE: $code<br />\n";
		//echo "ACCESS TOKEN: $token<br />\n";
		//echo "API CALL: <br />\n";
		
		//echo var_export($response_api);
		
		

		// Check if we have an error to send
		if ($error !== false) {
			$result = $error;
		}

		return json_encode($result);

	} // END :: $workload

} // END :: getOauth2AccessToken()

