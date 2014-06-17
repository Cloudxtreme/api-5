<?php

namespace League\OAuth2\Server\Storage\PDO;

use \PDO as PDO;

/*
class Db
{
	**
	 * Db constructor
	 * @param array|string $dsn Connection DSN string or array of parameters
	 * @return void
	 *
    public function __construct($dsn = '')
    {
        $db = \ezcDbFactory::create($dsn);
        \ezcDbInstance::set($db);
    }
}
*/

class Db {

	public $conn;
	private $statement;

	function __construct($dsn = '', $username = '', $password = '', $options = null)
	{
		// $this->conn = new PDO('mysql:host=127.0.0.1;dbname=cloudwalkers', 'myuser', 'myuser');
		// $this->conn = new PDO('sqlite:host=127.0.0.1;dbname=cloudwalkers.db', 'myuser', 'myuser');
		
		// Check if we have a DSN string, if we dont have, build it
		if ("$dsn" == ''){
			
			$username = DB_OAUTH2_USERNAME;
			$password = DB_OAUTH2_PASSWORD;
			
			if (strstr(DB_HOST, ':')) {
				// Initiate a new database connection
				$dsn = DB_OAUTH2_PROTOCOL . ':host='. DB_OAUTH2_HOST .';dbname='. DB_OAUTH2_NAME;
			} else {
				// Check if we are sending the PORT on the HOST constant
				$dsn = DB_OAUTH2_PROTOCOL . ':host='. DB_OAUTH2_HOST .';port='. DB_OAUTH2_PORT .';dbname='. DB_OAUTH2_NAME;
			}
		}
		
		/*
		$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		);
		
		$this->conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
		*/
		
		//echo "DSN: $dsn<br />\n";
		
		$this->conn = new PDO($dsn, $username, $password, $options);
		
	}

	function query($sql = '', $params = array(), $pdo_fetch_params = PDO::FETCH_OBJ)
	{
		$statement = $this->conn->prepare($sql);
		$statement->setFetchMode($pdo_fetch_params);
		$statement->execute($params);
		return $statement;
	}
	
	function queryAndFetchAll($sql = '', $params = array(), $pdo_fetch_params = PDO::FETCH_ASSOC) {
		//return $this->query($sql, $params)->fetchAll($pdo_fetch_params);
		return $this->query($sql, $params, $pdo_fetch_params)->fetchAll();
	}

	function escape($str) {
		return $this->conn->quote($str);
	}
	
	public function getInsertId()
	{
		return (int) $this->conn->lastInsertId();
	}

}