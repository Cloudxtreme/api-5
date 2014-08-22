<?php


namespace bmgroup\Signin\Controllers;

use bmgroup\Signin\Controllers\Base;
use Neuron\Session;
use Neuron\Core\Tools;


class Logout
	extends Base
{
	private $errors = array ();

	public function getContent ()
	{
		Session::getInstance ()->logout ();

		$redirect = Tools::getInput ('_GET', 'return', 'varchar');
		if ($redirect)
		{
			\Neuron\FrontController::getInstance()->getResponse ()->setHeader ('Location', $redirect);
		}
		
		if (!Session::getInstance ()->isLogin ())
		{
			return '<p>You are not logged in.</p>';
		}
		else
		{
			return '<p>You are now logged out.</p>';
		}
	}
}