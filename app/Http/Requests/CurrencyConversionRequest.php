<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyConversionRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'fromCurrency' => strtolower($this->fromCurrency),
            'toCurrency' => strtolower($this->toCurrency),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fromCurrency' => [
                'required',
                Rule::in(config('currencies')),
                'different:toCurrency',
            ],
            'toCurrency' => [
                'required',
                Rule::in(config('currencies')),
                'different:fromCurrency',
            ],
            'amount' => 'required|numeric|gt:0|multiple_of:0.01',
        ];
    }
}
