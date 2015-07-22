<?php

namespace TombstoneTest\Throttled;

class MemoryTest extends \PHPUnit_Framework_TestCase
{

    public function testIsInstanceOfTombstoneThrottled()
    {
        $t = new \Tombstone\Throttled\Memory;
        $this->assertInstanceOf("\\Tombstone\\Throttled", $t);
    }

    public function testShouldTriggerFirstRequest()
    {
        $t = new \Tombstone\Throttled\Memory(null, 300);
        $this->assertTrue($t->shouldTrigger());
    }

    public function testShouldNotTriggerWithinThrottleTime()
    {
        $t = new \Tombstone\Throttled\Memory(null, 300);

        // Fake a tombstone to force an ::updateThrottle() call
        $t->register(null, null);
        $this->assertFalse($t->shouldTrigger());
    }

    public function testShouldTriggerAfterThrottleTime()
    {
        $t = new \Tombstone\Throttled\Memory(null, 1);

        $this->assertTrue($t->shouldTrigger());
        // Fake a tombstone to force an ::updateThrottle() call
        $t->register(null, null);
        $this->assertFalse($t->shouldTrigger());

        // Sleep until the throttle time has passed
        // @TODO Fix this so we don't need the sleep
        sleep(2);
        $this->assertTrue($t->shouldTrigger());
    }

    public function testShouldTriggerImmediatelyWithZeroThrottleTime()
    {
        $t = new \Tombstone\Throttled\Memory(null, 0);

        $this->assertTrue($t->shouldTrigger());
        // Fake a tombstone to force an ::updateThrottle() call
        $t->register(null, null);
        $this->assertTrue($t->shouldTrigger());
    }
}
