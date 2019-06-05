<?php

namespace App\Actions;

use App\Exceptions\ActionException;

class MinusAction implements ActionInterface
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
        $diff = $a - $b;

        if ($diff < 0) {
            throw new ActionException("numbers {$a} and {$b} are wrong");
        }

        return $diff;
    }
}
