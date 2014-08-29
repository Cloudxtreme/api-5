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

class Revoke
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
		if (Verifier::isValid())
		{
			$fields = array ();
			$fields['expires'] = array (time () - 1, Query::PARAM_DATE);

			$where = array ();
			$where['access_token'] = Verifier::getToken ();

			if (defined('DB_OAUTH2_ENGINE') && DB_OAUTH2_ENGINE == 'sqlite3') {
				$query = QuerySQLite::update ('oauth2_access_tokens', $fields, $where)->execute ();
			} else {
				$query = Query::update ('oauth2_access_tokens', $fields, $where);
				$query->execute ();
			}

			header ('Content-type: application/json');
			echo json_encode (array ('success' => 1, 'query' => $query->getParsedQuery ()));
		}
		else
		{
			http_response_code (403);
			header ('Content-type: application/json');
			echo json_encode (array ('error' => "invalid_request", 'error_description' => 'Invalid access token.'));
		}
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