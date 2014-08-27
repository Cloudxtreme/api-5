<?php

class OAuth2Controller extends BaseController {

	public function dispatch ($path)
	{
		$page = new \bmgroup\CloudwalkersClient\Page ();

		$frontcontroller = new \Neuron\FrontController ();
		$frontcontroller->setInput (Request::segments ());
		$frontcontroller->setPage ($page);

		$frontcontroller->addController (new \bmgroup\Signin\FrontController ());
		$frontcontroller->addController (new \bmgroup\OAuth2\FrontController ());

		$response = $frontcontroller->dispatch ($page);

		if ($response)
		{
			$response->output ();
		}

		exit;
	}

}
