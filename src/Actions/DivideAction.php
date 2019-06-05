<?php

namespace App\Actions;

use App\Exceptions\ActionException;

class DivideAction implements ActionInterface
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
        if (0 === $b) {
            throw new ActionException("numbers {$a} and {$b} are wrong");
        }

        $result = $a / $b;

        if ($result < 0) {
            throw new ActionException("numbers {$a} and {$b} are wrong");
        }

        return $result;
    }
}
