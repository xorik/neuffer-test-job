<?php

namespace App;

use App\Actions\DivideAction;
use App\Actions\MinusAction;
use App\Actions\MultiplyAction;
use App\Actions\PlusAction;
use App\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ActionFactoryTest extends TestCase
{
    /** @var ActionFactory */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new ActionFactory();
    }

    public function testCreateActionInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid action: unknown');

        $this->factory->createAction('unknown');
    }

    public function testCreateActionPlus()
    {
        $result = $this->factory->createAction('plus');

        $this->assertInstanceOf(PlusAction::class, $result);
    }

    public function testCreateActionMinus()
    {
        $result = $this->factory->createAction('minus');

        $this->assertInstanceOf(MinusAction::class, $result);
    }

    public function testCreateActionMultiply()
    {
        $result = $this->factory->createAction('multiply');

        $this->assertInstanceOf(MultiplyAction::class, $result);
    }

    public function testCreateActionDivide()
    {
        $result = $this->factory->createAction('division');

        $this->assertInstanceOf(DivideAction::class, $result);
    }
}
