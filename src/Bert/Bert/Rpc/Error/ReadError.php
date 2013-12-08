<?php
namespace Bert\Bert\Rpc\Error;

use Bert\Bert\Rpc\Bert_Rpc_Error;

class Bert_Rpc_Error_ReadError extends Bert_Rpc_Error
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
