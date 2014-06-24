<?php

//
// TODO: Refector existing code to a static Servers / Workers Controller 
//


namespace Gearman;

use \Session as Session;
use \Input as Input;
use \View as View;
use \Redirect as Redirect;
//use \League\OAuth2\Server\Util\RedirectUri as RedirectUri;
//use \League\OAuth2\Server\Storage\PDO\Db as DBOauth;



/**
 * Gearman Controller to manage the queues
 */

class GearmanController extends \BaseController
{

	/*
	 |--------------------------------------------------------------------------
	| Demo Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	//public $db = null;         // Database connection
	//public $db_oauth2 = null;  // OAuth2 connection
	//public $authserver = null; // OAuth2 server object

	static $instances = array();

	/**
	 * Fetch (and create if needed) an instance of this logger.
	 *
	 * @param string $server
	 * @param int $port
	 * @param string $queue
	 * @return self
	*/
	public static function getInstance($server = '127.0.0.1', $port = 4730, $queue = 'log') {
		$hash = $queue . $server . $port;
		if (!array_key_exists($hash, self::$instances)) {
			self::$instances[$hash] = new self($queue, $server, $port);
		}

		return self::$instances[$hash];
	}

	/** @var GearmanClient */
	private $gmc;
	/** @var string */
	private $queue;

	public function __construct($queue, $server, $port) {
		// --------------------------------------------------------------------
		// LOAD CONFIGURATION FROM BASE CONTROLLER
		// --------------------------------------------------------------------
		parent::__construct();
		
		// --------------------------------------------------------------------
		// Instantiate Gearman Client
		// --------------------------------------------------------------------
		$this->gmc   = new GearmanClient();
		$this->queue = $queue;
		$this->gmc->addServer($server, $port);
		
		
	}

	/**
	 * Log a message
	 *
	 * @param mixed $message
	 * @param string $level
	 */
	public function log($message, $level = 'DEBUG') {
		$this->gmc->doBackground($this->queue, json_encode(array(
				'level'   => $level,
				'message' => $message,
				'ts'      => time(),
				'host'    => gethostname(),
		)));
	}

	/**
	 * Log a warning
	 * @param mixed $message
	 */
	public function warn($message) {
		$this->log($message, 'WARN');
	}

	/**
	 * Log an error
	 * @param mixed $message
	 */
	public function error($message) {
		$this->log($message, 'ERROR');
	}

}

