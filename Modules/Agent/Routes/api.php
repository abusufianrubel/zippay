<?php

use Illuminate\Support\Facades\Route;
use Modules\Agent\Http\Controllers\Api\V2\{
    AgentController,
    ProfileController,
    DashboardController,
    AgentCashInController,
    NewPasswordController,
    TransactionController,
    AgentCashOutController,
    PasswordResetLinkController,
    ForgotPasswordController
};

Route::group(['prefix' => 'agent'], function () {
    Route::post('login', [AgentController::class, 'store']);
    Route::post('preference', [AgentController::class, 'preferenceSettings']);
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);
    Route::post('reset-password', [NewPasswordController::class, 'store']);

    Route::post('password-forgot', [ForgotPasswordController::class, 'forgetPassword']);
    Route::post('password-forgot/verify', [ForgotPasswordController::class, 'verifyResetCode']);
    Route::post('password-forgot/store', [ForgotPasswordController::class, 'confirmNewPassword']);
});

Route::group(['prefix' => 'agent', 'middleware' => ['agent_auth', 'agent_inactive']], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard']);

    Route::group(['controller' => ProfileController::class], function(){
        Route::get('profile', 'show');
        Route::post('profile', 'update');
        Route::post('check-duplicate-phone', 'duplicatePhone');
        Route::post('update-password', 'updatePassword');
        Route::post('update-profile-img', 'updateProfileImg');
        Route::get('wallet-list', 'walletList');
        Route::post('wallet-make-default', 'defaultWallet');

        Route::post('logout', 'destroy');
    });

    Route::group(['controller' => TransactionController::class], function(){
        Route::get('payment-method', 'getPaymentMethod');
        Route::get('transaction-list', 'transactionList');
        Route::get('transaction-details/{id}', 'transactionDetails');
    });

    Route::group(['middleware' => 'agent_suspend', 'controller' => AgentCashInController::class], function(){
        Route::get('deposit-currency-list', 'currencyWalletList');
        Route::post('deposit-amount-limit', 'amountLimit');
        Route::post('get-user', 'getUser');
        Route::post('balance-check', 'balanceCheck');
        Route::post('deposit-confirm', 'store');
    });
    
    Route::group(['middleware' => 'agent_suspend', 'controller' => AgentCashOutController::class], function(){
        Route::post('withdrawal-currency-list', 'withdrawalCurrencyList');
        Route::post('user-balance-check', 'userBalanceCheck');
        Route::post('withdrawal-otp-send', 'withdrawalOtp');
        Route::post('withdrawal-confirm', 'store');
    });
});
