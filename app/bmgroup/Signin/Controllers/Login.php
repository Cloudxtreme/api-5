<?php


namespace bmgroup\Signin\Controllers;

use bmgroup\CloudwalkersClient\CwGearmanClient;
use bmgroup\Signin\Controllers\Base;
use Neuron\Session;
use Neuron\Core\Tools;
use Neuron\URLBuilder;
use Neuron\Core\Template;
use Neuron\Mappers\AccountsMapper;
use Neuron\MapperFactory;
use Neuron\Models\User;


class Login 
	extends Base
{
	private $errors = array ();

	public function getContent ()
	{
		if (Session::getInstance ()->isLogin ())
		{
			if (isset ($_SESSION['after_login_redirect']))
			{
				$url = $_SESSION['after_login_redirect'];
				$_SESSION['after_login_redirect'] = null;
				//header ('Location: ' . $url);

				\Neuron\FrontController::getInstance ()->getResponse ()->redirect ($url);
			}
			else
			{
				//header ('Location: ' . URLBuilder::getURL ());
				//\Neuron\FrontController::getInstance ()->getResponse ()->redirect (URLBuilder::getURL ());
				return '<p>Already logged in.</p>';
			}
		}

		// Lost password
		$action = $this->getInput (1);

		switch ($action)
		{
			case 'lostpassword':
				return $this->getLostPassword ();
			break;

			case 'thirdparty':
				return $this->getThirdPartyLogin ();
			break;

			case 'form':
			default:
				return $this->getLoginForm ();
			break;
		}
	}

	private function getLoginForm ()
	{
		$login = Tools::getInput ('_POST', 'login', 'int');
		if ($login)
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

		$page->set ('errors', $this->errors);

		$page->set ('register', URLBuilder::getURL ('register', $_GET));
		$page->set ('lostpassword', URLBuilder::getURL ('login/lostpassword', $_GET));
		$page->set ('action', URLBuilder::getURL ('login/form', $_GET));

		return $page->parse ('modules/signin/loginform.phpt');
	}

	public function processInput ()
	{
		$email = Tools::getInput ('_POST', 'email', 'email');
		$password = Tools::getInput ('_POST', 'password', 'varchar');

		/*
		$user = MapperFactory::getUserMapper ()->getFromLogin ($email, $password);
		if ($user)
		{
			Session::getInstance ()->login ($user);
			return true;
		}
		*/
		$userdata = CwGearmanClient::getInstance ()->login ($email, $password);
		if (isset ($userdata['error']) || !isset ($userdata['id']))
		{
			$this->errors[] = 'The email or password you have provided are incorrect.';
			return false; 
		}

		$user = new User ($userdata['id']);
		Session::getInstance ()->login ($user);
		
		return true;
	}

	private function getLostPassword ()
	{
		$email = Tools::getInput ('_POST', 'email', 'varchar');

		$errors = array ();
		$feedback = array ();

		$id = Tools::getInput ('_GET', 'id', 'int');
		$code = Tools::getInput ('_GET', 'code', 'varchar');

		// Code and id received?
		if ($id && $code)
		{
			$user = MapperFactory::getUserMapper ()->getFromId ($id);

			if (!$user)
			{
				return '<p>' . __('User not found.') . '</p>';
			}

			if (!$user->hasResetToken ($code))
			{
				return '<p>' . __('The token you are using is not found. Probably the link you clicked expired.') . '</p>';	
			}

			return $this->getResetPasswordForm ($user, $code);
		}

		// Send the email.
		if ($email)
		{
			$user = MapperFactory::getUserMapper ()->getFromEmail ($email);
			if ($user)
			{
				$user->startResetPassword ();
				$feedback[] = 'We have sent you an email with instructions on how to reset your password.';
			}
			else
			{
				$errors[] = 'That email address does not exist in our database.';
			}
		}
	
		$page = new Template ();

		$page->set ('errors', $errors);
		$page->set ('feedback', $feedback);
		$page->set ('login', URLBuilder::getURL ('login', $_GET));
		$page->set ('action', URLBuilder::getURL ('login/lostpassword', $_GET));

		return $page->parse ('modules/signin/lostpassword.phpt');	
	}

	private function getResetPasswordForm (User $user, $code)
	{
		$errors = array ();
		$feedbacks = array ();

		$newpassword = Tools::getInput ('_POST', 'password1', 'varchar');
		$newpassword2 = Tools::getInput ('_POST', 'password2', 'varchar');

		if ($newpassword)
		{
			$success = $user->changePassword (null, $newpassword, $newpassword2, true);
			$errors = $user->getErrors ();
			$feedbacks = $user->getFeedback ();

			if ($success)
			{
				return '<div class="feedbacks"><p class="feedback">' . __($feedbacks[0]) . '<br />' . __('You can now login with your new password.') . '</p><p><a href="' . URLBuilder::getURL ('login') . '">' . __('Return to login') . '</a></div>';
			}
		}

		$page = new Template ();
		$action = URLBuilder::getUrl ('login/lostpassword', array_merge ($_GET, array ('id' => $user->getId (), 'code' => $code)));
		$page->set ('action', $action);
		$page->set ('errors', $errors);
		$page->set ('feedback', $feedbacks);
		return $page->parse ('modules/signin/changepassword.phpt');
	}
}