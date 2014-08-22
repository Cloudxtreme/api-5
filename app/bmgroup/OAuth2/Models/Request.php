<?php
/**
 * Created by PhpStorm.
 * User: daedeloth
 * Date: 12/03/14
 * Time: 14:05
 */

namespace bmgroup\OAuth2\Models;


use Neuron\InputStream;

class Request
	extends \OAuth2\Request
{
	public function getContent($asResource = false)
	{
		if (false === $this->content || (true === $asResource && null !== $this->content)) {
			throw new \LogicException('getContent() can only be called once when using the resource return type.');
		}

		if (true === $asResource) {
			$this->content = false;

			//return fopen('php://input', 'rb');
			//return fopen ('data://text/plain, ' . InputStream::getInput (), 'rb');
			$stream = fopen('php://memory','r+');
			fwrite($stream, InputStream::getInput ());
			rewind($stream);
			return $stream;
		}

		if (null === $this->content) {
			$this->content = InputStream::getInput ();
		}

		return $this->content;
	}

	/**
	 * Creates a new request with values from PHP's super globals.
	 *
	 * @return Request A new request
	 *
	 * @api
	 */
	public static function createFromGlobals()
	{
		$class = __CLASS__;
		$request = new $class($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);

		$contentType = $request->server('CONTENT_TYPE', '');
		$requestMethod = $request->server('REQUEST_METHOD', 'GET');
		if (0 === strpos($contentType, 'application/x-www-form-urlencoded')
			&& in_array(strtoupper($requestMethod), array('PUT', 'DELETE'))
		) {
			parse_str($request->getContent(), $data);
			$request->request = $data;
		} elseif (0 === strpos($contentType, 'application/json')
			&& in_array(strtoupper($requestMethod), array('POST', 'PUT', 'DELETE'))
		) {
			$data = json_decode($request->getContent(), true);
			$request->request = $data;
		}

		return $request;
	}
} 