<?php

namespace Modules\CryptoExchange\Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencyPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            getCurrencyId('USD'),
            getCurrencyId('EUR')
        ];

        $paymentMethods = [Bank, Flutterwave];

        \App\Models\CurrencyPaymentMethod::whereIn('currency_id', $currencies)
        ->whereIn('method_id', $paymentMethods)
        ->get(['id', 'activated_for'])
        ->each(function ($paymentMethod) {
            $this->updateCurrencyPaymentMethodData($paymentMethod);
        });
        
    }

    private function updateCurrencyPaymentMethodData($currencyPaymentMethod)
    {
        $activatedFor = json_decode($currencyPaymentMethod->activated_for, true) ?? [];
        $activatedFor['crypto_buy'] = "";
        $currencyPaymentMethod->activated_for = json_encode($activatedFor);
        $currencyPaymentMethod->save();
    }
}
