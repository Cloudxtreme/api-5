<?php


namespace bmgroup\Signin;

use Neuron\Interfaces\FrontController as NeuronInterfacesFrontController;
use Neuron\Core\Template;
use Neuron\Exceptions\DataNotSet;
use Neuron\Page;
use Neuron\FrontController as NeuronFrontController;
use Neuron\Session;
use Neuron\Tracking\Tracker;


class FrontController
	implements NeuronInterfacesFrontController
{
	/** @var NeuronInterfacesFrontController */
	private $rootController;

	public function __construct ()
	{
		\Neuron\Core\Template::addTemplatePath(dirname (__FILE__) . '/templates/', 'modules/signin/');
	}

	public function canDispatch ()
	{
		$input = $this->rootController->getInput ();
		$action = isset ($input[0]) ? $input[0] : null;
		switch ($action)
		{
			case 'login':
			case 'register':
			case 'logout':
				return true;
			break;
		}
		return false;
	}

	private function getController ()
	{
		$input = $this->rootController->getInput ();
		$action = isset ($input[0]) ? $input[0] : null;

		$module = $this->getControllerFromInput ($action);
		if (!$module)
		{
			throw new DataNotSet ("No Login controller found.");
		}

		$module->setParentController ($this->rootController);

		return $module;
	}

	private function getControllerFromInput ($module)
	{
		$classname = '\\bmgroup\\Signin\\Controllers\\' . ucfirst ($module);
		if (class_exists ($classname))
		{
			return new $classname ();
		}

		return null;
	}

	public function dispatch (Page $page)
	{
		// Requires session.
		Session::getInstance ()->connect ();

		Tracker::getInstance ()->setModule ('bmgroup/Signin');

		$response = \Neuron\FrontController::getInstance()->getResponse ();
		$response->setHeader ('Access-Control-Allow-Origin', '*');
		
		$controller = $this->getController ();

		Tracker::getInstance ()->setController ($controller->getName ());

		$controller->dispatch ($this->rootController->getPage ());
		return $response;
	}

	public function setParentController (NeuronInterfacesFrontController $rootController)
	{
		$this->rootController = $rootController;
	}

	public function getName ()
	{
		return join('', array_slice(explode('\\', get_class ($this)), -1));
	}

	public function getInput($id = null)
	{
		return $this->rootController->getInput ($id);
	}
}
