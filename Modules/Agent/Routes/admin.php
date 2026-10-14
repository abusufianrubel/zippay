<?php

use Illuminate\Support\Facades\Route;
use Modules\Agent\Http\Controllers\Admin\{AgentController, 
    FeesLimitController,
    AgentCashInController,
    TransactionController,
    AgentCashOutController,
    AgentPackageController,
    AgentRevenueController 
};

// Admin Panel section for Agent module
Route::group(config('addons.route_group.authenticated.admin'), function () {
    Route::group(['prefix' => 'agent', 'as' => 'admin.agents.'], function () {

        // Agent Package Routes
        Route::resource('packages', AgentPackageController::class)->except(['show', 'destroy']);
        Route::get('packages/destroy/{id}', [AgentPackageController::class, 'destroy'])->name('packages.destroy');

        // Agent Routes
        Route::group(['prefix' => 'agents', 'controller' => AgentController::class, 'as' => 'agents.'], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create')->middleware('permission:add_agent');
            Route::post('/', 'store')->name('store');
            Route::get('/{agent}', 'show')->name('show')->middleware('permission:view_agent');
            Route::get('/{agent}/edit', 'edit')->name('edit')->middleware('permission:edit_agent');
            Route::put('/{agent}', 'update')->name('update');
            Route::get('/destroy/{id}', 'destroy')->name('destroy');
        });
        Route::get('duplicate-email-check', [AgentController::class, 'duplicateEmailCheck'])->name('agents.email_check');
        Route::get('duplicate-phone-check', [AgentController::class, 'duplicatePhoneCheck'])->name('agents.phone_check');

        // Fees Limit Routes
        Route::resource('feeslimits', FeesLimitController::class)->except(['show', 'destroy']);

        // Admin deposit Routes
        Route::group(['controller' => TransactionController::class, 'as' => 'deposit.'], function () {
            Route::get('deposit/{id}', 'create')->name('create');
            Route::post('deposit/confim', 'confirm')->name('confirm');
            Route::post('deposit', 'store')->name('store');
            Route::post('deposit/amount-fees-limit-check', 'amountFeesLimitCheck')->name('feeslimit.check');
            Route::get('deposit/pdf/{id}', 'printpdf')->name('printpdf');
        });
        
        // Admin cashin Routes
        Route::group(['prefix' => 'cashin', 'controller' => AgentCashInController::class, 'as' => 'cashin.'], function () {
            Route::get('list', 'index')->name('index');
            Route::get('edit/{cashin}', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
            Route::get('search/user', 'cashinSearchUser')->name('search.user');
            Route::get('print/pdf', 'printPdf')->name('printpdf');
            Route::get('print/csv', 'printCsv')->name('printcsv');
        });
        
        // Admin cashout Routes
        Route::group(['prefix' => 'cashout', 'controller' => AgentCashOutController::class, 'as' => 'cashout.'], function () {
            Route::get('list', 'index')->name('index');
            Route::get('edit/{cashout}', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
            Route::get('search/user', 'cashoutSearchUser')->name('search.user');
            Route::get('print/pdf', 'printPdf')->name('printpdf');
            Route::get('print/csv', 'printCsv')->name('printcsv');
        });
        
        // Admin revenues Routes
        Route::group(['prefix' => 'revenues', 'controller' => AgentRevenueController::class, 'as' => 'revenues.'], function () {
            Route::get('list', 'index')->name('index');
            Route::get('print/pdf', 'printPdf')->name('printpdf');
            Route::get('print/csv', 'printCsv')->name('printcsv');
        });
    });
});