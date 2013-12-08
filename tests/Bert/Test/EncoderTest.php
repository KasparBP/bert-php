<?php
namespace Bert\Test;

use Bert\Bert\Bert;
use Bert\Bert\Encoder;
use Bert\Bert\Regex;
use Bert\Bert\Time;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertBool()
    {
        $this->assertEquals(
            Bert::t(Bert::a('bert'), Bert::a('true')),
            Encoder::convert(true)
        );

        $this->assertEquals(
            Bert::t(Bert::a('bert'), Bert::a('false')),
            Encoder::convert(false)
        );

        $this->assertEquals(
            Bert::t(Bert::a('bert'), Bert::a('nil')),
            Encoder::convert(null)
        );
    }

    public function testConvertDict()
    {
        $this->assertEquals(
            Bert::t(Bert::a('bert'), Bert::a('dict'), array(array('a', 'b'))),
            Encoder::convert(array('a' => 'b'))
        );
    }

    public function testConvertTime()
    {
        $this->assertEquals(
            Bert::t(Bert::a('bert'), Bert::a('time'), 100, 200, 300),
            Encoder::convert(new Time(100, 200, 300))
        );
    }

    public function testConvertRegex()
    {
        $this->assertEquals(
            Bert::t(Bert::a('bert'), Bert::a('regex'), '.*?', array(Bert::a('caseless'))),
            Encoder::convert(new Regex('.*?', array('caseless')))
        );
    }

    public function testConvertRecursive()
    {
        $this->assertEquals(
            Bert::t(
                Bert::t(
                    Bert::t(Bert::a('bert'), Bert::a('true'))
                ),
                Bert::t(Bert::a('bert'), Bert::a('false'))
            ),
            Encoder::convert(Bert::t(Bert::t(true), false))
        );
    }


}
