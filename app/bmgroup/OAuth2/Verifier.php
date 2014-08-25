<?php

namespace bmgroup\OAuth2;

use OAuth2\Autoloader;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\JwtBearer;
use OAuth2\GrantType\RefreshToken;
use \bmgroup\OAuth2\Models\Request;
use OAuth2\Server;
use OAuth2\Storage\Pdo;

class Verifier
{
	public static function getInstance ()
	{
		static $in;
		if (!isset ($in))
		{
			$in = new self ();
		}
		return $in;
	}

	private $request;
	private $requestbody;

	/**
	 * @var \OAuth2\Server
	 */
	private $server;

	private $user;
	private $token;
	private $valid;

	private function __construct ()
	{
		Autoloader::register ();

		if (defined('DB_OAUTH2_ENGINE') && DB_OAUTH2_ENGINE == 'sqlite3') {
			$dsn = DB_OAUTH2_DSN;
			$username = DB_OAUTH2_USERNAME;
			$password = DB_OAUTH2_PASSWORD;
		} else {
			$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;
			$username = DB_USERNAME;
			$password = DB_PASSWORD;
		}
		
		$pdoconfig = array
		(
			'client_table' => 'oauth2_clients',
			'access_token_table' => 'oauth2_access_tokens',
			'refresh_token_table' => 'oauth2_refresh_tokens',
			'code_table' => 'oauth2_authorization_codes',
			'user_table' => 'oauth2_users',
			'jwt_table'  => 'oauth2_jwt',
			'scope_table'  => 'oauth2_scopes',
			'public_key_table'  => 'oauth2_public_keys',
		);

		$storage = new Pdo (array('dsn' => $dsn, 'username' => $username, 'password' => $password), $pdoconfig);
		//$storage = DB::connection()->getPdo();
		
		$this->server = new Server($storage, array (
			'allow_implicit' => true,
			'access_lifetime' => 60 * 60 * 24 * 365 * 2
		));

		$this->server->addGrantType (new AuthorizationCode($storage));

		$this->server->addGrantType (new RefreshToken ($storage, array (
			'always_issue_new_refresh_token' => true,
			'refresh_token_lifetime' => 60 * 60 * 24 * 31 * 2
		)));

		//$this->server->addGranttype (new JwtBearer($storage, ))


		//$this->server->addGrantType(new ClientCredentials($storage));
	}

	/**
	 * @return Server
	 */
	public function getServer ()
	{
		return $this->server;
	}

	public function getRequest ()
	{
		if (!isset ($this->request))
		{
			$this->request = Request::createFromGlobals();
		}

		return $this->request;
	}

	public static function isValid ()
	{
		$instance = self::getInstance ();

		if (!isset ($instance->valid))
		{
			$request = $instance->getRequest ();

			$instance->requestbody = $request->getContent ();

			$instance->valid = $instance->getServer ()->verifyResourceRequest($request);

			if ($instance->valid)
			{
				$token = $instance->server->getAccessTokenData($request);
				$instance->token = $token['access_token'];
				$instance->user = $token['user_id'];
			}
		}

		return $instance->valid;
	}

	public static function getUserID ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return $instance->user;
		}
		return false;
	}

	public function getRequestBody ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return $instance->requestbody;
		}
	}

	public static function getToken ()
	{
		$instance = self::getInstance ();
		if ($instance->isValid ())
		{
			return $instance->token;
		}
	}
}