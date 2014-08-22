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

class Logout
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
		$return = false;

		$code = Tools::getInput ($_GET, 'client_id', 'varchar');

		if ($code)
		{
			if (defined('DB_OAUTH2_ENGINE') && DB_OAUTH2_ENGINE == 'sqlite3') {
				$data = QuerySQLite::select ('oauth2_clients', array ('redirect_uri'), array ('client_id' => $code))->execute ();
			} else {
				$data = Query::select ('oauth2_clients', array ('redirect_uri'), array ('client_id' => $code))->execute ();
			}
			
			if (count ($data) > 0)
			{
				$return = $data[0]['redirect_uri'];
			}
		}

		if (!$return)
		{
			header ('Content-type: application/json');
			$output = array ('error' => array ('message' => 'No clientid provided or invalid clientid'));
			echo json_encode ($output);
			return;
		}

		header ('Location: ' . URLBuilder::getURL ('logout', array ('return' => $return)));
	}

	public function setParentController (NeuronInterfacesFrontController $input)
	{
		$this->parent = $input;
	}

	public function getName ()
	{
		return 'Redirect';
	}

	public function getInput($id = null)
	{
		return $this->parent->getInput ($id);
	}
}