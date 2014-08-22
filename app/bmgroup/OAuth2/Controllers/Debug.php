<?php
namespace bmgroup\OAuth2\Controllers;

use bmgroup\Cloudwalkers\Models\User;
use bmgroup\OAuth2\Verifier;
use Neuron\Core\Template;
use Neuron\DB\Query;
use Neuron\DB\QuerySQLite;
use Neuron\Interfaces\FrontController as NeuronInterfacesFrontController;
use Neuron\Page;
use Neuron\Session;
use Neuron\URLBuilder;
use OAuth2\Response;

class Debug
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
		$input = $this->getInput (2);

		$response = new Response();

		if (!Session::getInstance ()->isLogin ())
		{
			echo '<p>' . __('This page is only available for registered users.') . '</p>';

			$_SESSION['after_login_redirect'] = URLBuilder::getURL ('oauth2/authorize/next', $_GET);

			// Check for extra input
			//header ('Location: ' . URLBuilder::getURL ('login'));

			return;
		}

		$user = Session::getInstance ()->getUser ();

		if ($user instanceof User)
		{
			$accesstoken = uniqid ("", true);

			Query::insert
			(
				'oauth2_access_tokens',
				array (
					'access_token' => $accesstoken,
					'client_id' => 0,
					'user_id' => $user->getId (),
					'expires' => array (time () + 60 * 60 * 24 * 365 * 10, Query::PARAM_DATE)
				)
			)->execute ();

			$page->setContent ($accesstoken);
		}
		else
		{
			$page->setContent ("<p>Access token not generated.</p>");
		}

		echo $page->getOutput ();
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