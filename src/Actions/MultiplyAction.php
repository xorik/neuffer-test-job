<?php

namespace App\Actions;

use App\Exceptions\ActionException;

class MultiplyAction implements ActionInterface
{
    /**
     * @param int $a
     * @param int $b
     *
     * @throws ActionException
     *
     * @return float
     */
    public function calc(int $a, int $b): float
    {
        $mult = $a * $b;

        if ($mult < 0) {
            throw new ActionException("numbers {$a} and {$b} are wrong");
        }

        return $mult;
    }
}
