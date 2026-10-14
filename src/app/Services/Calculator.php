<?php

namespace App\Services;

class Calculator
{
    /**
     * 2つの数を足す
     */
    public function add(int|float $a, int|float $b): int|float 
    {
        return $a + $b;
    }

    /**
     * 2つの数を掛ける
     */
    public function multiply(int|float $a, int|float $b): int|float 
    {
        return $a - $b;
    }
}