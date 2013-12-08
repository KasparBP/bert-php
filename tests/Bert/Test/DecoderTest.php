<?php
namespace Bert\Test;

use Bert\Bert\Bert;
use Bert\Bert\Decoder;
use Bert\Bert\Regex;
use Bert\Bert\Time;

class DecoderTest extends \PHPUnit_Framework_TestCase
{
    public function testDecodeBool()
    {
        $this->assertEquals(true, Decoder::decode(Bert::encode(true)));
        $this->assertEquals(false, Decoder::decode(Bert::encode(false)));
        $this->assertEquals(null, Decoder::decode(Bert::encode(null)));
    }

    public function testDecodeRegex()
    {
        $bert = Bert::encode(new Regex('hello', array('caseless')));
        $this->assertEquals(
            new Regex('hello', array('caseless')),
            Decoder::decode($bert)
        );
    }

    public function testDecodeTime()
    {
        $bert = Bert::encode(new Time(100, 200, 300));

        $this->assertEquals(
            new Time(100, 200, 300),
            Decoder::decode($bert)
        );
    }

    public function testDecodeDict()
    {
        $bert = Bert::encode(array('a' => 'b'));
        $this->assertEquals(
            array('a' => 'b'),
            Decoder::decode($bert)
        );
    }

}
