<?php

use \GearmanWorker as GearmanWorker;


// Create our worker object
$worker = new GearmanWorker();

// Add a server (again, same defaults apply as a worker)
//$worker->addServer();
//$worker->addServer('192.168.56.1', 4370);
$worker->addServer('192.168.56.102', '4730'); // by default host/port will be "localhost" & 4730

// Inform the server that this worker can process "reverse" function calls
$worker->addFunction("reverse", "reverse_fn");

while (1) {
	print "Waiting for job...\n";
	$ret = $worker->work(); // work() will block execution until a job is delivered
	if ($worker->returnCode() != GEARMAN_SUCCESS) {
		break;
	}
}

// A much simple reverse function
function reverse_fn(GearmanJob $job) {
	$workload = $job->workload();
	echo "Received job: " . $job->handle() . "\n";
	echo "Workload: $workload\n";
	$result = "#".strrev($workload) ."#";
	echo "Result: $result\n";
	return $result;
}



