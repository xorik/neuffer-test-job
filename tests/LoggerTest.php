<?php

namespace App;

use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testLog()
    {
        unlink(Logger::LOG_FILE);

        $logger = new Logger();
        $logger->log('first');
        $logger->log('second');
        $data = file_get_contents(Logger::LOG_FILE);

        $this->assertEquals("first\nsecond\n", $data);
    }
}
