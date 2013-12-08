<?php
namespace Bert\Bert\Rpc;

use Bert\Bert\Atom;

class Request
{
	private $_svc;
	public $kind;
	public $options;

	public function __construct($svc, $kind, $options)
	{
		$this->_svc = $svc;
		$this->kind = $kind;
		$this->options = $options;
	}

	public function __call($cmd, $args)
	{
		return new Module($this->_svc, $this, new Atom($cmd));
	}
}
