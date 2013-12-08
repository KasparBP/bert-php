<?php
namespace Bert\Bert\Rpc\Error;

use Bert\Bert\Rpc\Error;

class ConnectionError extends Error
{
    public function __construct($host, $port, $message = '')
    {
        parent::__construct("Unable to connect to $host:$port '$message'");
    }
}
