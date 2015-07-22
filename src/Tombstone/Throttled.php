<?php

namespace Tombstone;

use Tombstone\Reporter\Memory;

class Throttled extends Tombstone
{

    protected $throttleTime = 300;

    public function __construct($reporter = null, $throttleTime = null)
    {
        if ($throttleTime !== null) {
            $this->throttleTime = $throttleTime;
        }

        return parent::__construct($reporter);
    }

    public function register($date, $author)
    {
        if ($this->shouldTrigger()) {
            $result = parent::register($date, $author);
            $this->updateThrottle();
            return $result;
        }
    }

    protected function getThrottleTime()
    {
        return $this->throttleTime;
    }
}
