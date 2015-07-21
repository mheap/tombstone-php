<?php

namespace Tombstone\Reporter;

use Tombstone\Reporter;

class File extends Reporter
{

    protected $filePath;

    public function __construct($filePath = null)
    {
        if (!$filePath) {
            $filePath = tempnam("/tmp", "tombstone_");
        }
        $this->filePath = $filePath;
    }

    public function emit($date, $author)
    {
        $data = $this->getCurrentTime().PHP_EOL.$date.PHP_EOL.$author.PHP_EOL.$this->getCurrentLocation().PHP_EOL.PHP_EOL;
        file_put_contents($this->filePath, $data, FILE_APPEND);
    }
}
