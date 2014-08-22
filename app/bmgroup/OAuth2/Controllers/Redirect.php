<?php
namespace bmgroup\OAuth2\Controllers;

use bmgroup\OAuth2\Verifier;
use Neuron\Core\Template;
use Neuron\Interfaces\FrontController as NeuronInterfacesFrontController;
use Neuron\Page;
use Neuron\Session;
use Neuron\URLBuilder;
use OAuth2\Response;

class Redirect
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
		echo json_encode (array ('success' => 1, 'message' => 'Welcome to the World of Tomorrow!'));
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