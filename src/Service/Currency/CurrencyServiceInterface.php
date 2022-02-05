<?php

namespace App\Service\Currency;

interface CurrencyServiceInterface
{
    public function convertor(float $price,string $code): float;
}