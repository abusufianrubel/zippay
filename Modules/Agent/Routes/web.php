<?php

use Illuminate\Support\Facades\Route;
use Modules\Agent\Http\Controllers\QueueController;
use Modules\Agent\Http\Controllers\Agent\{
    AgentController,
    ProfileController,
    AgentCashInController,
    NewPasswordController,
    TransactionController,
    AgentCashOutController,
    PasswordResetLinkController,
    AuthenticatedSessionController
};


Route::get('agent/run-queue-work', [QueueController::class, 'runQueueWork']);

// Unauthenticated Agent
Route::group(['prefix' => 'agent', 'middleware' => ['no_auth:agent', 'locale']], function () {
        Route::get('/', function(){
            return redirect()->route('agent');
        });
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('agent');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('agent.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('agent.password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('agent.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('agent.password.store');
});

// Authenticated Agent
Route::group(['prefix' => 'agent', 'as' => 'agent.', 'middleware' => ['guest:agent', 'locale', 'agent_inactive']], function () {
    
    // Profile Information
    Route::group(['prefix' => 'profile', 'controller' => ProfileController::class, 'as' => 'profile.'], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
        Route::get('image', 'profileImage')->name('image');
        Route::post('image', 'imageUpdate')->name('image.update');
        Route::get('wallet', 'walletList')->name('wallet');
        Route::post('wallet/make-default', 'defaultWallet')->name('wallet.default');
        Route::post('password', 'updatePassword')->name('password.update');
        Route::post('phone-check', 'duplicatePhoneCheck')->name('duplicate_check.phone');
    });

    // Cashin Transaction
    Route::group(['prefix' => 'cashin', 'middleware' => 'agent_suspend',
     'controller' => AgentCashInController::class, 'as' => 'cashin.'], function () {
        Route::get('create', 'create')->name('create');
        Route::post('confirm', 'confirm')->name('confirm');
        Route::post('check-user', 'checkUser')->name('check_user');
        Route::post('success', 'success')->name('success');
        Route::get('success', 'successUrl')->name('success_url');
        Route::get('print/{id}', 'printPdf')->name('print')->withoutMiddleware('guest:agent');
        Route::post('manage-fees', 'manageFees')->name('manage-fees');
    });

    // Cashout Transaction
    Route::group(['prefix' => 'cashout', 'middleware' => 'agent_suspend',
    'controller' => AgentCashOutController::class, 'as' => 'cashout.'], function () {
        Route::get('create', 'create')->name('create');
        Route::post('confirm', 'confirm')->name('confirm');
        Route::post('success', 'success')->name('success');
        Route::get('success', 'successUrl')->name('success_url');
        Route::get('print/{id}', 'printPdf')->name('print')->withoutMiddleware('guest:agent');
        Route::post('manage-fees', 'manageFees')->name('manage-fees');
        Route::post('verify/{otp}', 'verifyOtp')->name('otp.verify');
        Route::post('resend-otp', 'resendOtp')->name('otp.resend');

        Route::post('currency/list', 'getCurrencyList')->name('currency.list');
    });

    // Transaction Info
    Route::group(['prefix' => 'transaction', 'controller' => TransactionController::class, 'as' => 'transaction.'], function () {
        Route::get('/', 'index')->name('index');
        Route::post('{id}', 'show')->name('show');
    });
    Route::get('dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');
    Route::get('deposit/print/{id}', [TransactionController::class, 'printPdf'])->name('deposit.print');

    //Settings
    Route::get('fail', [AgentController::class, 'fail'])->name('fail');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // Agent Status Check
    Route::get('check-agent-status', [AgentController::class, 'checkAgentStatus'])->name('status.check');
});
