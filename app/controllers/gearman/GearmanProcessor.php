<?php

use \GearmanWorker as GearmanWorker;


// Create our worker object
$worker = new GearmanWorker();

// Add a server (again, same defaults apply as a worker)
//$worker->addServer();
//$worker->addServer('192.168.56.1', 4370);
$worker->addServer('192.168.56.102', '4730'); // by default host/port will be "localhost" & 4730


// Existing functions
$functions_to_declare = array(
	 "reverse", "reverse_fn"
	,"get_user_details", "getUserDetails"
);

// Inform the server that this worker can process the following function calls
foreach ($functions_to_declare as $func) {
	$worker->addFunction($func[0], $func[1]);
}

while (1) {
	print "Waiting for job...\n";
	$ret = $worker->work(); // work() will block execution until a job is delivered
	if ($worker->returnCode() != GEARMAN_SUCCESS) {
		break;
	}
}

function before_process($workload) {
	echo "Received job: " . $job->handle() . "\n";
	echo "Workload: $workload\n";
} 

// A much simple reverse function
function reverse_fn(GearmanJob $job) {
	$workload = $job->workload();
	
	before_process($workload);
	
	$result = "#".strrev($workload) ."#";
	echo "Result: $result\n";
	return $result;
}


// GET => /user/{id}/
// Get user details
function getUserDetails(GearmanJob $job) {
	$workload = $job->workload();
	
	before_process($workload);
	
	$result = "#".strrev($workload) ."#";
	echo "Result: $result\n";
	return $result;
}



