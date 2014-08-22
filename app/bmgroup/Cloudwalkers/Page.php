<?php


namespace bmgroup\Cloudwalkers;

use Neuron\Page as NeuronPage;
use Neuron\Core\Tools;
use Neuron\Core\Template;
use Neuron\Session;


class Page
	extends NeuronPage
{
	
	public function getOutput ()
	{
		$html = new Template ();

		$html->set ('title', $this->title);
		$html->set ('content', $this->content);

		$html->set ('loggedin', Session::getInstance ()->isLogin ());

		$display = Tools::getInput ('_GET', 'display', 'varchar');

		switch ($display)
		{
			case 'mobile':
				return $html->parse ('mobile/index.phpt');
			break;

			default:
				return $html->parse ('index.phpt');
			break;
		}
	}

	public function getOutputAdmin ()
	{
		$html = new Template ();
		$html->set ('title', $this->title);
		$html->set ('content', $this->content);
		$html->set ('loggedin', Session::getInstance ()->isLogin ());
		$html->set ('nav', $this->getCurUri ());

		$display = Tools::getInput ('_GET', 'display', 'varchar');

		return $html->parse ('admin-index.phpt');
	}

	// ===== USED TO SELECT CURRENT PAGE IN ADMIN LAYOUT =====
	public function getCurUri () {

		$uri = $_SERVER["REQUEST_URI"];
		$uri = explode('?', $uri);
		$uri = explode('/', $uri[0]);

		return $uri;
	}

}