<?php
namespace Bert\Test;

use Bert\Bert\Atom;
use Bert\Bert\Decode;
use Bert\Bert\Tuple;

class DecodeTest extends \PHPUnit_Framework_TestCase
{
    public function testDecodeSmallInteger()
    {
        $this->assertEquals(42,
            Decode::decode(pack('c*', 131, 97, 42))
        );
    }

    public function testDecodeInteger()
    {
        $this->assertEquals(1000,
            Decode::decode(pack('c*', 131, 98, 0, 0, 3, 232))
        );
    }

    public function testDecodeBignum()
    {
        $this->assertEquals('868',
            Decode::decode(pack('c*', 131, 110, 2, 0, 100, 3))
        );

        $this->assertEquals('-868',
            Decode::decode(pack('c*', 131, 110, 2, 1, 100, 3))
        );
    }

    public function testDecodeFloat()
    {
        $this->assertEquals(1.125,
            Decode::decode(pack('c*', 131, 99) . "1.125000000000000e+0")
        );
    }

    public function testDecodeAtom()
    {
        $this->assertEquals(new Atom('test'),
            Decode::decode(pack('c*', 131, 100, 0, 4) . "test")
        );
    }

    public function testDecodeSmallTuple()
    {
        $this->assertEquals(new Tuple(array(10, 20, 30)),
            Decode::decode(pack('c*', 131, 104, 3, 97, 10, 97, 20, 97, 30))
        );
    }

    public function testDecodeLargeTuple()
    {
        $a = array_fill(0, 301, 42);
        $this->assertEquals(new Tuple($a),
            Decode::decode(pack('c*', 131, 105, 0, 0, 1, 45) . str_repeat(pack('c*', 97, 42), 301))
        );
    }

    public function testDecodeList()
    {
        $this->assertEquals(array(41, 42, 43),
            Decode::decode(pack('c*', 131, 108, 0, 0, 0, 3, 97, 41, 97, 42, 97, 43, 106))
        );
    }

    public function testDecodeEmptyList()
    {
        $this->assertEquals(array(),
            Decode::decode(pack('c*', 131, 106))
        );
    }

    public function testDecodeNestedList()
    {
        $this->assertEquals(array(1, array(2)),
            Decode::decode(pack('c*', 131, 108, 0, 0, 0, 2, 97, 1, 108, 0, 0, 0, 1, 97, 2, 106, 106))
        );
    }

    public function testDecodeBinary()
    {
        $this->assertEquals("hello world\x00\xFF",
            Decode::decode(pack('c*', 131, 109, 0, 0, 0, 13) . "hello world\x00\xFF")
        );
    }
}
