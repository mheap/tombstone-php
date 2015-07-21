<?php

namespace Tombstone\Reporter;

use Tombstone\Reporter;

class Stdout extends Reporter
{

    public function emit($date, $author)
    {
        echo $this->getCurrentTime().PHP_EOL;
        echo $date.PHP_EOL;
        echo $author.PHP_EOL;
        echo $this->getCurrentLocation().PHP_EOL.PHP_EOL;
    }
}
