<?php

use Illuminate\Support\Facades\Route;
use Modules\CryptoExchange\Http\Controllers\Api\CryptoExchangeApiController;

Route::group(['middleware' => ['auth:api-v2']], function() {
    Route::get('exchange-direction', [CryptoExchangeApiController::class, 'exchangeDirection']);
    Route::post('direction-to-currencies', [CryptoExchangeApiController::class, 'directionToCurrencies']);
    Route::post('direction-amount', [CryptoExchangeApiController::class, 'exchangeAmount']);
    Route::post('confirm-exchange', [CryptoExchangeApiController::class, 'confirmExchange']);
    Route::post('process-exchange', [CryptoExchangeApiController::class, 'cryptoExchangeProcess']);
});
