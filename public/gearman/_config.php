<?php

/**
 * Gearman Monitor configuration file
 *
 * The following server fields are available:
 *  - address: Gearman server address, hostname and port
 *  - name: Gearman server name to display in Gearman Monitor interface
 *
 * Example:
 * $cfgServers[$i]['address'] = '192.168.0.10:4730';
 * $cfgServers[$i]['name'] = 'Gearman server 1';
 * ++ $i;
 *
 * $cfgServers[$i]['address'] = '192.168.1.1:7003';
 * $cfgServers[$i]['name'] = 'Gearman server 2';
 * ++ $i;
 */

//require_once '../php/bootstrap.php';

error_reporting (E_ERROR);

define ('GEARMAN_SERVER', 'devgearman.cloudwalkers.be:4730');

if (!defined ('GEARMAN_SERVER'))
{
	echo 'No memcache devices found.';
}

$i = 0;
$cfgServers = array();

if (defined ('GEARMAN_SERVER') && GEARMAN_SERVER)
{
	$servers = explode ('|', GEARMAN_SERVER);
	
	foreach ($servers as $v)
	{
		$cfgServers[$i]['address'] = $v;
		$cfgServers[$i]['name'] = $v;
		++ $i;
	}
}