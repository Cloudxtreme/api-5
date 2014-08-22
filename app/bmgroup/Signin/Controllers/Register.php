<?php


namespace bmgroup\Signin\Controllers;

use bmgroup\Signin\Controllers\Base;
use Neuron\Session;
use Neuron\Core\Tools;
use Neuron\URLBuilder;
use Neuron\Core\Template;
use Neuron\Mappers\AccountsMapper;
use Neuron\Models\User;


class Register
	extends Base
{
	private $errors = array ();

	public function getContent ()
	{
		if (Session::getInstance ()->isLogin ())
		{
			return '<p>You are already logged in.</p>';
		}

		// Process input
		$register = Tools::getInput ('_POST', 'register', 'int');

		if ($register)
		{
			if ($this->processInput ())
			{
				if (isset ($_SESSION['after_login_redirect']))
				{
					$url = $_SESSION['after_login_redirect'];
					$_SESSION['after_login_redirect'] = null;
					\Neuron\FrontController::getInstance()->getResponse ()->setHeader ('Location', $url);
				}
				else
				{
					\Neuron\FrontController::getInstance()->getResponse ()->setHeader ('Location', URLBuilder::getURL ());
				}
			}
		}


		$page = new Template ();

		$page->set ('action', URLBuilder::getURL ('register'));
		$page->set ('login', URLBuilder::getURL ('login'));

		$page->set ('errors', $this->errors);

		$page->set ('email', Tools::getInput ('_POST', 'email', 'varchar'));
		$page->set ('firstname', Tools::getInput ('_POST', 'firstname', 'varchar'));
		$page->set ('name', Tools::getInput ('_POST', 'name', 'varchar'));

		// Add all account types that provide auth capability.
		/*
		$accounts = array ();
		foreach (AccountsMapper::getAll () as $v)
		{
			if ($v->canAuth ())
			{
				$accounts[] = $v;
			}
		}
		$page->set ('accounts', $accounts);
		*/

		return $page->parse ('modules/signin/register.phpt');
	}

	private function processInput ()
	{
		$email = Tools::getInput ('_POST', 'email', 'email');
		$password = Tools::getInput ('_POST', 'password', 'varchar');
		$password2 = Tools::getInput ('_POST', 'password2', 'varchar');

		$name = Tools::getInput ('_POST', 'name', 'varchar');
		$firstname = Tools::getInput ('_POST', 'firstname', 'varchar');

		$okay = true;

		if (!$email)
		{
			$this->errors[] = 'You have provided an invalid email address.';
			$okay = false;
		}

		if (!$password)
		{
			$this->errors[] = 'Your password does not match our security expectations.';	
			$okay = false;
		}

		if ($password != $password2)
		{
			$this->errors[] = 'Your passwords do not match.';
			$okay = false;
		}

		if (!$firstname)
		{
			$this->errors[] = 'Please provide a valid first name.';
			$okay = false;
		}

		if (!$name)
		{
			$this->errors[] = 'Please provide a valid name.';
			$okay = false;
		}

		if ($okay)
		{
			return $this->register ($email, $password, $name, $firstname);
		}
	}

	private function register ($email, $password, $name, $firstname)
	{
		// Check if email is unique
		if (!Session::getInstance ()->isEmailUnique ($email))
		{
			$this->errors[] = 'You have already registered with this email address.';
			return false;
		}

		$user = new User (null);
		$user->setEmail ($email);
		$user->setPassword ($password);

		$user->setName ($name);
		$user->setFirstname ($firstname);

		Session::getInstance ()->register ($user);

		return true;
	}
}