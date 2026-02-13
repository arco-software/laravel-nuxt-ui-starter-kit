<?php

namespace App\Repositories\CurrencyConversion;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Contracts\CurrencyConversionDriver;
use App\Repositories\CurrencyConversion\Drivers\Fixer;

final class CurrencyConverter
{
    private CurrencyConversionDriver $driver;

    public function __construct(
        private float $amount,
        private string $fromCurrency,
        private string $toCurrency,
        ?CurrencyConversionDriver $driver = null
    ) {
        $this->validateCurrencies();
        $this->resolveDriver($driver);
    }

    private function validateCurrencies(): void
    {
        foreach ([$this->fromCurrency, $this->toCurrency] as $currency) {
            if (! in_array($currency, config('currencies.supported-currencies'))) {
                throw new Exception(sprintf('%s is not a supported currency.', $currency));
            }
        }
    }

    private function resolveDriver(?CurrencyConversionDriver $driver = null)
    {
        if ($driver) {
            $this->driver = new $driver;
        }

        $this->driver = match (config('currencies.driver')) {
            'fixer' => new Fixer,
            default => new Fixer,
        };
    }

    private function getCachedRatesKey(): string
    {
        return sprintf('%s:%s', $this->driver->getName(), $this->fromCurrency);
    }

    private function getRates(): array
    {
        return Cache::remember(
            $this->getCachedRatesKey(),
            Carbon::now()->addMinutes(config('currencies.minutes-between-lookups')),
            fn () => $this->driver->getLatestRates($this->fromCurrency)
        );
    }

    /**
     * Should return array in the format of
     * [
     *      'correct_at' => Carbon date object
     *      'amount' => float value
     * ]
     */
    public function convert(): array
    {
        $amountMultiplied = $this->amount * 100;

        $rates = $this->getRates();

        $exchangeRate = $rates['rates'][$this->toCurrency];

        $convertedAmount = ceil($amountMultiplied * $exchangeRate) / 100;

        return [
            'from' => [
                'currency' => $this->fromCurrency,
                'amount' => $this->amount,
            ],
            'to' => [
                'currency' => $this->toCurrency,
                'amount' => $convertedAmount,
            ],
            'correct_at' => $rates['fetched_at'],
        ];
    }
}
