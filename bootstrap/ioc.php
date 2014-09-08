<?php

use bmgroup\CloudwalkersClient\CwGearmanClient;

try {

	$cwclient = CwGearmanClient::getInstance ();
	App::instance ('cwclient', $cwclient);

} catch (GearmanException $e)
{
	echo "No running Gearmand.";
}