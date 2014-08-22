<?php
namespace bmgroup\OAuth2\Controllers;

use bmgroup\OAuth2\Verifier;
use Neuron\Core\Template;
use Neuron\Core\Tools;
use Neuron\DB\Query;
use Neuron\DB\QuerySQLite;
use Neuron\Interfaces\FrontController as NeuronInterfacesFrontController;
use Neuron\Page;
use Neuron\Session;
use Neuron\URLBuilder;
use OAuth2\Response;

class Register
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
		if (!Session::getInstance ()->isLogin ())
		{
			$_SESSION['after_login_redirect'] = URLBuilder::getURL ('oauth2/register');
			header ('Location: ' . URLBuilder::getURL ('login'));
			echo '<p>Please login first.</p>';
			return;
		}

		$redirect = Tools::getInput ($_POST, 'redirecturl', 'varchar');

		if ($redirect)
		{
			$clientid = uniqid ('oauth2', true);
			$password = md5 (uniqid ('secret'));

			$fields = array
			(
				'client_id' => $clientid,
				'client_secret' => $password,
				'redirect_uri' => $redirect,
				'login_layout' => 'mobile',
				'skip_authorization' => 0,
				'user_id' => Session::getInstance ()->getUser ()->getId ()
			);

			if (defined('DB_OAUTH2_ENGINE') && DB_OAUTH2_ENGINE == 'sqlite3') {
				QuerySQLite::insert ('oauth2_clients', $fields)->execute ();
			} else {
				Query::insert ('oauth2_clients', $fields)->execute ();
			}

			$template = new Template ();
			$template->set ('clientid', $clientid);
			$template->set ('clientsecret', $password);
			$template->set ('redirecturi', $redirect);

			$page->setContent ($template->parse ('modules/oauth2/registerdone.phpt'));

			echo $page->getOutput ();
		}
		else
		{
			$template = new Template ();
			$page->setContent ($template->parse ('modules/oauth2/register.phpt'));

			echo $page->getOutput ();
		}
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