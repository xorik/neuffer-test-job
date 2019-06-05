<?php

namespace App;

use App\Exceptions\InvalidArgumentException;

class ArgumentParser
{
    /** @var string */
    protected $action;
    /** @var string */
    protected $file;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $shortopts = 'a:f:';
        $longopts = [
            'action:',
            'file:',
        ];

        $options = getopt($shortopts, $longopts);

        if (isset($options['a'])) {
            $this->action = $options['a'];
        } elseif (isset($options['action'])) {
            $this->action = $options['action'];
        } else {
            throw new InvalidArgumentException('Action is not set');
        }

        if (isset($options['f'])) {
            $this->file = $options['f'];
        } elseif (isset($options['file'])) {
            $this->file = $options['file'];
        } else {
            throw new InvalidArgumentException('File is not set');
        }
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getFile(): string
    {
        return $this->file;
    }
}
