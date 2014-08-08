<?php
/**
 * Created by PhpStorm.
 * User: daedeloth
 * Date: 8/08/14
 * Time: 12:12
 */

define ('APP_SECRET_KEY', 'bmgroup tickee catlab pineapple orange');

class CloudwalkersRequest {

	private $url;
	private $method;
	private $input;

	/** @var User */
	private $user;
	private $requeststring;
	private $body;
	private $path;
	private $post;
	private $headers;

	private $application;

	public function __construct ($url = null)
	{
		if (strpos ($url, '?') !== false)
		{
			$parts = explode ('?', $url);
			$query = array_pop ($parts);
			$this->setQueryString ($query);
			$url = implode ('?', $parts);
		}

		if (isset ($url))
		{
			$this->setUrl ($url);
		}
	}

	/**
	 * Serialize & deserialize requests
	 * @param $json
	 * @return \Neuron\Net\Request
	 * @throws \Neuron\Exceptions\InvalidParameter
	 */
	public static function fromJSON ($json)
	{
		$data = json_decode ($json, true);

		if (!isset ($data['signature']))
		{
			throw new InvalidParameter ("All decoded requests must have a signature.");
		}

		if ($data['signature'] != self::calculateSignature ($data))
		{
			throw new InvalidParameter ("Leave now, and Never come Back! *gollem, gollem* (Decoded request signature mismatch).");
		}

		// Check signature
		$model = new self ($data['url']);
		$model->setInput ($data['input']);

		if ($data['user'])
		{
			$user = MapperFactory::getUserMapper ()->getFromId ($data['user']);
			$model->setUser ($user);
		}

		$model->setBody ($data['body']);
		$model->setApplication ($data['application']);
		$model->setHeaders ($data['headers']);

		return $model;
	}

	public static function fromInput ($path)
	{
		global $module;

		$model = new self ($path);

		$model->setMethod ($_SERVER['REQUEST_METHOD']);
		if (isset ($module))
		{
			$model->setPath ($module);
			$input = explode ('/', $module);
			$model->setInput ($input);
		}
		
		else {
			$model->setPath ($path);
			$input = explode ('/', $path);
			$model->setInput ($input);
		}

		$model->setBody (Request::instance()->getContent ());
		$model->setHeaders (getallheaders ());

		return $model;
	}

	public function getData ()
	{
		return array (
			'url' => $this->url,
			'method' => $this->method,
			'input' => $this->input,
			'user' => $this->user ? $this->user->getId () : null,
			'body' => $this->getBody (),
			'application' => $this->getApplication (),
			'path' => $this->getPath (),
			'headers' => $this->getHeaders (),
			'random' => mt_rand (),
			'time' => gmdate ('c')
		);
	}

	private static function calculateSignature ($data)
	{
		unset ($data['signature']);

		$txt = '\(^-^)/ !Stupid Rainbow Tables! \(^-^)/ ';
		foreach ($data as $k => $v)
		{
			$txt .= $k . ":" . json_encode ($v) . "|";
		}
		$txt .= APP_SECRET_KEY;

		return md5 ($txt);
	}

	/**
	 * @return string json
	 */
	public function getJSON ()
	{
		$data = $this->getData ();

		// TODO: add signature here.
		$data['signature'] = $this->calculateSignature ($data);

		return json_encode ($data);
	}

	public function setUrl ($url)
	{
		$this->url = $url;
	}

	public function getUrl ()
	{
		return $this->url;
	}

	public function setMethod ($method)
	{
		$this->method = $method;
	}

	public function getMethod ()
	{
		return $this->method;
	}

	public function setInput ($input)
	{
		$this->input = $input;
	}

	public function getInput ($input = null)
	{
		if (isset ($input))
		{
			if (isset ($this->input[$input]))
			{
				return $this->input[$input];
			}
			return null;
		}
		return $this->input;
	}

	public function setUser (User $user)
	{
		$this->user = $user;
	}

	public function getUser ()
	{
		return $this->user;
	}

	public function setQueryString ($string)
	{
		$this->setRequestString ($string);
	}

	public function setRequestString ($requeststring)
	{
		$this->requeststring = $requeststring;
	}

	public function getRequestString ()
	{
		return $this->requeststring;
	}

	public function setBody ($body)
	{
		$this->body = $body;
	}

	public function setRequestBody ($body)
	{
		$this->body = $body;
	}

	public function getBody ()
	{
		return $this->body;
	}

	public function getRequestBody ()
	{
		return $this->body;
	}

	public function setApplication ($id)
	{
		$this->application = $id;
	}

	public function getApplication ()
	{
		return $this->application;
	}

	public function setPath ($path)
	{
		$this->path = $path;
	}

	public function getPath ()
	{
		return $this->path;
	}

	public function setPost ($post)
	{
		$this->post = $post;
	}

	public function getPost ()
	{
		return $this->post;
	}
	
	public function setHeaders ($headers)
	{
		$this->headers = $headers;
	}
	
	public function getHeaders ()
	{
		return $this->headers;
	}
} 