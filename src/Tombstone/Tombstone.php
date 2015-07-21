<?php

namespace Tombstone;

use Tombstone\Reporter\Memory;

class Tombstone
{

    protected $reporter;

    public function __construct($reporter = null)
    {

        $this->reporter = $reporter;

        // Default to a Memory reporter
        if (!$this->reporter) {
            $this->reporter = new Memory;
        }
    }

    private function getReporter()
    {
        return $this->reporter;
    }

    public function register($date, $author)
    {
        $this->reporter->emit($date, $author);
    }
}
