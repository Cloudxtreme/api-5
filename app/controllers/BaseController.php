<?php

class BaseController extends Controller {

public $config_folder = "";
public $config_file = "";

	function __construct()
	{
		// Define the config folder
		$this->config_folder = str_replace("\\", "/", dirname(__FILE__) ."/../config");
		
		// Check if we have a development configuration file
		if (file_exists($this->config_folder . "/mutable-local.php")) {

			// Development configuration
			$this->config_file = $this->config_folder . "/mutable-local.php";
			
		} else {
			
			// Production configuration
			$this->config_file = $this->config_folder . "/mutable.php";
			
		}
		
		// Include configuration settings
		require_once $this->config_file;
		
		
		/*
		// API request
		$this->authserver = new League\OAuth2\Server\Authorization(
                 new League\OAuth2\Server\Storage\PDO\Client($db),
                 new League\OAuth2\Server\Storage\PDO\Session($db),
                 new League\OAuth2\Server\Storage\PDO\Scope($db)
         );
		*/
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
