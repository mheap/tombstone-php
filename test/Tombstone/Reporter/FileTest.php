<?php

namespace Tombstone\ReporterTest;

class FileTest extends \PHPUnit_Framework_TestCase
{

    protected $tempFile = null;

    public function tearDown()
    {
        if ($this->tempFile) {
            unlink($this->tempFile);
        }
        $this->tempFile = null;
    }

    public function testIsBasedOnInterface()
    {
        $this->tempFile = tempnam("/tmp", "tombstone_test");
        $this->assertInstanceOf("\\Tombstone\\Reporter", new \Tombstone\Reporter\File($this->tempFile));
    }

    public function testSavesMessageOnEmit()
    {
        $this->tempFile = tempnam("/tmp", "tombstone_test");

        $reporter = $this->getMock(
            "\\Tombstone\\Reporter\\File",
            array("getCurrentLocation", "getCurrentTime"),
            array($this->tempFile)
        );
        $reporter->method('getCurrentLocation')
                  ->willReturn(
                      '#0 /home/michael/tombstone-php/src/Tombstone/Reporter/File.php(19):'.
                      ' Tombstone\Reporter->getCurrentLocation()'
                  );
        $reporter->method('getCurrentTime')->willReturn(1234567890);

        $reporter->emit("2014-01-01", "Michael H");

        $output = file_get_contents($this->tempFile);

        $expected = "1234567890\n";
        $expected .= "2014-01-01\n";
        $expected .= "Michael H\n";
        $expected .= "#0 /home/michael/tombstone-php/src/Tombstone/Reporter/File.php(19):";
        $expected .= " Tombstone\Reporter->getCurrentLocation()\n\n";
        $this->assertEquals($expected, $output);
    }
}
