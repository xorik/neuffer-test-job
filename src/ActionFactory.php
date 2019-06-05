<?php

namespace App;

use App\Actions\ActionInterface;
use App\Actions\MinusAction;
use App\Actions\PlusAction;
use App\Exceptions\InvalidArgumentException;

class ActionFactory
{
    const ACTION_PLUS = 'plus';
    const ACTION_MINUS = 'minus';
    const ACTION_MULT = 'multiply';
    const ACTION_DIV = 'division';

    /**
     * @throws InvalidArgumentException
     */
    public function createAction(string $action): ActionInterface
    {
        switch ($action) {
            case self::ACTION_PLUS:
                return new PlusAction();
            case self::ACTION_MINUS:
                return new MinusAction();
            // TODO: finish
            default:
                throw new InvalidArgumentException('Invalid action: '.$action);
        }
    }
}
