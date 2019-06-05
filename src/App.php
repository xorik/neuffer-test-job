<?php

namespace App;

use App\Exceptions\ActionException;
use App\Exceptions\InvalidArgumentException;

class App
{
    /** @var string */
    protected $action;
    /** @var string */
    protected $file;
    /** @var CsvParser */
    protected $csvParser;
    /** @var ActionFactory */
    protected $actionFactory;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(CsvParser $csvParser, ActionFactory $actionFactory)
    {
        $this->csvParser = $csvParser;
        $this->actionFactory = $actionFactory;
        $this->init();
    }

    /**
     * @throws Exceptions\FileIsNotExistsException
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        $data = $this->csvParser->load($this->file);
        $action = $this->actionFactory->createAction($this->action);

        foreach ($data as $line) {
            list($a, $b) = $line;

            try {
                $result = $action->calc($a, $b);
            } catch (ActionException $e) {
                // TODO: log
            }

            // TODO: save to file
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function init(): void
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
}
