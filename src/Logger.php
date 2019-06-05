<?php

namespace App;

class Logger
{
    const LOG_FILE = 'log.txt';

    protected $handle;

    public function __construct()
    {
        $this->handle = fopen(self::LOG_FILE, 'w+');
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    public function log(string $message): void
    {
        fwrite($this->handle, $message."\n");
        fflush($this->handle);
    }
}
