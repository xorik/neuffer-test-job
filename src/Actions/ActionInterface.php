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
     * @return float
     */
    public function calc(int $a, int $b): float;
}
