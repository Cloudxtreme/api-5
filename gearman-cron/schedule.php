<?php
$client= new GearmanClient();
$client->addServer();
print $client->doBackground("ScheduleController@run", "schedule");
?>