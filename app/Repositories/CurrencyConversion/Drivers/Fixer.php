<?php

namespace App\Repositories\CurrencyConversion\Drivers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Contracts\CurrencyConversionDriver;

final class Fixer implements CurrencyConversionDriver
{
    const DRIVER_NAME = 'fixer';

    public function getName(): string
    {
        return self::DRIVER_NAME;
    }

    public function getLatestRates(string $baseCurrency, array $currenciesToFetch = []): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get(
            config('currencies.drivers.fixer.endpoints.latest'),
            [
                'access_key' => config('currencies.drivers.fixer.api-key'),
                'base' => $baseCurrency,
                'symbols' => $this->getCurrenciesToFetchParameter($currenciesToFetch),
            ]
        )->json();

        if (! $response['success']) {
            throw new Exception($response['error']['info'] ?? $response['error']['type'] ?? 'Fixer error');
        }

        return [
            'fetched_at' => Carbon::now(),
            'rates' => $response['rates'],
        ];
    }

    public function getCurrenciesToFetchParameter(array $currencies): string
    {
        $currencies = ! empty($currenciesToFetch)
            ? $currenciesToFetch
            : config('currencies.supported-currencies');

        return implode(',', $currencies);
    }
}
