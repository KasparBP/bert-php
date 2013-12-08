<?php
namespace Bert\Bert\Rpc\Error;

use Bert\Bert\Rpc\Bert_Rpc_Error;

class Bert_Rpc_Error_ProtocolError extends Bert_Rpc_Error
{
    public static $NO_HEADER = array(0, "Unable to read length header from server.");
    public static $NO_DATA = array(1, "Unable to read data from server.");
}
