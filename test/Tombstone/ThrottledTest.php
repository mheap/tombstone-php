<?php

namespace TombstoneTest;

class ThrottledTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInstanceOfTombstone()
    {
        $t = new \Tombstone\Throttled;
        $this->assertInstanceOf("\\Tombstone\\Tombstone", $t);
    }

    public function testDefaultThrottleTime()
    {
        $method = new \ReflectionMethod(
            '\\Tombstone\\Throttled',
            'getThrottleTime'
        );
        $method->setAccessible(true);

        $this->assertEquals(300, $method->invoke(new \Tombstone\Throttled));
    }

    public function testCustomThrottleTime()
    {
        $method = new \ReflectionMethod(
            '\\Tombstone\\Throttled',
            'getThrottleTime'
        );
        $method->setAccessible(true);

        $this->assertEquals(600, $method->invoke(new \Tombstone\Throttled(null, 600)));
    }
}
