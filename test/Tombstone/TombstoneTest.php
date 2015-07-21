<?php

namespace TombstoneTest;

class TombstoneTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInstanceOfTombstone()
    {
        $t = new \Tombstone\Tombstone;
        $this->assertInstanceOf("\\Tombstone\\Tombstone", $t);
    }

    public function testDefaultReporterIsMemory()
    {
        $method = new \ReflectionMethod(
            '\\Tombstone\\Tombstone',
            'getReporter'
        );
        $method->setAccessible(true);

        $this->assertInstanceOf("\\Tombstone\\Reporter\\Memory", $method->invoke(new \Tombstone\Tombstone));
    }

    public function testReporterCanBeProvided()
    {
        $method = new \ReflectionMethod(
            '\\Tombstone\\Tombstone',
            'getReporter'
        );
        $method->setAccessible(true);

        $reporter = new \Tombstone\Reporter\Stdout;
        $this->assertInstanceOf("\\Tombstone\\Reporter\\Stdout", $method->invoke(new \Tombstone\Tombstone($reporter)));
    }

    public function testEmitWorks()
    {
        $reporter = $this->getMock("\\Tombstone\\Reporter\\Memory");
        $reporter->expects($this->once())->method("emit")->willReturn(null);

        $t = new \Tombstone\Tombstone($reporter);
        $t->register("2014-02-10", "Michael Heap");

    }
}
