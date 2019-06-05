<?php

namespace Actions;

use App\Actions\DivideAction;
use App\Exceptions\ActionException;
use PHPUnit\Framework\TestCase;

class DivideActionTest extends TestCase
{
    /** @var DivideAction */
    private $action;

    protected function setUp(): void
    {
        $this->action = new DivideAction();
    }

    public function testCalc()
    {
        $result = $this->action->calc(4, 2);

        $this->assertEquals(2, $result);
    }

    public function testCalcFloat()
    {
        $result = $this->action->calc(1, 3);

        $this->assertEquals(0.3333333333333, $result);
    }

    public function testCalcZero()
    {
        $this->expectException(ActionException::class);
        $this->expectExceptionMessage('numbers 2 and 0 are wrong');

        $result = $this->action->calc(2, 0);
    }

    public function testCalcLessThanZero()
    {
        $this->expectException(ActionException::class);
        $this->expectExceptionMessage('numbers -2 and 2 are wrong');

        $this->action->calc(-2, 2);
    }
}
