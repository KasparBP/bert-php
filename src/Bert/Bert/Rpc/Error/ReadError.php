<?php
namespace Bert\Bert\Rpc\Error;

use Bert\Bert\Rpc\Error;

class ReadError extends Error
{
	public $host;
	public $port;

	public function __construct($host, $port)
	{
		$this->host = $host;
		$this->port = $port;

		parent::__construct("Unable to read from $host:$port");
	}
}
