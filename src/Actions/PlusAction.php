<?php

namespace App\Actions;

use App\Exceptions\ActionException;

class PlusAction implements ActionInterface
{
    /**
     * @param int $a
     * @param int $b
     *
     * @throws ActionException
     *
     * @return int
     */
    public function calc(int $a, int $b): int
    {
        $sum = $a + $b;

        if ($sum < 0) {
            throw new ActionException("numbers {$a} and {$b} are wrong");
        }

        return $sum;
    }
}
