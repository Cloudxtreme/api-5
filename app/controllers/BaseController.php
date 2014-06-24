<?php

class BaseController extends Controller 
{

public $config_folder = "";
public $config_file = "";

	function __construct()
	{
		// --------------------------------------------------------------------
		// TODO: Check if we want to maintain the same logic with the "mutable.php"
		//       or use the Laravel settings / configuration files
		// --------------------------------------------------------------------
		
		// Define the config folder
		$this->config_folder = str_replace("\\", "/", dirname(__FILE__) ."/../config");
		
		//include_once dirname(__FILE__) .'/../../../app/config/mutable-local.php';
		
		// Check if we have a development configuration file
		if (file_exists($this->config_folder . "/mutable-local.php")) {

			// Development configuration
			$this->config_file = $this->config_folder . "/mutable-local.php";
			
		} else {
			
			// Production configuration
			$this->config_file = $this->config_folder . "/mutable.php";
			
		}
		
		// Include configuration settings /app/config/{ mutable.php || mutable-local.php }
		require_once $this->config_file;
		
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
