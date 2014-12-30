<?php

/**
 *	Schedule Cron
 *	The schedule cron adds the Schedule job to Gearman
 *	The job is background, we don't need a response
 *
 *	Expected payload:
 *	controller name, action, open, user (optional), http payload (optional)
**/

#	$client= new GearmanClient();
#	$client->addServer();

$payload = array('controller'=> 'ScheduleController', 'action'=> 'run', 'open'=> round(microtime(true), 3), 'payload'=> null, 'user'=> null);

$client->doHighBackground("controllerDispatch", json_encode($payload));

?>