<?php

namespace App\Services;

use function PHPUnit\Framework\assertTrue;

class CalcService
{
    public function sum($a, $b): int
    {
        return $a + $b;
    }
}
