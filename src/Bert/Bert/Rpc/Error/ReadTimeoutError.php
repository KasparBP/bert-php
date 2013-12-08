<?php
namespace Bert\Bert\Rpc\Error;

use Bert\Bert\Rpc\Error;

class ReadTimeoutError extends Error
{
    public $host;
    public $port;
    public $timeout;

    public function __construct($host, $port, $timeout)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;

        parent::__construct("No response from $host:$port in $timeout");
    }
}
