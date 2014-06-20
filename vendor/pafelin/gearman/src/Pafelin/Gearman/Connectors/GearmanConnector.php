<?php

namespace Pafelin\Gearman\Connectors;

use \GearmanClient;
use \GearmanWorker;
use Pafelin\Gearman\GearmanQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;



class GearmanConnector implements ConnectorInterface {

    public function connect(array $config) {

    	$config['host'] = '192.168.56.1';
    	$config['port'] = '4730';
    	$config['queue'] = 'gearman';
    	 
    	$servers = array('192.168.56.1:4730');
    	$timeout = 1000;
    	
    	if(!defined('SOCKET_EAGAIN')) define('SOCKET_EAGAIN', 4);
    	//if(!defined('SOCKET_EAGAIN')) define('SOCKET_EAGAIN', 0);
    	   
    	
    	
    	//require_once 'Net/Gearman/Client.php';
    	include_once '/app/components/net_gearman/Net/Gearman/Client.php';
    	include_once '/app/components/net_gearman/Net/Gearman/Worker.php';
    	//include_once 'C:/dev/cloudwalkers-api.local/vhosts/www/app/components/net_gearman/Net/Gearman/Task.php';
    	
    	$client = new \Net_Gearman_Client('localhost:4730');
    	
    	/*
    	$client->someBackgroundJob(array(
    		'userid' => 5555,
    		'action' => 'new-comment'
    	));
    	*/
    	
    	$worker = new \Net_Gearman_Worker('localhost:4730');
    	
    	//$worker->addServer($config['host'], (int) $config['port']);
    	
    	return new GearmanQueue ($client, $worker, $config['queue']);
    	
    	
    	//$this->gearman_folder = str_replace("\\", "/", dirname(__FILE__) ."/../app/components/Gearman");
    	//$this->gearman_folder = str_replace("\\", "/", "C:/dev/cloudwalkers-api.local/vhosts/www/app/components/Gearman");
    	//include_once $this->gearman_folder .'/Client.php';
    	/*
    	include_once 'C:/dev/cloudwalkers-api.local/vhosts/www/app/components/Gearman/Client.php';
    	//include_once 'C:/dev_servers/server/php/pear/Net/Gearman/Client.php';
    	
    	
        
    	$servers = array('127.0.0.1:4730');
    	$timeout = 1000;
    	
    	//$client = new GearmanClient;
    	
    	$client = new \Net_Gearman_Client($servers, $timeout);
    	
    	//$client = new GearmanClient();
        
        $client->addServer($config['host'], (int) $config['port']);
        
        $worker = new GearmanWorker;
        
        $worker->addServer($config['host'], (int) $config['port']);
        
        return new GearmanQueue ($client, $worker, $config['queue']);
        */
    }
}