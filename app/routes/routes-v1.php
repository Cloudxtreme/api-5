<?php

Route::get ('1/version', 'NeuronProxyController@guest');

// Reseller endpoints
Route::group(array('before' => 'resellersigned'), function($v)
{
	Route::get('1/resellers/{resellerId}/plans', 'NeuronProxyController@openssl');
	Route::get('1/resellers/{resellerId}/accounts', 'NeuronProxyController@openssl');
	Route::post('1/resellers/{resellerId}/accounts', 'NeuronProxyController@openssl');
	Route::post('1/accounts/{accountId}/licenses', 'NeuronProxyController@openssl');
	Route::get('1/accounts/{accountId}/licenses', 'NeuronProxyController@openssl');
	Route::post('1/accounts/{accountId}/users', 'NeuronProxyController@openssl');
	Route::get('1/accounts/{accountId}/users', 'NeuronProxyController@openssl');
});
