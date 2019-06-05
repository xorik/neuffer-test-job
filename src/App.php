<?php

namespace App;

use App\Exceptions\ActionException;
use App\Exceptions\InvalidArgumentException;

class App
{
    protected const RESULT_FILE = 'result.csv';

    /** @var string */
    protected $action;
    /** @var string */
    protected $file;
    /** @var CsvParser */
    protected $csvParser;
    /** @var ActionFactory */
    protected $actionFactory;
    /** @var Logger */
    private $logger;

    /**
     * @param CsvParser     $csvParser
     * @param ActionFactory $actionFactory
     * @param Logger        $logger
     *
     * @throws InvalidArgumentException
     */
    public function __construct(CsvParser $csvParser, ActionFactory $actionFactory, Logger $logger)
    {
        $this->csvParser = $csvParser;
        $this->actionFactory = $actionFactory;
        $this->logger = $logger;
        $this->init();
    }

    /**
     * @throws Exceptions\FileIsNotExistsException
     * @throws Exceptions\OpenFileException
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        $data = $this->csvParser->load($this->file);
        $action = $this->actionFactory->createAction($this->action);

        // Log header
        $this->logger->log("Started {$this->action} operation");

        $input = [];
        foreach ($data as $line) {
            list($a, $b) = $line;

            try {
                $calcResult = $action->calc($a, $b);
                $input[] = [$a, $b, $calcResult];
            } catch (ActionException $e) {
                $this->logger->log($e->getMessage());
            }
        }

        $this->csvParser->save(self::RESULT_FILE, $input);
        $this->logger->log("Finished {$this->action} operation");
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
