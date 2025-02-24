<?php

declare(strict_types=1);

namespace TDD;

class CalculatorService
{
    
    function sum(int $x, int $y): int
    {
        return $x + $y;
    }

    function division(int $x, int $y): int
    {

        if ($x <= 0) {
            throw new \Exception("Error Processing Request", 1);
        }

        return $x / $y;
    }

}
