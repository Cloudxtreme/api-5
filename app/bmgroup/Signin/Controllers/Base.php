<?php


namespace bmgroup\Signin\Controllers;

use Neuron\Page;
use Neuron\FrontController;


class Base
{
	private $rootController;

	public function getInput ($id)
	{
		$input = $this->rootController->getInput ();
		return isset ($input[$id]) ? $input[$id] : null;
	}

	public function dispatch (Page $page)
	{
		$page->setContent ($this->getContent ());

		$response = \Neuron\FrontController::getInstance()->getResponse ();
		$response->setBody ($page->getOutput ());

		//echo $page->getOutput ();
	}

	public function getContent ()
	{
		return '<p>Bla</p>';
	}

	public function setParentController (FrontController $input)
	{
		$this->rootController = $input;
	}

	public function getName ()
	{
		return join('', array_slice(explode('\\', get_class ($this)), -1));
	}
}