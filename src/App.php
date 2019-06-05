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
     */
    public function __construct(ArgumentParser $argumentParser, CsvParser $csvParser, ActionFactory $actionFactory, Logger $logger)
    {
        $this->action = $argumentParser->getAction();
        $this->file = $argumentParser->getFile();
        $this->csvParser = $csvParser;
        $this->actionFactory = $actionFactory;
        $this->logger = $logger;
    }

    /**
     * @throws Exceptions\FileIsNotExistsException
     * @throws Exceptions\OpenFileException
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        $input = $this->csvParser->load($this->file);
        $action = $this->actionFactory->createAction($this->action);

        // Log header
        $this->logger->log("Started {$this->action} operation");

        $output = [];
        foreach ($input as $line) {
            list($a, $b) = $line;

            try {
                $calcResult = $action->calc($a, $b);
                $output[] = [$a, $b, $calcResult];
            } catch (ActionException $e) {
                $this->logger->log($e->getMessage());
            }
        }

        $this->csvParser->save(self::RESULT_FILE, $output);
        $this->logger->log("Finished {$this->action} operation");
    }
}
