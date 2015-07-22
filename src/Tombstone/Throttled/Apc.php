<?php

namespace Tombstone\Throttled;

class APC extends \Tombstone\Throttled
{

    const APC_PREFIX = "tombstone_";

    public function shouldTrigger($func = "UNKNOWN")
    {
        $lastTrigger = apc_fetch(self::APC_PREFIX.'resetTime');
        $isFlushing = apc_fetch(self::APC_PREFIX.'isFlushing');

        if (!$isFlushing && (time() >= ($lastTrigger + $this->getThrottleTime()))) {
            apc_store(self::APC_PREFIX.'isFlushing', true);
            return true;
        }

        return false;
    }

    protected function updateThrottle()
    {
        apc_store(self::APC_PREFIX.'resetTime', time());
        apc_delete(self::APC_PREFIX.'isFlushing');
    }


    /**
     * Reset all APC keys. Used in the tests only
     * @return void
     */
    public function resetApc($keys = array())
    {
        if (!count($keys)) {
            $keys = array("resetTime", "isFlushing");
        }

        foreach ($keys as $k) {
            apc_delete(self::APC_PREFIX.$k);
        }
    }
}
