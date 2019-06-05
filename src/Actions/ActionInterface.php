<?php

namespace App\Actions;

use App\Exceptions\ActionException;

interface ActionInterface
{
    /**
     * @param int $a
     * @param int $b
     *
     * @throws ActionException
     *
     * @return int
     */
    public function calc(int $a, int $b): int;
}
