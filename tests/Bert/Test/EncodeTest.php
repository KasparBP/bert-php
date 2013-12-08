<?php
namespace Bert\Test;

use Bert\Bert\Atom;
use Bert\Bert\Decode;
use Bert\Bert\Encode;
use Bert\Bert\Tuple;

class EncodeTest extends \PHPUnit_Framework_TestCase
{
    public function testEncodeSmallInteger()
    {
        $this->assertEquals(
            pack('c*', 131, 97, 42),
            Encode::encode(42)
        );
    }

    public function testEncodeInteger()
    {
        $this->assertEquals(
            pack('c*', 131, 98, 0, 0, 3, 232),
            Encode::encode(1000)
        );
    }

    public function testEncodeBignum()
    {
        $this->assertEquals(
            pack('c*', 131, 110, 2, 0, 100, 3),
            Encode::encode('868')
        );

        $this->assertEquals(
            pack('c*', 131, 110, 2, 1, 100, 3),
            Encode::encode('-868')
        );

        // 700 digit large bignum.. just check it can be encoded and decoded
        $largenum = str_repeat('1', 700);
        $this->assertEquals(
            $largenum,
            Decode::decode(Encode::encode($largenum))
        );
    }

    public function testEncodeFloat()
    {
        $this->assertEquals(
            pack('c*', 131, 99)."1.125000000000000e+0",
            Encode::encode(1.125)
        );
    }

    public function testEncodeAtom()
    {
        $this->assertEquals(
            pack('c*', 131, 100, 0, 4)."test",
            Encode::encode(new Atom('test'))
        );
    }

    public function testEncodeSmallTuple()
    {
        $this->assertEquals(
            pack('c*', 131, 104, 3, 97, 10, 97, 20, 97, 30),
            Encode::encode(new Tuple(array(10,20,30)))
        );
    }

    public function testEncodeLargeTuple()
    {
        $a = array_fill(0, 301, 42);

        $this->assertEquals(
            pack('c*', 131, 105, 0, 0, 1, 45) . str_repeat(pack('c*', 97, 42), 301),
            Encode::encode(new Tuple($a))
        );
    }

    public function testEncodeList()
    {
        $this->assertEquals(
            pack('c*', 131, 108, 0, 0, 0, 3, 97, 41, 97, 42, 97, 43, 106),
            Encode::encode(array(41,42,43))
        );
    }

    public function testEncodeEmptyList()
    {
        $this->assertEquals(
            pack('c*', 131, 106),
            Encode::encode(array())
        );
    }

    public function testEncodeNestedList()
    {
        $this->assertEquals(
            pack('c*', 131, 108, 0, 0, 0, 2, 97, 1, 108, 0, 0, 0, 1, 97, 2, 106, 106),
            Encode::encode(array(1, array(2)))
        );
    }

    public function testEncodeBinary()
    {
        $this->assertEquals(
            pack('c*', 131, 109, 0, 0, 0, 13)."hello world\x00\xFF",
            Encode::encode("hello world\x00\xFF")
        );
    }

}
