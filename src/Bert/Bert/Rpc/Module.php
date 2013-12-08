<?php
namespace Bert\Bert\Rpc;

use Bert\Bert\Atom;

class Module
{
	private $_svc;
	private $_req;
	private $_mod;

	public function __construct($svc, $req, $mod)
	{
		$this->_svc = $svc;
		$this->_req = $req;
		$this->_mod = $mod;
	}

	public function __call($cmd, $args)
	{
		$action = new Action($this->_svc, $this->_req, $this->_mod, new Atom($cmd), $args);
		return $action->execute();
	}
}

