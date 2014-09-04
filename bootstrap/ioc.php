<?php

use bmgroup\CloudwalkersClient\CwGearmanClient;

$cwclient = CwGearmanClient::getInstance ();
App::instance ('cwclient', $cwclient);