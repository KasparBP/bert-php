<?php
namespace Bert\Test;

use Bert\Ernie\Ernie;

class MyClass
{
    public function a() { }
    public function b() { }
}

class ErnieTest extends \PHPUnit_Framework_TestCase
{
    public function testMod()
    {
        $m = $this->getMock('MyClass');
        Ernie::mod('test', array(
            'a' => array($m, 'a'),
            'b' => array($m, 'b'),
        ));
        $m->expects($this->once())->method('a');
        $m->expects($this->once())->method('b');
        Ernie::dispatch('test', 'a', array());
        Ernie::dispatch('test', 'b', array());
    }

    public function testFun()
    {
        $m = $this->getMock('MyClass');
        Ernie::mod('test', array(
            'a' => array($m, 'a'),
        ));

        Ernie::fun('b', array($m, 'b'));
        $m->expects($this->once())->method('a');
        $m->expects($this->once())->method('b');

        Ernie::dispatch('test', 'a', array());
        Ernie::dispatch('test', 'b', array());
    }

    public function testExpose()
    {
        $m = $this->getMock('MyClass');

        Ernie::expose('test', $m);
        $m->expects($this->once())->method('a');
        $m->expects($this->once())->method('b');

        Ernie::dispatch('test', 'a', array());
        Ernie::dispatch('test', 'b', array());
    }


}
