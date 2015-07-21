<?php

namespace Tombstone\ReporterTest;

class MemoryTest extends \PHPUnit_Framework_TestCase
{

    public function testIsBasedOnInterface()
    {
        $this->assertInstanceOf("\\Tombstone\\Reporter", new \Tombstone\Reporter\Memory);
    }

    public function testStartsWithNoMessages()
    {
        $reporter = new \Tombstone\Reporter\Memory;
        $expected = array();
        $this->assertEquals($expected, $reporter->entries);
    }

    public function testSavesMessageOnEmit()
    {
        $reporter = $this->getMock("\\Tombstone\\Reporter\\Memory", array("getCurrentLocation", "getCurrentTime"));
        $reporter->method('getCurrentLocation')
                  ->willReturn(
                      '#0 /home/michael/tombstone-php/src/Tombstone/Reporter/File.php(19):'.
                      ' Tombstone\Reporter->getCurrentLocation()'
                  );
        $reporter->method('getCurrentTime')->willReturn(1234567890);

        $reporter->emit("2014-01-01", "Michael H");

        $expected = "1234567890\n";
        $expected .= "2014-01-01\n";
        $expected .= "Michael H\n";
        $expected .= "#0 /home/michael/tombstone-php/src/Tombstone/Reporter/File.php(19):";
        $expected .= " Tombstone\Reporter->getCurrentLocation()\n\n";
        $expected = array($expected);

        $this->assertEquals($expected, $reporter->entries);
    }
}
