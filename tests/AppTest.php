<?php

namespace App;

use App\Actions\ActionInterface;
use App\Exceptions\ActionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    const INPUT_FILE = 'input.csv';
    const ACTION = 'test';

    /** @var MockObject */
    private $argumentParser;
    /** @var MockObject */
    private $csvParser;
    /** @var MockObject */
    private $actionFactory;
    /** @var MockObject */
    private $logger;
    /** @var App */
    private $app;

    protected function setUp(): void
    {
        $this->argumentParser = $this->createMock(ArgumentParser::class);
        $this->csvParser = $this->createMock(CsvParser::class);
        $this->actionFactory = $this->createMock(ActionFactory::class);
        $this->logger = $this->createMock(Logger::class);

        $this->argumentParser->expects($this->once())
            ->method('getFile')
            ->willReturn(self::INPUT_FILE)
        ;

        $this->argumentParser->expects($this->once())
            ->method('getAction')
            ->willReturn(self::ACTION)
        ;

        $this->app = new App($this->argumentParser, $this->csvParser, $this->actionFactory, $this->logger);
    }

    public function testRun()
    {
        $action = $this->createMock(ActionInterface::class);

        // Load csv
        $this->csvParser->expects($this->once())
            ->method('load')
            ->with(self::INPUT_FILE)
            ->willReturn([[1, 2], [3, 4]])
        ;

        // Get action
        $this->actionFactory->expects($this->once())
            ->method('createAction')
            ->with(self::ACTION)
            ->willReturn($action)
        ;

        // Calc action
        $action->expects($this->at(0))
            ->method('calc')
            ->with(1, 2)
            ->willReturn(3)
        ;
        $action->expects($this->at(1))
            ->method('calc')
            ->with(3, 4)
            ->willReturn(7)
        ;

        $this->csvParser->expects($this->once())
            ->method('save')
            ->with(App::RESULT_FILE, [
                [1, 2, 3],
                [3, 4, 7],
            ])
        ;

        $this->app->run();
    }

    public function testRunLogging()
    {
        $action = $this->createMock(ActionInterface::class);
        $message = 'Some message';

        // Load csv
        $this->csvParser->expects($this->once())
            ->method('load')
            ->with(self::INPUT_FILE)
            ->willReturn([[1, 2], [3, 4]]);

        // Get action
        $this->actionFactory->expects($this->once())
            ->method('createAction')
            ->with(self::ACTION)
            ->willReturn($action)
        ;

        // Calc action (first throws an exception)
        $action->expects($this->at(0))
            ->method('calc')
            ->with(1, 2)
            ->willThrowException(new ActionException($message))
        ;
        $action->expects($this->at(1))
            ->method('calc')
            ->with(3, 4)
            ->willReturn(7)
        ;

        $this->csvParser->expects($this->once())
            ->method('save')
            ->with(App::RESULT_FILE, [
                [3, 4, 7],
            ])
        ;

        // Check logger
        $this->logger->expects($this->at(0))
            ->method('log')
            ->with('Started test operation')
        ;

        $this->logger->expects($this->at(1))
            ->method('log')
            ->with($message)
        ;

        $this->logger->expects($this->at(2))
            ->method('log')
            ->with('Finished test operation')
        ;

        $this->app->run();
    }
}
