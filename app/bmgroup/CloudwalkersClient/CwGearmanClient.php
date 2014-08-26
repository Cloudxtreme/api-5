<?php
/**
 * Created by PhpStorm.
 * User: daedeloth
 * Date: 26/08/14
 * Time: 16:10
 */

namespace bmgroup\CloudwalkersClient;


use GearmanClient;
use Illuminate\Support\Facades\Config;

class CwGearmanClient {

	private static $instance;
	private $client;
	
	public static function getInstance ()
	{
		if (!isset (self::$instance))
		{
			self::$instance = new self ();
		}
		return self::$instance;
	}
	
	private function __construct ()
	{
		$this->client = new GearmanClient ();
		foreach (Config::get ('gearman.servers') as $server => $port)
		{
			$this->client->addServer ($server, $port);
		}
	}

	public function doHigh ($method, $data)
	{
		$data = $this->client->doHigh ($method, json_encode ($data));
		return json_decode ($data, true);
	}
	
	public function login ($username, $password)
	{
		$encryption = new \Neuron\Encryption\SimpleCrypt (APP_SECRET_KEY);
		
		$data = array ();
		$data['method'] = 'getFromLogin';
		$data['username'] = $username;
		$data['password'] = $encryption->encrypt ($password);
		
		return $this->doHigh ('authentication', $data);
	}

	public function register ($email, $password, $firstname, $name)
	{
		$encryption = new \Neuron\Encryption\SimpleCrypt (APP_SECRET_KEY);

		$data = array ();
		$data['method'] = 'register';
		$data['email'] = $email;
		$data['password'] = $encryption->encrypt ($password);
		$data['name'] = $name;
		$data['firstname'] = $firstname;

		return $this->doHigh ('authentication', $data);
	}
	
} 