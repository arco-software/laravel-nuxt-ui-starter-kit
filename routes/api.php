<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConversionController;

Route::post('convert-currency', CurrencyConversionController::class);
