<?php
namespace Bert\Bert\Rpc;

use Bert\Bert\Bert;
use Bert\Bert\Rpc\Action\Encodes;
use Bert\Bert\Rpc\Error\ConnectionError;
use Bert\Bert\Rpc\Error\ProtocolError;
use Bert\Bert\Rpc\Error\ReadError;
use Bert\Bert\Rpc\Error\ReadTimeoutError;
use Exception;

class Action
{
    private $_svc;
    private $_req;
    private $_mod;
    private $_fun;
    private $_args;

    public function __construct($svc, $req, $mod, $fun, $args)
    {
        $this->_svc = $svc;
        $this->_req = $req;
        $this->_mod = $mod;
        $this->_fun = $fun;
        $this->_args = $args;
    }

    public function execute()
    {
        $bertRequest = Encodes::encodeRequest(
            Bert::t(
                $this->_req->kind,
                $this->_mod,
                $this->_fun,
                $this->_args
            )
        );

        $bertResponse = $this->_transaction($bertRequest);
        return Encodes::decodeResponse($bertResponse);
    }

    // ---


    private function _write($sock, $bert)
    {
        socket_write($sock, pack('N', strlen($bert)));
        socket_write($sock, $bert);
    }

    private function _read($sock, $len, $timeout)
    {
        $data = '';
        $size = 0;

        while ($size < $len) {
            $r = array($sock);
            $w = array();
            $e = array();

            $n = socket_select($r, $w, $e, $timeout);
            if ($n === false) {
                throw new ConnectionError(
                    $this->_svc->host, $this->_svc->port,
                    socket_strerror(socket_last_error())
                );
            } elseif ($n === 0) {
                throw new ReadTimeoutError(
                    $this->_svc->host,
                    $this->_svc->port,
                    $this->_svc->timeout
                );
            }

            $bytes = socket_recvfrom($sock, $msg, $len - $size, 0, $name, $port);
            if ($bytes === false) {
                throw new ConnectionError(
                    $this->_svc->host, $this->_svc->port,
                    socket_strerror(socket_last_error())
                );
            } elseif ($bytes === 0) {
                throw new ReadError($this->_svc->host, $this->_svc->port);
            }

            $size += $bytes;
            $data .= $msg;
        }

        return $data;
    }

    private function _transaction($bertRequest)
    {
        $sock = $this->_connectTo($this->_svc->host, $this->_svc->port, $this->_svc->timeout);

        if (isset($this->_req->options)
            && isset($this->_req->options['cache'])
            && isset($this->_req->options['cache'][0])
            && $this->_req->options['cache'][0] == 'validation'
        ) {
            $token = $this->_req->options['cache'][1];
            $infoBert = Encodes::encodeRequest(array('info', 'cache', array('validation', $token)));
            $this->_write($infoBert);
        }

        $this->_write($sock, $bertRequest);
        $lenheader = $this->_read($sock, 4, $this->_svc->timeout);

        if (!$lenheader)
            throw new ProtocolError(ProtocolError::$NO_HEADER);

        $unpacked = unpack('N', $lenheader);
        $len = array_shift($unpacked);
        $bertResponse = $this->_read($sock, $len, $this->_svc->timeout);

        if (!$bertResponse)
            throw new ProtocolError(ProtocolError::$NO_DATA);

        socket_close($sock);

        return $bertResponse;
    }

    private function _connectTo($host, $port, $timeout = null)
    {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if (false === socket_set_option($sock, SOL_TCP, TCP_NODELAY, 1))
            throw new Exception('Unable to set option on socket: ' . socket_strerror(socket_last_error()));

        $sec = intval($timeout);
        $usec = intval(($timeout - $sec) * 1000000);

        if (false === socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $sec, "usec" => $usec)))
            throw new Exception('Unable to set option on socket: ' . socket_strerror(socket_last_error()));

        if (false === socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, array("sec" => $sec, "usec" => $usec)))
            throw new Exception('Unable to set option on socket: ' . socket_strerror(socket_last_error()));

        if (false === socket_connect($sock, $host, $port))
            throw new ConnectionError($host, $port, socket_strerror(socket_last_error()));

        return $sock;
    }
}
