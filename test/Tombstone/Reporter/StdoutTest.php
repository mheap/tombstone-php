<?php

namespace Tombstone\ReporterTest;

class StdoutTest extends \PHPUnit_Framework_TestCase
{

    public function testIsBasedOnInterface()
    {
        $this->assertInstanceOf("\\Tombstone\\Reporter", new \Tombstone\Reporter\Stdout);
    }

    public function testSavesMessageOnEmit()
    {
        $reporter = $this->getMock("\\Tombstone\\Reporter\\Stdout", array("getCurrentLocation", "getCurrentTime"));
        $reporter->method('getCurrentLocation')
                  ->willReturn(
                      '#0 /home/michael/tombstone-php/src/Tombstone/Reporter/File.php(19):'.
                      ' Tombstone\Reporter->getCurrentLocation()'
                  );
        $reporter->method('getCurrentTime')->willReturn(1234567890);

        ob_start();
        $reporter->emit("2014-01-01", "Michael H");
        $output = ob_get_clean();

        $expected = "1234567890\n";
        $expected .= "2014-01-01\n";
        $expected .= "Michael H\n";
        $expected .= "#0 /home/michael/tombstone-php/src/Tombstone/Reporter/File.php(19):";
        $expected .= " Tombstone\Reporter->getCurrentLocation()\n\n";
        $this->assertEquals($expected, $output);
    }
}
