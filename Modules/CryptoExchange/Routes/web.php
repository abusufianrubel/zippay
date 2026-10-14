<?php

use Illuminate\Support\Facades\Route;
use Modules\CryptoExchange\Http\Controllers\Admin\ExchangeDirectionController;
use Modules\CryptoExchange\Http\Controllers\Admin\CryptoExchangeController;
use Modules\CryptoExchange\Http\Controllers\Admin\CryptoExchangeSettingController;
use Modules\CryptoExchange\Http\Controllers\Users\CryptoExchangeManualController;
use Modules\CryptoExchange\Http\Controllers\CryptoExchangeController as UsersCryptoExchangeController;

Route::group(config('addons.route_group.authenticated.admin'), function () {

    Route::controller(ExchangeDirectionController::class)->name('admin.crypto_direction.')->group(function () {
        
        Route::get('exchange/directions', 'index')
            ->middleware(['permission:view_crypto_direction'])
            ->name('index');

        Route::get('exchange/getcurrency', 'getCurrency')
        ->name('currencies');

        Route::get('exchange/direction/create', 'create')
            ->middleware(['permission:add_crypto_direction'])
            ->name('create');

        Route::post('exchange/direction/store', 'store')
            ->name('store');

        Route::get('exchange/direction/edit/{id}', 'edit')
            ->middleware(['permission:edit_crypto_direction'])
            ->name('edit');

        Route::post('exchange/direction/update/{id}', 'update')
            ->name('update');

        Route::get('exchange/direction/delete/{id}', 'delete')
            ->middleware(['permission:delete_crypto_direction'])
            ->name('delete');

        Route::get('/crypto-direction-gateway', 'directionGateway')
            ->name('gateway');
    });

    Route::controller(CryptoExchangeController::class)->name('admin.crypto_exchanges.')->group(function () {

        Route::get('crypto_exchanges', 'index')
            ->middleware(['permission:view_crypto_exchange_transaction'])
            ->name('index');

        Route::get('crypto_exchanges/edit/{id}', 'edit')
            ->middleware(['permission:edit_crypto_exchange_transaction'])
            ->name('edit');

        Route::post('crypto_exchanges/update', 'update')
            ->middleware(['permission:edit_crypto_exchange_transaction'])
            ->name('update');

        Route::get('crypto_exchanges/user_search', 'exchangesUserSearch')
            ->name('user_search');

        Route::get('crypto_exchanges/csv', 'exchangeCsv')
            ->name('csv');
            
        Route::get('crypto_exchanges/pdf', 'exchangePdf')
            ->name('pdf');
    });

    // Settings
    Route::post('crypto_settings', [CryptoExchangeSettingController::class, 'store'])->middleware(['permission:view_crypto_exchange_settings'])->name('admin.crypto_setting_store');
    Route::get('crypto_settings', [CryptoExchangeSettingController::class, 'add'])->middleware(['permission:edit_crypto_exchange_settings'])->name('admin.crypto_settings');

});

# Crypto Exchange UnAuthenticated user
Route::group(['middleware' => ['crypto-available:guest_user' ]], function () {
    
    Route::controller(UsersCryptoExchangeController::class)->name('guest.crypto_exchange.')->group(function () {
        
        Route::get('crypto-exchange/create', 'cryptoExchange')
            ->name('home');

        Route::post('/crypto-exchange/verification', 'cryptoBuySell')
            ->name('verification');

        Route::get('/crypto-exchange/receiving-info', 'cryptoBuySellReceive')
            ->name('receiving_info');

        Route::post('/crypto-exchange/receiving-info', 'receivingInfoStore')
            ->name('store_receiving_info');

        Route::get('/crypto-exchange/payment', 'cryptoBuySellGateway')
            ->name('gateway');

        Route::get('/crypto-exchange/make-payment', 'cryptoBuySellPaymentGateway')
            ->name('payment-gateway');

        Route::post('/crypto-exchange/payment', 'cryptoBuySellPayment')
            ->name('payment');

        Route::post('/crypto-exchange/success', 'cryptoBuySellSuccess')
            ->name('buy_sell_success');

        Route::get('/crypto-exchange/gateway-success', 'cryptoPaymentSuccess')
            ->name('payment_success');

        Route::get('crypto-exchange/crypto-phone-verification', 'generatedPhoneVerificationCode')
            ->name('phone_verification');

        Route::get('crypto-exchange/crypto-email-verification', 'generatedEmailVerificationCode')
            ->name('email_verification');

        Route::get('crypto-exchange/crypto-phone-verification-complete', 'completePhoneVerification')
            ->name('phone_verification_success');

        Route::get('crypto-exchange/crypto-email-verification-complete', 'completeEmailVerification')
            ->name('email_verification_success');

        Route::get('/crypto-exchange/success', 'cryptoPaymentSuccess');

        Route::get('/crypto-exchange/complete', 'successView')
            ->name('view')
            ->withoutMiddleware('crypto-available:guest_user');
    });
});

# Request for Auth & Guest
Route::controller(UsersCryptoExchangeController::class)->name('guest.crypto_exchange.')->group(function () {

    Route::get('crypto-exchange/direction-currencies', 'directionCurrencies')
        ->name('direction_list');

    Route::get('crypto-exchange/direction-amount', 'getDirectionAmount')
        ->name('direction_amount');

    Route::get('crypto-exchange/get-direction-by-type', 'getTabDirection')
        ->name('direction_type');

    Route::get('crypto-exchange/track-transaction/{uuid}', 'trackTransaction')
        ->name('track_transaction');
});

# Authenticated User
Route::group(config('addons.route_group.authenticated.user'), function () {
    Route::controller(CryptoExchangeManualController::class)->middleware(['permission:manage_crypto_exchange', 'check-user-suspended', 'crypto-available:auth_user'])->group(function () {
        
        Route::get('crypto-exchange/buy-sell', 'exchange')
            ->name('user_dashboard.crypto_buy_sell.create');

        Route::post('crypto-buy-sell-confirm', 'exchangeOfCurrency')
            ->name('user_dashboard.crypto_buy_sell.confirm');

        Route::post('payment-via-gateway', 'paymentViaGateway')
            ->name('user_dashboard.crypto_buy_sell.gateway');

        Route::get('crypto-exchange/confirm', 'paymentConfirm')
            ->name('user_dashboard.crypto_buy_sell.payment_confirm');

        Route::post('exchange-of-crypto-success', 'exchangeOfCurrencyConfirm')
            ->name('user_dashboard.crypto_buy_sell.success');

        Route::get('crypto-buy-sell/success', 'cryptoExchangeSuccess')
            ->name('user_dashboard.crypto_buy_sell.success_page');

        Route::get('crypto-exchange/buy-sell-list', 'exchangeList')
            ->name('user_dashboard.crypto_buy_sell.list');
    });
});

Route::get('crypto-exchange/payment-complete', [CryptoExchangeManualController::class, 'gatewayPaymentComplete'])->name('user_dashboard.crypto_buy_sell.gateway_payment');

Route::get('crypto-buy-sell/print/{id}', [CryptoExchangeManualController::class, 'exchangeOfPrintPdf'])->name('crypto_exchange.print');

