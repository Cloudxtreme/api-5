<?php

namespace Gearman;

class Services
{

	public function is_json($str) {
		//json_decode($string);
		//return (json_last_error() == JSON_ERROR_NONE);
	
		return is_array(json_decode($str,true));
	}
	
	public function fire($job, $data)
	{
		echo "WORKER: ". var_export($data) ."\n";

		//Delay 2 second to test
		//Sleep(2);
		
		throw new Exception("WORKER IS WORKING!!!");
		
	}

}

