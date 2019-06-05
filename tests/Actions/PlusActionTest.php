<?php

namespace Actions;

use App\Actions\PlusAction;
use App\Exceptions\ActionException;
use PHPUnit\Framework\TestCase;

class PlusActionTest extends TestCase
{
    /** @var PlusAction */
    private $action;

    protected function setUp(): void
    {
        $this->action = new PlusAction();
    }

    public function testCalc()
    {
        $result = $this->action->calc(2, 3);

        $this->assertEquals(5, $result);
    }

    public function testCalcZero()
    {
        $result = $this->action->calc(2, -2);

        $this->assertEquals(0, $result);
    }

    public function testCalcLessThanZero()
    {
        $this->expectException(ActionException::class);
        $this->expectExceptionMessage('numbers -2 and -2 are wrong');

        $this->action->calc(-2, -2);
    }
}
