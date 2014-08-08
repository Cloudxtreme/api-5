<?php

namespace League\OAuth2\Server\Filters;

use Response;
use Session;
use Exception;

/*
use AuthorizationServer;
use League\OAuth2\Server\Exception\ClientException;
*/

class CheckAuthorizationParamsFilter
{
	public $authserver = null;
	

	/**
	 * Run the check authorization params filter
	 *
	 * @param Route $route the route being called
	 * @param Request $request the request object
	 * @param string $scope additional filter arguments
	 * @return Response|null a bad response in case the params are invalid
	 */
	public function filter($route, $request, $scope = null)
	{
		try {
			
			// Retrieve the auth params from the user's session
			/*$params['client_id'] = Session::get('client_id');
			$params['client_details'] = Session::get('client_details');
			$params['redirect_uri'] = Session::get('redirect_uri');
			$params['response_type'] = Session::get('response_type');
			$params['scopes'] = Session::get('scopes');
			
			// Check that the auth params are all present
			foreach ($params as $key=>$value) {
				if ($value === null) {
					// Throw an error because an auth param is missing - don't
					//  continue any further
				}
			}
			
			// Get the user ID
			$params['user_id'] = Session::get('user_id');

			*/
			
			//$params = AuthorizationServer::checkAuthorizeParams();

			// Create the auth server, the three parameters passed are references
			// to the storage models
			$this->authserver = new \League\OAuth2\Server\Authorization(
				//new ClientModel, new SessionModel, new ScopeModel
				new \League\OAuth2\Server\Storage\PDO\Client,
				new \League\OAuth2\Server\Storage\PDO\Session,
				new \League\OAuth2\Server\Storage\PDO\Scope
			);
			
			// Tell the auth server to check the required parameters are in the
			//  query string
			$params = $this->authserver->getGrantType('authorization_code')->checkAuthoriseParams();
			
			Session::put('authorize-params', $params);

			//echo "=> FILTER :: CheckAuthorizationParamsFilter<br />\n";

		} catch (ClientException $e) {

			return Response::json(array(
					'status' => 400,
					'error' => 'bad_request',
					'error_message' => $e->getMessage(),
			), 400);

		} catch (Exception $e) {

			return Response::json(array(
					'status' => 500,
					'error' => 'internal_server_error',
					'error_message' => 'Internal Server Error: '. $e->getMessage(),
			), 500);
		}
	}
}
