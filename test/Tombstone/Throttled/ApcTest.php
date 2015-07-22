<?php

namespace TombstoneTest\Throttled;

class ApcTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        // Make sure APC is emptied before every test
        $t = new \Tombstone\Throttled\Apc;
        $t->resetApc();
    }

    public function testIsInstanceOfTombstoneThrottled()
    {
        $t = new \Tombstone\Throttled\Apc;
        $this->assertInstanceOf("\\Tombstone\\Throttled", $t);
    }

    public function testShouldTriggerFirstRequest()
    {
        $t = new \Tombstone\Throttled\Apc(null, 300);
        $this->assertTrue($t->shouldTrigger());
    }

    public function testShouldNotTriggerWithinThrottleTime()
    {
        $t = new \Tombstone\Throttled\Apc(null, 300);

        // Fake a tombstone to force an ::updateThrottle() call
        $t->register(null, null);
        $this->assertFalse($t->shouldTrigger());
    }

    public function testShouldTriggerAfterThrottleTime()
    {
        $t = new \Tombstone\Throttled\Apc(null, 1);

        $this->assertTrue($t->shouldTrigger());
        // Fake a tombstone to force an ::updateThrottle() call
        $t->register(null, null);
        $this->assertFalse($t->shouldTrigger());

        // Sleep until the throttle time has passed
        // At this point, we should not trigger as we're still marked
        // as flushing
        // @TODO Fix this so we don't need the sleep
        sleep(2);
        $this->assertFalse($t->shouldTrigger());

        // Now, we remove the flushing key and as our timeout
        // is past our throttle time it should work
        $t->resetApc(array("isFlushing"));
        $this->assertTrue($t->shouldTrigger());
    }

    public function testShouldTriggerImmediatelyWithZeroThrottleTime()
    {
        $t = new \Tombstone\Throttled\Apc(null, 0);

        $this->assertTrue($t->shouldTrigger("One"));

        // Reset isFlushing so that our register call will go through
        $t->resetApc(array("isFlushing"));

        // Fake a tombstone to force an ::updateThrottle() call
        $t->register(null, null);
        $this->assertTrue($t->shouldTrigger("Two"));
    }
}
