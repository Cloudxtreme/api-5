<?php
/**
 * Created by PhpStorm.
 * User: daedeloth
 * Date: 12/08/14
 * Time: 17:12
 */

namespace Neuron;

use Illuminate\Http\Request;

class InputStream {

	public static function getInstance ()
	{
		static $in;
		if (!isset ($in))
		{
			$in = new self ();
		}

		return $in;
	}

	public static function getInput ()
	{
		$r = new Request ();
		$request = $r->instance ();
		return $request->getContent();
	}
	
} 