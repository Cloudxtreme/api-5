<?php

namespace bmgroup\OAuth2;

use bmgroup\OAuth2\Controllers\Debug;
use bmgroup\OAuth2\Controllers\Logout;
use bmgroup\OAuth2\Controllers\Redirect;
use bmgroup\OAuth2\Controllers\Register;
use bmgroup\OAuth2\Controllers\Revoke;
use Neuron\Interfaces\FrontController as NeuronInterfacesFrontController;
use Neuron\Page;
use Neuron\Session;
use OAuth2\Request;
use bmgroup\OAuth2\Controllers\Authorize;

class FrontController
	implements NeuronInterfacesFrontController
{
	public function __construct ()
	{
		\Neuron\Core\Template::addTemplatePath(dirname (__FILE__) . '/templates/', 'modules/oauth2/');
	}

	/** @var \Neuron\FrontController */
	private $rootController;

	const ERROR_GENERAL = 400;
	const ERROR_LIMITED = 402;
	const ERROR_UNAUTHORIZED = 403;
	const ERROR_NOTFOUND = 404;
	const ERROR_INVALIDINPUT = 404;

	public function canDispatch ()
	{
		$input = $this->rootController->getInput ();
		$action = isset ($input[0]) ? $input[0] : null;
		switch ($action)
		{
			case 'oauth2':
				return true;
			break;
		}
		return false;
	}

	/**
	 * Get (uppercase) http method.
	 * @return string
	 */
	protected function getMethod ()
	{
		$method = isset ($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		return strtoupper ($method);
	}

	public function dispatch (Page $page)
	{
		header ('Access-Control-Allow-Origin: *');
		header ('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, PATCH, OPTIONS');
		header ('Access-Control-Allow-Headers: origin, x-requested-with, content-type, access_token, authorization');

		switch ($this->getMethod ())
		{
			case 'OPTIONS':
				echo 'These are not the droids you\'re looking for.';
				return;
			break;
		}

		// Requires session.
		Session::getInstance ()->connect ();

		$server = Verifier::getInstance ()->getServer ();

		$input = $this->rootController->getInput ();
		$action = isset ($input[1]) ? $input[1] : null;

		switch ($action)
		{
			case 'token':
				$server->handleTokenRequest(Request::createFromGlobals())->send();
			break;

			case 'authorize':
				$controller = new Authorize ();
				$controller->setParentController ($this);
				$controller->dispatch ($page);
			break;

			case 'debug':
				$controller = new Debug ();
				$controller->setParentController ($this);
				$controller->dispatch ($page);
			break;

			case 'register':
				$controller = new Register ();
				$controller->setParentController ($this);
				$controller->dispatch ($page);
				break;

			case 'redirect':
				$controller = new Redirect ();
				$controller->setParentController ($this);
				$controller->dispatch ($page);
			break;

			case 'logout':
				$controller = new Logout ();
				$controller->setParentController ($this);
				$controller->dispatch ($page);
				break;

			case 'revoke':
				$controller = new Revoke ();
				$controller->setParentController ($this);
				$controller->dispatch ($page);
			break;

			case '':
				http_response_code (self::ERROR_NOTFOUND);

				header ("Content-type: application/json");
				echo json_encode (array ('error' => 'invalid_request', 'error_description' => 'No OAuth2 method provided.'));
			break;

			default:
				http_response_code (self::ERROR_NOTFOUND);

				header ("Content-type: application/json");
				echo json_encode (array ('error' => 'invalid_request', 'error_description' => 'OAuth2 method not found: ' . $action ));
			break;
		}
	}

	public function setParentController (NeuronInterfacesFrontController $input)
	{
		$this->rootController = $input;
	}

	public function getName ()
	{
		return 'OAuth2';
	}

	public function getInput($id = null)
	{
		return $this->rootController->getInput ($id);
	}
}