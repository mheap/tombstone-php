<?php

namespace Tombstone;

abstract class Reporter
{

    abstract public function emit($date, $author);

    public function getCurrentTime()
    {
        return time();
    }

    public function getCurrentLocation()
    {
        $e = new \Exception;
        return $e->getTraceAsString();
    }
}
