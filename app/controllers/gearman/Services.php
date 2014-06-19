<?php

namespace Gearman;

use Predis\Cluster\Distribution\EmptyRingException;
class Services
{

	public function is_json($str) {
		//json_decode($string);
		//return (json_last_error() == JSON_ERROR_NONE);
	
		return is_array(json_decode($str,true));
	}
	
	public function fire($job, $data)
	{
		echo "WORKER: ". var_export($data) ."\n";
		
		throw new Exception("WORKER IS WORKING!!!");
		
		return;
		
		//I send an email to my email address with subject "gearman test" and message whatever comes from gearman
		//mail('robertos@agap2.pt', 'gearman test', $data['message']);
		
		//echo "OK...: ". $data['message'] ."<br />\n";
		
		//Delay 2 second to test
		//Sleep(2);
		
		
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
		
		echo "REQUEST: ". $data['message'] ."<br />\n";
		echo "TOKEN CODE: $code<br />\n";
		echo "ACCESS TOKEN: $token<br />\n";
		echo "<br />\n";
		//echo "API CALL: <br />\n";
		
		//echo var_export($response_api);


		//echo $res->getBody();                 // {"type":"User"...'

		//echo var_export($res);

		//echo var_export($code);


		//echo $res;

		//echo json_encode($res->json());

		//var_export($res);

		//die('<br>DONE...');

		//return;
		
	}

}

