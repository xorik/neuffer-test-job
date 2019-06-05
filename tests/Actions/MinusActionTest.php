<?php

namespace Actions;

use App\Actions\MinusAction;
use App\Exceptions\ActionException;
use PHPUnit\Framework\TestCase;

class MinusActionTest extends TestCase
{
    /** @var MinusAction */
    private $action;

    protected function setUp(): void
    {
        $this->action = new MinusAction();
    }

    public function testCalc()
    {
        $result = $this->action->calc(3, 2);

        $this->assertEquals(1, $result);
    }

    public function testCalcZero()
    {
        $result = $this->action->calc(2, 2);

        $this->assertEquals(0, $result);
    }

    public function testCalcLessThanZero()
    {
        $this->expectException(ActionException::class);
        $this->expectExceptionMessage('numbers 2 and 3 are wrong');

        $this->action->calc(2, 3);
    }
}
