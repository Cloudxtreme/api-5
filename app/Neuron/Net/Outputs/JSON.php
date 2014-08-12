<?php
/**
 * Created by PhpStorm.
 * User: daedeloth
 * Date: 8/08/14
 * Time: 17:21
 */

namespace Neuron\Net\Outputs;


use Neuron\Net\Response;

class JSON extends HTML {

	public function __construct ()
	{
		
	}
	
	public function outputContent (Response $response)
	{
		header ('Content-type: application/json');
		echo json_encode ($response->getData ());
	}
	
} 