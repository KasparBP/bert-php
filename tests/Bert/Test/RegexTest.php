<?php
namespace Bert\Test;

use Bert\Bert\Regex;

class RegexTest extends \PHPUnit_Framework_TestCase
{
    public function testBasic()
    {
        $this->assertEquals(
            new Regex('hello.*', array('caseless', 'multiline')),
            Regex::fromString('/hello.*/im')
        );
    }

    public function testEscapeSource()
    {
        $r = Regex::fromString('/hel\/lo/');

        $this->assertEquals(
            'hel/lo',
            $r->source
        );

        $this->assertEquals(
            '/hel\/lo/',
            "$r"
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testDodgyRegex()
    {
        Regex::fromString('missing slashes');
    }

    /**
     * @expectedException \Exception
     */
    public function testDodgyOptions()
    {
        Regex::fromString('/hello/xyz');
    }
}
