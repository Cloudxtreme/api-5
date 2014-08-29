<?php
namespace bmgroup\OAuth2\Controllers;

use bmgroup\OAuth2\Verifier;
use Neuron\Core\Template;
use Neuron\DB\Query;
use Neuron\DB\QuerySQLite;
use Neuron\Interfaces\FrontController as NeuronInterfacesFrontController;
use Neuron\Page;
use Neuron\Session;
use Neuron\URLBuilder;
use OAuth2\Response;

class Authorize
	implements NeuronInterfacesFrontController
{
	/** @var NeuronInterfacesFrontController */
	private $parent;

	public function canDispatch ()
	{
		return true;
	}

	public function dispatch (Page $page)
	{
		/*
		$input = $this->getInput (2);

		if (empty ($input))
		{
			if (isset ($_SESSION['passes']))
			{
				if ($_SESSION['passes'] > 1)
				{
					// Is entry point? Logout first.
					Session::getInstance ()->destroy ();

					$url = URLBuilder::getURL ('oauth2/authorize/next', $_GET);

					return 'Redirecting to <a href="' . $url . '">' . $url . '</a>';
					//header ('Location: ' . $url);
				}
				else
				{
					$_SESSION['passes'] ++;
				}
			}

			else
			{
				$_SESSION['passes'] = 1;
			}
		}
		*/
		
		$server = Verifier::getInstance ()->getServer ();
		$request = Verifier::getInstance ()->getRequest ();

		$display = 'mobile';

		$response = new Response();

		// validate the authorize request
		if (!$server->validateAuthorizeRequest($request, $response))
		{
			$response->send();
			die;
		}

		$clientid = $server->getAuthorizeController ()->getClientId ();
		$clientdata = $server->getStorage('client')->getClientDetails ($clientid);

		// Check if we should log the user out (after a revoke)
		$this->checkForLogout ($server);

		$layout = $clientdata['login_layout'];
		$skipAuthorization = $clientdata['skip_authorization'];

		if ($layout)
		{
			$display = $layout;
		}

		if (!Session::getInstance ()->isLogin ())
		{
			//echo '<p>' . ('This page is only available for registered users.') . '</p>';

			// Check for extra input
			$_SESSION['after_login_redirect'] = URLBuilder::getURL ('oauth2/authorize/next', $_GET);

			echo '<p>Redirecting to ' . URLBuilder::getURL ('login', array ('display' => $display)) . '</p>';
			header ('Location: ' . URLBuilder::getURL ('login', array ('display' => $display)));

			return;
		}

		$user_id = Session::getInstance ()->getUser ()->getId ();

		if (!$skipAuthorization)
		{
			$fields = array ();

			$fields['client_id'] = $clientid;
			$fields['u_id'] = $user_id;

			// Check in the database if already approved
			if (defined('DB_OAUTH2_ENGINE') && DB_OAUTH2_ENGINE == 'sqlite3') {
				$data = QuerySQLite::select ('oauth2_app_authorizations', array ('*'), $fields)->execute ();
			} else {
				$data = Query::select ('oauth2_app_authorizations', array ('*'), $fields)->execute ();
			}
			
			if (count ($data) > 0)
			{
				$skipAuthorization = true;
			}
		}

		// Should we skip authorization?
		if ($skipAuthorization)
		{
			$response = $server->handleAuthorizeRequest($request, $response, true, $user_id);
			$this->storeAccessTokenInSession ($response);

			$response->send ();
			return;
		}

		// display an authorization form
		if (empty($_POST))
		{
			$this->showAuthorizationDialog ($page, $clientdata);
			return;
		}

		// print the authorization code if the user has authorized your client
		$is_authorized = ($_POST['authorized'] === 'yes');

		$response = $server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
		if ($is_authorized)
		{
			$response = $server->handleAuthorizeRequest($request, $response, true, $user_id);
			$this->storeAccessTokenInSession ($response);
			
			// this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
			//$code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
			//exit("SUCCESS! Authorization Code: $code");

			// Also store this in our database
			$fields = array ();

			$fields['client_id'] = $clientid;
			$fields['u_id'] = $user_id;
			$fields['authorization_date'] = array (time (), Query::PARAM_DATE);

			// Destroy the session
			//Session::getInstance ()->destroy ();

			if (defined('DB_OAUTH2_ENGINE') && DB_OAUTH2_ENGINE == 'sqlite3') {
				QuerySQLite::replace ('oauth2_app_authorizations', $fields)->execute ();
			} else {
				Query::replace ('oauth2_app_authorizations', $fields)->execute ();
			}

		}
		$response->send();
	}
	
	private function storeAccessTokenInSession (\OAuth2\ResponseInterface $response)
	{
		$location = $response->getHttpHeader ('Location');
		$parsed = parse_url ($location);
		$fragment = $parsed['fragment'];
		
		parse_str ($fragment, $attributes);
		if (isset ($attributes['access_token']))
		{
			$_SESSION['oauth2_access_token'] = $attributes['access_token']; 
		}
	}
	
	private function checkForLogout (\OAuth2\Server $server)
	{
		if (isset ($_SESSION['oauth2_access_token']))
		{
			// Check if this access token is still valid
			$storage = $server->getStorage ('access_token');
			
			$token = $storage->getAccessToken ($_SESSION['oauth2_access_token']);
			if (! ($token && $token['expires'] > time ()))
			{
				// Logout the user.
				Session::getInstance ()->logout ();
				
				echo 'logging out';
				exit;
			}
		}
		else 
		{
			echo 'no session data found';
			exit;
		}
	}

	private function showAuthorizationDialog (Page $page, $clientdata)
	{
		$template = new Template ();
		$template->set ('clientdata', $clientdata);
		$template->set ('action', URLBuilder::getURL ('oauth2/authorize/next', $_GET));
		$page->setContent ($template->parse ('modules/oauth2/authorize.phpt'));

		echo $page->getOutput ();

		/*
		exit('<form method="post">
			<label>Do You Authorize TestClient?</label><br />
			<input type="submit" name="authorized" value="yes">
			<input type="submit" name="authorized" value="no">
			</form>');
		*/
	}

	public function setParentController (NeuronInterfacesFrontController $input)
	{
		$this->parent = $input;
	}

	public function getName ()
	{
		return 'Authorize';
	}

	public function getInput($id = null)
	{
		return $this->parent->getInput ($id);
	}
}