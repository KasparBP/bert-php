<?php
namespace Bert\Bert;

class Atom
{
    public static function bert()
    {
        return new Atom('bert');
    }

    public static function true()
    {
        return new Atom('true');
    }

    public static function false()
    {
        return new Atom('false');
    }

    public static function nil()
    {
        return new Atom('nil');
    }

    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function __toString()
    {
        return $this->_name;
    }
}
