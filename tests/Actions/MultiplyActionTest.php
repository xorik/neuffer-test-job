<?php

namespace Actions;

use App\Actions\MultiplyAction;
use App\Exceptions\ActionException;
use PHPUnit\Framework\TestCase;

class MultiplyActionTest extends TestCase
{
    /** @var MultiplyAction */
    private $action;

    protected function setUp(): void
    {
        $this->action = new MultiplyAction();
    }

    public function testCalc()
    {
        $result = $this->action->calc(2, 2);

        $this->assertEquals(4, $result);
    }

    public function testCalcZero()
    {
        $result = $this->action->calc(2, 0);

        $this->assertEquals(0, $result);
    }

    public function testCalcLessThanZero()
    {
        $this->expectException(ActionException::class);
        $this->expectExceptionMessage('numbers -2 and 2 are wrong');

        $this->action->calc(-2, 2);
    }
}
