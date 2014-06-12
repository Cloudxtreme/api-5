<?php

use League\OAuth2\Server\Storage\ClientInterface as OAuth2StorageClientInterface;

//class ClientModel implements \OAuth2\Storage\ClientInterface {

class ClientModel implements OAuth2StorageClientInterface {

	//public function getClient($clientId = null, $clientSecret = null, $redirectUri = null)
	
	public function getClient($clientId, $clientSecret = NULL, $redirectUri = NULL, $grantType = NULL) 
	{
		return array(
			'client_id' => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
			'client secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
			'redirect_uri' => 'http://cloudwalkers-api.local/signin/redirect',
			'name' => 'Test Client'
		);
	}

}