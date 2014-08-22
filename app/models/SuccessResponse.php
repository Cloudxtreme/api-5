<?php
/**
 * Created by PhpStorm.
 * User: daedeloth
 * Date: 22/08/14
 * Time: 2:02
 */

class BaseResponse extends \Illuminate\Http\Response
{
	public function __construct($content = '', $status = 200, $headers = array())
	{
		$headers['Access-Control-Allow-Origin'] = '*';
		$headers['Access-Control-Allow-Methods'] = 'GET, PUT, POST, DELETE, HEAD, OPTIONS';
		$headers['Access-Control-Allow-Headers'] = 'X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept';

		parent::__construct($content, $status, $headers);
	}
}