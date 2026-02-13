<?php

namespace App\Contracts;

interface CurrencyConversionDriver
{
    public function getName(): string;

    /**
     * Should return an array e.g.
     * [
     *   'EUR' => 1.2,
     *   'USD' => 1.4,
     *   ...
     * ]
     */
    public function getLatestRates(string $baseCurrency): array;
}
