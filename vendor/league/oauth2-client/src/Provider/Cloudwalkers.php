<?php

namespace League\OAuth2\Client\Provider;

class Cloudwalkers extends IdentityProvider
{
	public $scopes = array('user');
	public $responseType = 'json';

	public function urlAuthorize()
	{
		return 'http://cloudwalkers-api.local/oauth2/authorize';
	}

	public function urlAccessToken()
	{
		return 'http://cloudwalkers-api.local/oauth2/access_token';
	}

	public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
	{
		return 'http://cloudwalkers-api.local/api/v2/users/self?access_token='.$token;
	}

	public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
	{

		$user = new User;

		$user->uid = $response->data->id;
		$user->nickname = $response->data->username;
		$user->name = $response->data->full_name;
		$user->description = isset($response->data->bio) ? $response->data->bio : null;
		$user->imageUrl = $response->data->profile_picture;

		return $user;
	}

	public function userUid($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		return $response->data->id;
	}

	public function userEmail($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		return;
	}

	public function userScreenName($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		return $response->data->full_name;
	}

}
