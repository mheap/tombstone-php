<?php

namespace Tombstone\Throttled;

class Memory extends \Tombstone\Throttled
{

    protected $lastTriggerTime = 0;

    public function shouldTrigger()
    {
        if (time() >= ($this->lastTriggerTime + $this->getThrottleTime())) {
            return true;
        }

        return false;
    }

    protected function updateThrottle()
    {
        $this->lastTriggerTime = time();
    }
}
