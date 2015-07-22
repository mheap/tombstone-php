<?php

namespace Tombstone\Reporter;

use Tombstone\Reporter;

class Memory extends Reporter
{

        public $entries = array();

        public function emit($date, $author)
        {
                $this->entries[] = $this->getCurrentTime().PHP_EOL.$date.PHP_EOL.$author.PHP_EOL.
                                   $this->getCurrentLocation().PHP_EOL.PHP_EOL;
        }
}
