<?php

namespace Bert\Ernie;

class Module
{
    private $_name;
    private $_funs = array();

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function fun($name, $callback)
    {
        $this->_funs[$name] = $callback;
    }

    public function getFun($name)
    {
        return isset($this->_funs["$name"])
            ? $this->_funs["$name"]
            : null;
    }

    public function __toString()
    {
        return "$this->_name";
    }
} 