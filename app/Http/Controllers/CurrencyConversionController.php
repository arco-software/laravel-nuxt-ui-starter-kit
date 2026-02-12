<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyConversionRequest;

class CurrencyConversionController extends Controller
{
    public function __invoke(CurrencyConversionRequest $request): array
    {
        // TODO: Convert the currency

        return [];
    }
}
